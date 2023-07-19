<?php

namespace App\Http\Controllers;

//use App\Cotizacion_report;

use App\Cotizacion_report; 
use Illuminate\Http\Request;
use App\User;
use DB;
use PDF;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CuentasPorCobrarExport;
use App\Exports\ReporteCotizacion;
use App\Exports\ReporteCotizacionExport;
use App\observacion_estados;
use App\ObservacionCotizacion;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Expr\Cast;
use Observaciones;
//use App\Providers\Cotizacion_report;


class CotizacionReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        
        $this->middleware('auth');
    }


    public function index()
    {
        if(Auth::user()->authorizePermisos(['Reporte de cotizacion', 'Ver usuarios DualBiz']))
        {
            $usuario= "";
        }
        else if (Auth::user()->authorizePermisos(['Reporte de cotizacion', 'Ver usuarios OAS']))
        {
            $users= User::where('dbiz_user','<>',NULL)->get()->pluck('dbiz_user')->toArray();
            $users= implode(",", $users);
            $usuario ="AND adusrCusr IN (".$users.")";
        }
        else{
            if(Auth::user()->dbiz_user == null)
            {
                $usuario= "AND adusrCusr = null";
            }
            else
            {
            $usuario= "AND adusrCusr = ".Auth::user()->dbiz_user;
            }
        }
        $query = 
        "SELECT * 
        FROM bd_admOlimpia.dbo.adusr 
        WHERE adusrMdel = 0 ".$usuario."
        AND (adusrCusr IN 
        (
            SELECT vtvtaCusr
            FROM vtvta
            GROUP BY vtvtaCusr
        ))
        ORDER BY adusrNomb";
        $usr = DB::connection('sqlsrv')->select(DB::raw($query));
        $user = collect($usr);
        $consultaListaEmpleados = "select adusrNomb as 'nombreX',adusrCusr as 'codigoX' from bd_admOlimpia.dbo.adusr where 
        adusrNomb ='BENIGNA TINTA'
        OR adusrNomb ='ADRIANA CHAVEZ'
        OR adusrNomb ='AUDINI CARRILLO'
        OR adusrNomb ='INS MARISCAL'
        OR adusrNomb ='INS BALLIVIAN'
        OR adusrNomb ='CONTRATOS INSTITUCIONALES'
        OR adusrNomb ='INES VELASQUEZ'
        OR adusrNomb ='GUADALUPE AMBA'
        OR adusrNomb ='PATRICIA ROJAS'
        OR adusrNomb = 'CAJERO 21 CALACOTO'
        
        

        order by adusrNomb

       ";

        $usu = DB::connection('sqlsrv')->select(DB::raw($consultaListaEmpleados)); 
        $consultaListaEmpleadosM = "select adusrNomb as 'nombreX',adusrCusr as 'codigoX' from bd_admOlimpia.dbo.adusr where 
        adusrNomb ='DAVID MAMANI'
        OR adusrNomb ='ROSALIA TICONA'
        OR adusrNomb ='ERWIN VILLARROEL'
        OR adusrNomb ='JAVIER MACHICADO'
        OR adusrNomb ='DANI CALDERON'
        OR adusrNomb ='CARMELA ESCOBAR'
        OR adusrNomb ='DAVID CUTIPA'
        order by adusrNomb
       ";    
         $mayo=   DB::connection('sqlsrv')->select(DB::raw($consultaListaEmpleadosM));      

        $array=[];
          
        $array=array_merge($usu,$mayo);
        // foreach ($array as $key) {
        //   dd($key->codigoX);
        // }
        return view('cotizacionReport.vistaCotizacionReport', compact('user','usu','mayo','array'));
        //return ("desde cotizacionreport");
        //return view('cotizacionReport.vistaCotizacionReport');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return "desde create";
    }

    //mostrar pdf
    public function crearZ(Request $request){
   
      //dd($request->all());
         $data=request(); 
         $cotT=Cotizacion_report::all('id');
         $c=0;
         $dato=$data['id_cotizacion'];
         $dato=strval($dato);
         $dato='{"id":'.$dato."}";
      
      // for ($i=0;$i<5;$i++){
     //   $c=$c+1;
     //  }
 
       foreach ($cotT as $value) {
      
            if ($value==$dato) {
               
             dd("
             -----------DATOS REPETIDOS---------");
            } 
               
        }
     
        DB::table('observacion_cotizacions')->insert([
            'id'=>$data['id_cotizacion'],
            'idObs'=>$data['id_cotizacion'],
            'user_id'=>$data['iduser'],
            'textObs'=>$data['comentario'],
            'nroMod'=>0,
            'nro'=>0,
            'nroA'=>0,
            'nroP'=>0,
            'nroT'=>0,
            'fechaC'=>date('Y-m-d H:i:s')
      ]);
      
      return redirect()->back() 

                    ->with('success', 'Entrada actualizada.'); 
     // return "cargado con exito";
    // return redirect()->action('CotizacionReporte.show'); 
       
    }
    public function verPDF()
    {
        echo "desde pdf";
    }

    public function crearTablaObservacion(Request $request){
        // $table->string('id_cotizacion');
        //    $table->string('comentario'); 

      //  DB::table('observacion_cotizacions')->insert(
       //     ['id_cotizacion'  => '12345',
       //     'comentario'=>'es un caomentario']
       // );
      
      //  return redirect()->action('CotizacionReport');
    }

    public function facturaConsol(Request $request)
    {  // dd($request->all());
           $data=request(); 
          
           $NR=$data['FAC'];
   
      
  
     
         
      
    
        $varQ1="	select vtVxFLvta as 'NroTrans',
         CONVERT(varchar,vtVxFFtra,103) as 'fecha', vtvtaNomC as 'RazonSocial', 
         REPLACE(cast (round(vtVxFTot,2) as decimal(10,2)),',', '.') 		 as 'total' ,
        inlocNomb Local, 
		imLvtEsfc as 'estado' ,
        imLvtNrfc Factura
		from   vtVxF
		join vtVta on vtvtaNtra= vtVxFNvta
		join imLvt on (imLvtNlvt = vtVxFLvta)
		join inloc on (inlocCloc = vtVxFCloc and inlocMdel=0) 		
		where vtvtaNtra = ".$NR." 
          ";

    
          
     
          $paso1= DB::connection('sqlsrv')->select(DB::raw($varQ1));   
          
            if (!empty($paso1)) {
                $varFAC ="";

                foreach ($paso1 as $key => $value) {
                  $varFAC =$value->NroTrans;
                

                }
                $varQ2="
                SELECT vtvtaNtra NoTrans,CONVERT(varchar,vtvtaFtra,103)   Fecha, 
                REPLACE(cast (round(vtvtaImpT,2) as decimal(10,2)),',', '.')  Importe,
                REPLACE(cast (round(vtvtaDesT,2) as decimal(10,2)),',', '.') 	as  'Descuento',vtvtaTotT Total,
                 admonAbrv Mon, inlocNomb Localv, adusrNomb Vendedor
                FROM vtVta 
                JOIN inloc on (inlocCloc = vtvtaCloc and inlocMdel=0)
                JOIN bd_admOlimpia.dbo.admon on (vtvtaMtra = admonCmon and admonMdel=0)
                JOIN bd_admOlimpia.dbo.adusr on (vtvtaCusr = adusrCusr and adusrMdel=0)
                JOIN vtVxF on (vtVxFNvta = vtvtaNtra)
                WHERE vtvtaMdel = 0 and vtvtaTipo=1 and vtVxFLvta=".$varFAC."
                ";
                $paso2= DB::connection('sqlsrv')->select(DB::raw($varQ2));  
                
                
             
               return view('cotizacionReport.consolidacionFAC',compact('NR','paso1','paso2') );
            }else {
                return view('cotizacionReport.sinConsolidacion',compact('NR') );
          
            }
         
       
  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     * 
     * 
     */
    public function store(Request $request, Cotizacion_report $cotizacion_report ) 
    {   
       

        $fini = date("d/m/Y", strtotime($request->fini));
        $ffin = date("d/m/Y", strtotime($request->ffin));
        $fecha2="$fini al $ffin";
       // $fecha = "(vtvtaFent BETWEEN '".$fini."' AND '".$ffin."') AND ";
       $fecha = "(vtvtaFent BETWEEN '".$fini."' AND '".$ffin."' OR imLvtFech BETWEEN '".$fini."' AND '".$ffin."')";
       //$fecha = "(vtvtaFent BETWEEN '".$fini."' AND '".$ffin."')";
       $fechaFConsol ="(vtVxFFtra BETWEEN '".$fini."' AND '".$ffin."')";
      // imLvtFech BETWEEN
      //vtvtaFent 
       // $otroUsuario="";  
      //  $otroUsuario2=" OR adusrNomb = ";  
      $otroUsuario = "AND adusrNomb IS NULL";
      if($request->options||$request->optionss){
        $otroUsuario = "AND adusrNomb IN ('".implode("','",$request->options)."')";
      }
       
      //$cadenaOp="adusrNomb = ";  
       // $varOp=$request->options;
       // $i=0;
      //  $varInteger=$request->options;
      //  $varInteger=(sizeof($varInteger))-1;
     
        //for($i; $i<=$varInteger;$i++ ){
         //   dd($varOp[$i]);
         //   if ($varInteger>0) {
         //      $otroUsuario=($varOp[$i]);
         //      if ($i==0) {
         //         $cadenaOp=$cadenaOp."'".$otroUsuario."'";
         //       } else {
         //         $cadenaOp=$cadenaOp.$otroUsuario2."'".$otroUsuario."'";
         //    }
         //   } else {
         //       $otroUsuario= implode("",$varOp);
         //       $cadenaOp=$cadenaOp."'".$otroUsuario."'";
         //   }
     //   } 
       $esUnaQuery = 
        " 
        select CONVERT(varchar,vtvtaFent,103) as 'Fecha',
            --vtvtaNcot as 'NroCotizacion',
            --case when vtvtaNcot >0 then convert(varchar,vtvtaNcot) else '-' end as 'NroCotizacion',
            --	case  when vtvtaNcot = 0  then CAST(REPLACE('vtvtaNcot','0','-')) else vtvtaNcot end as 'NroCotizacion',
            --case CAST(vtvtaNcot as varchar(10)) when vtvtaNcot=0 then '' else vtvtaNcot end as 'NroCotizacion',
              --  vtvtaNomC as 'Cliente',
               -- CONVERT(varchar, vtvtaFtra, 103)	 as 'FechaNR',
               -- vtvtaNtra as 'NR',
              --  REPLACE(cast (round(vtvtaTotT,2) as decimal(10,2)),',', '.') as 'Totalventas',
                --admonAbrv 'Moneda',
                -- adusrNomb as 'Usuario',
               --  inlocNomb as 'Local',
                    -- CONVERT(varchar,imlvtFech,103) as 'FechaFac',--facturacion,
                  --  imlvtNrfc as 'numerofactura',
                  -- imLvtEsfc as  'estado' 

         --vtvtaNcot as 'NroCotizacion',
          case when vtvtaNcot >0 then convert(varchar,vtvtaNcot) else '-' end as 'NroCotizacion',
          --	case  when vtvtaNcot = 0  then CAST(REPLACE('vtvtaNcot','0','-')) else vtvtaNcot end as 'NroCotizacion',
          --case CAST(vtvtaNcot as varchar(10)) when vtvtaNcot=0 then '' else vtvtaNcot end as 'NroCotizacion',
            vtvtaNomC as 'Cliente',
            CONVERT(varchar, vtvtaFtra, 103)	 as 'FechaNR',
            vtvtaNtra as 'NR',
            vtVxFNvta as 'FC',
            REPLACE(cast (round(vtvtaTotT,2) as decimal(10,2)),',', '.') as 'Totalventas',
            admonAbrv 'Moneda',
            adusrNomb as 'Usuario',
            inlocNomb as 'Local',
              CONVERT(varchar,imlvtFech,103) as 'FechaFac',--facturacion,
              imlvtNrfc as 'numerofactura',
              imLvtEsfc as  'estado',
              vtvtaMdel as 'estadoNR'  
                   
        from vtVta 
      left  JOIN bd_admOlimpia.dbo.admon ON (admonCmon=vtvtaMtra AND admonMdel=0) 
      left  JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=vtvtaCusr AND adusrMdel=0)
        JOIN inloc ON (inlocCloc=vtvtaCloc AND inlocMdel=0) 
    full join imlvt on vtvtaNtra=imlvtNvta
    full join vtVxF on vtvtaNtra= vtVxFNvta
        
        where 
        ".$fecha."
        ".$otroUsuario."
          
      order by vtvtaFent desc

        ";
        
      // consolidacion de facturas 

        $facturaConsolidada=
        "
        select distinct 
        vtVxFLvta Notrans,
        imlvtNvta as 'nrotras2',
        imLvtEsfc as 'estado' ,crentNomb Cliente,
        convert(varchar, vtVxFFtra,103) as'Fecha',
       
         inlocNomb Local, 
        imLvtNrfc Factura, 
    
        REPLACE(cast (round(imLvtImpE,2) as decimal(10,2)),',', '.') as 'Importe'
      
        from vtVxF join crEnt on (vtVxFCent = crentCent and crentMdel=0) 
        full join imLvt on (imLvtNlvt = vtVxFLvta)
         join inloc on (inlocCloc = vtVxFCloc and inlocMdel=0) 
        where ".$fechaFConsol."
        order by 1

        ";
dd($esUnaQuery);
       $BDfacConsol= DB::connection('sqlsrv')->select(DB::raw($facturaConsolidada));     
           // return dd($BDfacConsol);



           

        //$observacionBD=DB::table('observacion_cotizacion')->get()->pluck('idObs','textObs','user_id','modifUno','modifiDos','nroMod','fechaC');          
        $observacionBD=Cotizacion_report::all(['id','idObs','textObs','user_id','nroMod','nro','nroA','nroP','nroT','fechaC']);
        $cr=observacion_estados::all(['id']);
        $consutas = DB::connection('sqlsrv')->select(DB::raw($esUnaQuery));
        
        

 

        $estadoF=observacion_estados::all('cotizacion_form_id','estado');
      
      //  $var1=Cotizacion_report::all()-> estadosS;
     
   
        if($request->gen =="export")
        {
            $pdf = \PDF::loadView('reports.pdf.prueba', compact('consutas','fecha2'))
            ->setOrientation('landscape')
            ->setPaper('letter')
            ->setOption('footer-right','Pag [page] de [toPage]')
            ->setOption('footer-font-size',8);
      
            return $pdf->inline('Reportecotizacion_'.$fecha2.'.pdf');
        }
        elseif($request->gen =="excel")
        {
            $export = new ReporteCotizacionExport($consutas, $fecha2);    
            return Excel::download($export, 'Reporte Cotizacion.xlsx');
        }
        else if($request->gen =="ver")
        {
            return view('cotizacionReport.vistaForm' ,compact('consutas','observacionBD','estadoF','BDfacConsol'));
            
           /* 
           // return view('cotizacionReport.vistaFormularioTotal')
            ->compact('consultas',$consutas)
            ->with('cotizacion_report', $cotizacion_report)
            ->with('fecha',$fecha)
            ->with('observacionBD',$observacionBD)
            ->with('cr',$cr)
            ->with('estadoF',$estadoF);
            ;*/
            
        }
        ////////////////////////
       
         

       // return view('cotizacionReport.vistaFormularioTotal')
       // ->with('nombre', $nombre)
       // ->with('consultas',$consutas);
            
        
    }
    public function listaUsuario(){
             
        return "no tiene edicion ";
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cotizacion_report  $cotizacion_report
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
       /** 
        if(!$request->user)
        {
            $error = "Ningun usuario fue seleccionado para generar el reporte";
            return view("errors.error_variable", compact('error'));
        }       
        else if (Auth::user()->authorizePermisos(['Notas De Remisión', 'Rango de Fechas']))
        {
            $fini = date("d/m/Y", strtotime($request->fini));
            $ffin = date("d/m/Y", strtotime($request->ffin));
            $fecha = "AND (vtvtaFent BETWEEN '".$fini."' AND '".$ffin."')";
        }
        else
        {
            $fini = date("d/m/Y",strtotime("1/1/1900"));
            $ffin = date("d/m/Y", strtotime($request->ffin));
            //return dd($ffin);
            $fecha = "AND (vtvtaFent = '".$ffin."')";
        }
        $user_id = 28;
        $facturas = "" ;
        if(!$request->facturadas)
        {
            $facturas = "AND imlvtNvta IS NULL";
        }
        $vari = "DECLARE @usuario INT
        SELECT @usuario =".$user_id;
        */
        
        $fini = date("d/m/Y", strtotime($request->fini));
        $ffin = date("d/m/Y", strtotime($request->ffin));
        $fecha = "(vtvtaFent BETWEEN '".$fini."' AND '".$ffin."') AND ";
        $fecha2="$fini al $ffin";
        $otroUsuario="";  
        $otroUsuario2=" OR adusrNomb = ";  
       
        $cadenaOp="adusrNomb = ";  
        $varOp=$request->options;
        $i=0;
        $varInteger=$request->options;
        $varInteger=(sizeof($varInteger))-1;
     
        for($i; $i<=$varInteger;$i++ ){
         //   dd($varOp[$i]);
            if ($varInteger>0) {
               $otroUsuario=($varOp[$i]);
               if ($i==0) {
                  $cadenaOp=$cadenaOp."'".$otroUsuario."'";
                } else {
                  $cadenaOp=$cadenaOp.$otroUsuario2."'".$otroUsuario."'";
             }
            } else {
                $otroUsuario= implode("",$varOp);
                $cadenaOp=$cadenaOp."'".$otroUsuario."'";
            }
        } 
             
        
      
        $esUnaQuery = 
        " 
        select CONVERT(varchar,vtvtaFent,103) as 'Fecha',
            --vtvtaNcot as 'NroCotizacion',
            case when vtvtaNcot >0 then convert(varchar,vtvtaNcot) else '-' end as 'NroCotizacion',
            --	case  when vtvtaNcot = 0  then CAST(REPLACE('vtvtaNcot','0','-')) else vtvtaNcot end as 'NroCotizacion',
            --case CAST(vtvtaNcot as varchar(10)) when vtvtaNcot=0 then '' else vtvtaNcot end as 'NroCotizacion',
                vtvtaNomC as 'Cliente',
                CONVERT(varchar, vtvtaFtra, 103)	 as 'FechaNR',
                vtvtaNtra as 'NR',
                
               
                admonAbrv 'Moneda',
                 adusrNomb as 'Usuario',
                 inlocNomb as 'Local',
                     CONVERT(varchar,imlvtFech,103) as 'FechaFac',--facturacion,
                    imlvtNrfc as 'numerofactura',
                   imLvtEsfc as  'estado',
                   vtvtaMdel as 'estadoNR' 
                   
        from vtVta 
         JOIN bd_admOlimpia.dbo.admon ON (admonCmon=vtvtaMtra AND admonMdel=0) 
        JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=vtvtaCusr AND adusrMdel=0)
       join  inloc ON (inlocCloc=vtvtaCloc AND inlocMdel=0) 
         join imlvt on vtvtaNtra=imlvtNvta
        
            where (
                $fecha
                $cadenaOp
            )
        order by vtvtaFent desc
        
        ";
       
         $consutas = DB::connection('sqlsrv')->select(DB::raw($esUnaQuery));

         $nombre = 'Fernando';
  
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cotizacion_report  $cotizacion_report
     * @return \Illuminate\Http\Response
     */
    public function edit(Cotizacion_report $cotizacion_report)
    {
        $estaSegui = observacion_estados::where('estado','Seguimiento')->first();
        $commetx=observacion_estados::all('id','estado','textObs1','cotizacion_form_id','created_at','updated_at');
        $cotT=Cotizacion_report::all('id');
        return view('cotizacionReport.edit')
        ->with('commetx',$commetx)
        ->with('cotizacion_report',$cotizacion_report)
        ->with('cotT',$cotT)
        ->with('estaSegui', $estaSegui)
       
         ;
        //return $cotizacion_report;
    
    }

    public function estado(Request $request, Cotizacion_report $cotizacion_report)
    { 
        $segui="Seguimiento";
        $adju="Adjudicado";
        $Pend="Pendiente";
        $parc="Parcial";
        $recha="Rechazado";
        $contar=-1;
        $data=request(); 
        $c=$data['nroMod'];
        $A1=$c;
        $contadorS=0;
            $int=(int)$A1;
            $int=$int+1;
        
            $com=observacion_estados::all('estado');
            $com1=observacion_estados::all('cotizacion_form_id');
            $dato=$cotizacion_report->id;
         $dato=strval($dato);
         $dato='[{"cotizacion_form_id":'.$dato."}";
        $ss1=$data['seguimiento'];
     // return $cotizacion_report->id;
 
        
        
       if ($cotizacion_report->nro==0&&$ss1==$segui) {
        DB::table('observacion_estados')->insert([
            
            'estado'=>$data['seguimiento'],
            'textObs1'=>$data['seguiComen'],
            'textObs2'=>"sin accion",
            'cotizacion_form_id'=>$data['nr'],
            'nroMod'=>$A1,
           
            'created_at'=>date('Y-m-d H:i:s'),  
            'updated_at'=>date('Y-m-d H:i:s'),  
            ]);
            $cotizacion_report->nro=1;
            $cotizacion_report->save();
            return redirect()->back() 

    ->with('success', 'Entrada actualizada.'); 
       }
      

           if ($cotizacion_report->nro==1&&$ss1==$segui) {

            foreach ($com1 as $i) {
                if ($i==$dato&&$ss1==$segui) {
                  $contadorS=$contadorS+1;
                }
                  
              }
              if ($contadorS<=3) {
                DB::table('observacion_estados')->insert([
            
                    'estado'=>$data['seguimiento'],
                    'textObs1'=>$data['seguiComen'],
                    'textObs2'=>"sin accion",
                    'cotizacion_form_id'=>$data['nr'],
                    'nroMod'=>$int,
                    'created_at'=>date('Y-m-d H:i:s'),  
                    'updated_at'=>date('Y-m-d H:i:s'),  
                    ]);
                    return redirect()->back() 

                    ->with('success', 'Entrada actualizada.'); 
              }
              return redirect()->back() 

                    ->with('success', 'muchos intentos');         
        }
        
             

        if ($ss1==$adju) {
            
            DB::table('observacion_estados')->insert([
            
                'estado'=>$data['seguimiento'],
                'textObs1'=>$data['seguiComen'],
                'textObs2'=>"sin accion",
                'cotizacion_form_id'=>$data['nr'],
                'nroMod'=>$int,
                'created_at'=>date('Y-m-d H:i:s'),  
                'updated_at'=>date('Y-m-d H:i:s'),  
                ]);
            $cotizacion_report->nroA=1;
            $cotizacion_report->save();
            return redirect()->back() 

                    ->with('success', 'Entrada actualizada.');
        }

        if ($ss1==$parc) {
            
            DB::table('observacion_estados')->insert([
            
                'estado'=>$data['seguimiento'],
                'textObs1'=>$data['seguiComen'],
                'textObs2'=>"sin accion",
                'cotizacion_form_id'=>$data['nr'],
                'nroMod'=>$int,
                'created_at'=>date('Y-m-d H:i:s'),  
                'updated_at'=>date('Y-m-d H:i:s'),  
                ]);
                $cotizacion_report->nroP=1;
                $cotizacion_report->save();
                return redirect()->back() 

                    ->with('success', 'Entrada actualizada.');
        }
        if ($ss1=="Total") {
            
            DB::table('observacion_estados')->insert([
            
                'estado'=>$data['seguimiento'],
                'textObs1'=>$data['seguiComen'],
                'textObs2'=>"sin accion",
                'cotizacion_form_id'=>$data['nr'],
                'nroMod'=>$int,
                'created_at'=>date('Y-m-d H:i:s'),  
                'updated_at'=>date('Y-m-d H:i:s'),  
                ]);
                $cotizacion_report->nroT=1;
                $cotizacion_report->save();
                return redirect()->back() 

                    ->with('success', 'Entrada actualizada.');
               
        }

        if ($ss1=="Rechazado") {
            
            DB::table('observacion_estados')->insert([
            
                'estado'=>$data['seguimiento'],
                'textObs1'=>$data['seguiComen'],
                'textObs2'=>"sin accion",
                'cotizacion_form_id'=>$data['nr'],
                'nroMod'=>$int,
                'created_at'=>date('Y-m-d H:i:s'),  
                'updated_at'=>date('Y-m-d H:i:s'),  
                ]);
                $cotizacion_report->nro=2;
                
                $cotizacion_report->save();
                return redirect()->back() 

                    ->with('success', 'Entrada actualizada.');
               
        }

     

    }

 




    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cotizacion_report  $cotizacion_report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cotizacion_report $cotizacion_report)
        { 
            $data=$request;

            $A1=$cotizacion_report->nroMod;
            $int=(int)$A1;
            $int=$int+1;
            
          if ($int<=2) {
            $cotizacion_report->textObs=$data['comentario'];
            $cotizacion_report->user_id=$data['iduser'];
            $cotizacion_report->nroMod=$int;
            $cotizacion_report->fechaC=date('Y-m-d H:i:s');
            $cotizacion_report->save();
            return redirect()->back() 

                    ->with('success', 'Entrada actualizada.');
          } else {
            return redirect()->back() 

                    ->with('success', 'SOLO SE PUEDEN EDITAR 2 VECES.');
          }
          

            
         /**         $data=$request;
        $cont =$data['numero'];
       
        if ($cont<=2) {
            $cont=$cont++;
            if ($cont==1) {
                $cotizacion_report->textObs=$data['descrip"'];
                $cotizacion_report->user_id=$data['iduser'];
                
                $cotizacion_report->nroMod=$cont;
                $cotizacion_report->fechaC=date('Y-m-d H:i:s');
                $cotizacion_report->save();
             
            }
            if ($cont==2) {
                $cotizacion_report->textObs=$data['descrip"'];
                $cotizacion_report->user_id=$data['iduser'];
             
                $cotizacion_report->nroMod=$cont;
                $cotizacion_report->fechaC=date('Y-m-d H:i:s');
                $cotizacion_report->save();
            }
            
       
        } else {
            dd("limite excedido");
        }
        return redirect()->action('CotizacionReportController@store'); 
       */
        return "desde update";
    
    }
    public function vista(Request $request)
    {
        return "desde vista";
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cotizacion_report  $cotizacion_report
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cotizacion_report $cotizacion_report)
    {
        //
    }

    public function buscar(Request $request, Cotizacion_report $cotizacion_report ) 
    {  
        $data=$request;
        $bus=$data['buscar'];
         $bus="AND  vtvtaNomC LIKE '%$bus%'";
       
        $fini = date("d/m/Y", strtotime($request->fini));
        $ffin = date("d/m/Y", strtotime($request->ffin));
  
      // $fecha = "(vtvtaFent BETWEEN '".$fini."' AND '".$ffin."' OR vtvtaFent BETWEEN '".$fini."' AND '".$ffin."')";
      $fecha = "(vtvtaFent BETWEEN '".$fini."' AND '".$ffin."' OR vtvtaFent BETWEEN '".$fini."' AND '".$ffin."')";
    
      $otroUsuario = "AND adusrNomb IS NULL";
      if($request->options){
        $otroUsuario = "AND adusrNomb IN ('".implode("','",$request->options)."')";
      }
       
     
       $esUnaQuery = 
        " 
        select CONVERT(varchar,vtvtaFent,103) as 'Fecha',
        

         --vtvtaNcot as 'NroCotizacion',
          case when vtvtaNcot >0 then convert(varchar,vtvtaNcot) else '-' end as 'NroCotizacion',
          --	case  when vtvtaNcot = 0  then CAST(REPLACE('vtvtaNcot','0','-')) else vtvtaNcot end as 'NroCotizacion',
          --case CAST(vtvtaNcot as varchar(10)) when vtvtaNcot=0 then '' else vtvtaNcot end as 'NroCotizacion',
            vtvtaNomC as 'Cliente',
            CONVERT(varchar, vtvtaFtra, 103)	 as 'FechaNR',
            vtvtaNtra as 'NR',
            REPLACE(cast (round(vtvtaTotT,2) as decimal(10,2)),',', '.') as 'Totalventas',
            admonAbrv 'Moneda',
            adusrNomb as 'Usuario',
            inlocNomb as 'Local',
              CONVERT(varchar,imlvtFech,103) as 'FechaFac',--facturacion,
              imlvtNrfc as 'numerofactura',
              imLvtEsfc as  'estado' 
                   
        from vtVta 
        LEFT JOIN bd_admOlimpia.dbo.admon ON (admonCmon=vtvtaMtra AND admonMdel=0) 
        LEFT JOIN bd_admOlimpia.dbo.adusr ON (adusrCusr=vtvtaCusr AND adusrMdel=0)
        JOIN inloc ON (inlocCloc=vtvtaCloc AND inlocMdel=0) 
        left join imlvt on vtvtaNtra=imlvtNvta
        
        where 
        ".$fecha."
        ".$otroUsuario."
        ".$bus."
          
      order by vtvtaFent desc

        ";
        
        $consutas = DB::connection('sqlsrv')->select(DB::raw($esUnaQuery));  

     
        return view('cotizacionReport.vistaForm' ,compact('consutas'));
     
    }
          
}
