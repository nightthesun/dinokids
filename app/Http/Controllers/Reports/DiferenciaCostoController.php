<?php

namespace App\Http\Controllers\Reports;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use DataTables; 

class DiferenciaCostoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = 
        "SELECT inalmCalm as id, inalmNomb as alm
        FROM inalm
        WHERE 
        inalmCalm IN
        (
            SELECT intraCalm
            FROM intra 
            WHERE intraMdel = 0
            GROUP BY intraCalm
        )
        ORDER BY inalmNomb";
        $almacenes = DB::connection('sqlsrv')->select(DB::raw($query));
        return view('reports.diferenciacosto', compact('almacenes')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function products(Request $request){
        $alm = $request->alm;
        $query = 
        "WITH tab AS
        (
            SELECT 
            intrdCpro as Prod,
            intraCalm as Calm,
            intrdCanb, 
            intrdCTmi,
            CASE WHEN intraTtra = 1 THEN 1 ELSE 0 END ingreso,
            CASE WHEN intraTtra = 2 THEN 1 ELSE 0 END salida,
            insalCupb,
            CASE WHEN intrdCanb = 0 THEN 0
            ELSE
            ABS((intrdCTmi/intrdCanb)-insalCupb)
            END
            as dif
            FROM intra
            JOIN intrd ON intraNTra = intrdNtra AND intraMdel = 0 
            LEFT JOIN insal ON insalCpro = intrdCpro AND intraCalm = insalCalm
        )
        SELECT 
        Prod, 
        inalmNomb as alm,
        /*CASE SUM(intrdCanb)
        WHEN 0 THEN CAST(0 as money)
        ELSE CAST(SUM(intrdCTmi)/SUM(intrdCanb) as money)
        END as CostProm,*/
        CONVERT(varchar, CAST(insalCupb as money), 1) as costo,
        CONVERT(varchar, CAST(SUM(dif) as money),1) as dif,
        CONVERT(varchar, CAST(MAX(dif) as money),1) as difmax,
        SUM(ingreso) as ingresos,
        SUM(salida) as salidas
        FROM tab
        JOIN inalm ON inalmCalm = Calm    
        WHERE Calm = ".$alm."
        GROUP BY Prod, inalmNomb, inalmCalm, insalCupb
        --HAVING AVG(dif) <> 0
        ";
        $ventas = DB::connection('sqlsrv')->select(DB::raw($query)); 
        return Datatables::of($ventas)
        ->with([
            "titulos"=>"XD"
         ])
        ->make(); 
    }
    
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $prod = $request->prod;
        $alm = $request->alm;
        $query = 
        "DECLARE @Cpro nvarchar(9),@Calm int
        SELECT @Cpro = '".$prod."', @Calm = '".$alm."'
        SELECT intrdNtra, intrdClot, intrdCpro, intrdItem, intrdCant, intrdUmtr, intrdCanb, intrdUmbs,         
        intrdCTmt, intrdCTmi, intrdMtra, intrdMinv, intrdTipo, intrdMdel,intraNtrI as _Ntri, intraTtra as _Ttra, 
        intraTmov as _Tmov,          
        intraFtra as _Ftra, intraCalm as _Calm , 
        Case 
            When intrdCanb = 0 Then 0 
            Else intrdCTmi/intrdCanb 
            End as _CostUnit, 
        inproCumb as _Cumb,           
        admonAbrv as _admonAbrv, 
        CAST (0.0 as float) _CantAcum, 
        CAST (0.0 as float) _CostAvg, 
        CAST (0.0 as float) _Diferencia,
        CAST (0.0 as float) _CostAcum
        into #Mov_Prod  
        FROM intra             
        JOIN intrd On (intraNtra = intrdNtra And intrdMdel = 0)              
        JOIN inpro On (intrdCpro = inproCpro)              
        JOIN inalm On (intraCalm = inalmCalm)              
        JOIN bd_admOlimpia.dbo.admon  ON (intrdMinv = admonCmon)  
        WHERE intraMdel = 0 And intrdCanb <> 0 And inproCpro = @Cpro 
        AND inalmCalm = @Calm  
        ORDER BY  intraFtra,intraNtra   
                        
        DECLARE @CantidadUpdate as float, @CantidadUpdAnt as float,
        @CostUPB as float, @CostUPBAnt as float, @Diferencia as float,
        @CostoUpdate as float, @CostoUpdAnt as float
                
        DECLARE @CodProd as varchar(50), @item As Integer, @Ntra As Integer     
        DECLARE @Cantidad as float, @CostoUnit as float, @CostTot as float  
                
        DECLARE MovProd_CURSOR 
        CURSOR FOR SELECT intrdCpro, intrdItem, intrdNtra,intrdCanb,_CostUnit,intrdCTmi
        FROM #Mov_Prod 
        ORDER BY  _Ftra, intrdNtra      
                
        OPEN MovProd_CURSOR  
                
        FETCH NEXT FROM MovProd_CURSOR INTO @CodProd,@item,@Ntra,@Cantidad,@CostoUnit,@CostTot   
                
        SET @CantidadUpdAnt = 0  
        SET @CostoUpdAnt = 0 
        DECLARE @IsFirstRow as bit = 1
                
        WHILE @@FETCH_STATUS = 0      
        BEGIN      
        SET @CantidadUpdate = @CantidadUpdAnt + @Cantidad;    
        SET @CostoUpdate = @CostoUpdAnt + @CostTot; 
        IF (@IsFirstRow = 1) 
            BEGIN              
                SET @CostUPB = @CostTot / @Cantidad;              
                SET @IsFirstRow= 0;         
            END 
        ELSE 
            BEGIN            
                IF( ABS(ROUND(@CantidadUpdate,6))= 0 ) 
                    BEGIN               
                        SET   @CantidadUpdate=0               
                    END     
                IF( ABS(ROUND(@CostoUpdate,6))= 0 ) 
                    BEGIN               
                        SET   @CostoUpdate=0               
                    END  
                If (@Cantidad>0 AND  @CantidadUpdate > 0) 
                    BEGIN                  
                        SET @CostUPB = (@CostTot + (@CostUPBAnt * @CantidadUpdAnt)) / @CantidadUpdate;              
                    END 
                ELSE 
                    BEGIN                  
                        SET @CostUPB = @CostUPBAnt;              
                    END          
            END          
        SET @CostUPB = ROUND(@CostUPB,5);          
        SET @CostoUnit = ROUND(@CostoUnit,5);         
        SET @Diferencia = @CostUPB - @CostoUnit;          
        SET @CostUPBAnt = @CostUPB;     
        SET @CantidadUpdAnt = @CantidadUpdate;      
        SET @CostoUpdAnt = @CostoUpdate; 

        UPDATE #Mov_Prod SET _CantAcum=@CantidadUpdate, _CostAvg=@CostUPB, _Diferencia=@Diferencia, _CostAcum = @CostoUpdate          
        WHERE intrdCpro=@CodProd AND intrdItem=@item AND intrdNtra=@Ntra 
                
        FETCH NEXT FROM MovProd_CURSOR            
        INTO @CodProd,@item,@Ntra,@Cantidad,@CostoUnit,@CostTot       
        END         
        CLOSE MovProd_CURSOR;        
        DEALLOCATE MovProd_CURSOR;      
        ";
        $insert = DB::connection('sqlsrv')->unprepared(DB::raw($query));
        $movimientos = DB::connection('sqlsrv')
        ->select(DB::raw(
        "SELECT 
        intrdCpro as _Cpro,
        inproNomb as ProdDesc,
        intrdNtra as _Ntra,
        CONVERT(varchar,_Ftra,103) as _Ftra,
        intrdCanb as _Canb,
        CONVERT(varchar, CAST(_CostUnit as decimal(10,4)),1) as _CostUnit,
        CONVERT(varchar, CAST(intrdCTmi as decimal(10,4)),1) as _CTmi,
        CONVERT(varchar, CAST(_CostAcum as decimal(10,4)),1) as _CostAcum,
        --CONVERT(varchar, CAST(intrdCTmt as money),1) as _CTmt,        
        --intrdCant as _Cant,
        --intrdClot as _Clot,        
        --intrdItem as _Item,
        --intrdMdel as _Mdel,
        --intrdMinv as _Minv,
        _admonAbrv,
        --intrdMtra as _Mtra,       
        --intrdTipo as _Tipo,
        --intrdUmbs as _Umbs,
        --intrdUmtr as _Umtr,
        _Calm,
        _CantAcum,
        CONVERT(varchar, CAST(_CostAvg as decimal(10,4)),1) as _CostAvg,        
        _Cumb,
        CONVERT(varchar, CAST(_Diferencia as decimal(10,4)),1) as _Diferencia,
        _Ntri,
        maTmoNomb as _TmovN,
        _Ttra as Ttra        
        FROM #Mov_Prod
        JOIN maTmo ON _Tmov = maTmoItem
        LEFT JOIN inpro ON inproCpro = intrdCpro
        ORDER BY _Ntra, _Ftra
        "));
        //return response()->json($movimientos);

        $produ = 
        "SELECT inproCpro as Produ, inproNomb as ProdNomb 
        FROM inpro WHERE inproMDel = 0 AND inproCpro = '".$prod."'";
        $produ = DB::connection('sqlsrv')->select($produ);
        return Datatables::of($movimientos)
        ->with([
            "producto"=>$produ[0],
         ])
        ->make(); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
