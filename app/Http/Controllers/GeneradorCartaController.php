<?php

namespace App\Http\Controllers;

use App\generadorCarta;
use App\Perfil;
use DB;
use Modelo;
use Luecano\NumeroALetras\NumeroALetras;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class GeneradorCartaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {




        
        return view('carta.index');    


        if(Auth::user())
        {
            $user = Auth::user();
      
        
            return view('carta.index',compact('user'));      
        }
        else
        {
            return dd('largo de aqui...');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    public function vista(Perfil $perfil, Request $request)
    {
   
       $carta = DB::table('generador_cartas')->get();
       $obs='';
       $estado='';
       $accion='';
       $int =0;
       $arrayCarta=[];
       $arrayCarta2=array();
             
      // $titulos=
      // [
        //   ['name'=>'categoria', 'data'=>'categoria', 'title'=>'Categoria', 'tip'=>'filtro'],
       foreach ($carta as $key => $value) {
        if ($value->userAuth==Auth::user()->id ) {
            $arrayCarta[] = ["obs"=>"$value->Descripcion", "estado1"=>"$value->estado1"];       
        }
     
       }

    
           
 


   
     
        return view('carta.show', compact('perfil','carta','arrayCarta'));
    }

public function contador(Request $request){



}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function carta(Request $request, generadorCarta $generadorCarta){
        //$pkeyid = openssl_pkey_get_private("file://src/openssl-0.9.6/demos/sign/key.pem");
        






       $cc=explode("&nbsp;",$request->cli);
     
        if($request->verC =="verC")
                   {
                    $carta = DB::table('contador_p_d_f')->get();
           
                    if (count($carta)==0) {
                      DB::table('contador_p_d_f')->insert([
            
                        'contador'=>1,
                        'link'=>"link",
                                       
                        'created_at'=>date('Y-m-d H:i:s'),  
                        'updated_at'=>date('Y-m-d H:i:s'),  
                        ]);
                       // $cotizacion_report->nro=1;
                      //  $generadorCarta->save();
                  
                    }
                    else
                    {
                    
                      $cc1=count($carta)+1;
                      DB::table('contador_p_d_f')->insert([
            
                        'contador'=>$cc1,
                        'link'=>"link",
                                       
                        'created_at'=>date('Y-m-d H:i:s'),  
                        'updated_at'=>date('Y-m-d H:i:s'),  
                        ]);
                       // $cotizacion_report->nro=1;
                     //   $generadorCarta->save();
                     // return dd($carta);
                    
                    }
                   // $verificar=array_pop($carta);
                  //  return dd($verificar);
                    $contador2=intval($carta[0]->contador);
                    $contador2=$contador2+1;
                    
                  
                   
                    
        //quita los espacios
            $clienteC=utf8_decode($request->cli);
            $clienteC=str_replace("&nbsp;", "",$clienteC);
            $clienteC=preg_replace('/\s+/', ' ',$clienteC);
            $clienteC=trim($clienteC);
            $fecha=$request->fecha;
            $fechaCarta=$request->fechaCarta;
            $fechaC=$request->fechaC;
            $fechaH=$request->fechaH;
            $option=$request->radio;
            $clienteC=$cc[0];
                  /////////contenido de tabla////////////
                  if($request->estadoCarta=="1"){
                    $estadoY="DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= 30";
                  }
                  if($request->estadoCarta=="2"){
                    $estadoY="DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30)";
                  }
                  if($request->estadoCarta=="3"){
                   $estadoY="DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')>(30) ";   
                  } 
         
                  


     $query="
     DECLARE @fechaA DATE    
     SELECT @fechaA = '".$fecha."'
     SELECT 
  
  cxcTrNcto as 'Cliente',   
  imlvt.imLvtNrfc as 'NroFac',  
  CONVERT(varchar,cxcTrFtra,103) as 'Fecha',   
  CONVERT(varchar,DATEADD(day, 30/*DiasPlazo*/, cxcTrFtra), 103) as 'FechaVenc',  
    --DiasPlazo, 
  CASE      
  WHEN DATEDIFF(DAY, cxcTrFtra, @fechaA) <= 30/*DiasPlazo*/ THEN 'VIGENTE'   
  WHEN DATEDIFF(DAY, cxcTrFtra, @fechaA) <= (30/*DiasPlazo*/ + 15) THEN 'VENCIDO'  
  WHEN DATEDIFF(DAY, cxcTrFtra, @fechaA) > (30/*DiasPlazo*/ + 15) THEN 'MORA'   
  END as estado,

  CONVERT(VARCHAR, cast((cxcTrImpt) as money),1) as 'ImporteCXCBS',
  CONVERT(VARCHAR, cast(ISNULL(cobros.AcuentaF,0) as money),1) as 'ACuentaBS',
  CONVERT(VARCHAR, cast(((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0))) as money),1) as 'SaldoBS',
  CONVERT(VARCHAR, cast(((cxcTrImpt *6.96)) as money),1) as 'ImporteCXCDolar',
  CONVERT(VARCHAR, cast(ISNULL(cobros.AcuentaF,0)*6.96 as money),1) as 'ACuentaDolar',
  CONVERT(VARCHAR, cast((((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0))*6.96)) as money),1) as 'SaldoDolar'

  --cast(cxcTrImpt as decimal(10,2))as 'ImporteCXCBS',   
  --REPLACE(cast(ISNULL(cobros.AcuentaF,0) as decimal(10,2)),',', '.') as 'ACuentaBS', 
 -- REPLACE(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2)),',', '.') as 'SaldoBS',    
  -- cast(cxcTrImpt * 6.96 as decimal(10,2))as 'ImporteCXCDolar',   
  --REPLACE(cast(ISNULL(cobros.AcuentaF*6.96,0) as decimal(10,2)),',', '.') as 'ACuentaDolar', 
  --REPLACE(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0))*6.96 as decimal(10,2)),',', '.') as 'SaldoDolar' 
  
  
  FROM cxcTr       
  JOIN bd_admOlimpia.dbo.admon ON admonCmon = cxcTrMtra AND admonMdel = 0    
  JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0   
  JOIN inloc ON inlocCloc = cxcTrCloc AND inlocMdel = 0     
  JOIN cutcu ON cutcuCtcu = cxcTrCtcu AND cutcuMdel = 0     
  --//CXC generadas por VENTAS     
  /*JOIN        
  (          SELECT *       
  FROM cptra      
  JOIN cptrd ON cptrdNtra = cptraNtra AND cptrdTtra = 11    
  WHERE cptraTtra = 21 AND cptraMdel = 0      
  ) cptra    
  ON cptrdNtrD = cxcTrNtra*/  
  --//CXC generadas por VENTAS    
  LEFT JOIN    
  (       
  SELECT   
  imLvtNlvt, imLvtNNit,     
  imLvtRsoc, imLvtNrfc,     
  imlvtNvta, imLvtEsfc,  
  imLvtMdel, imLvtFech  
  FROM imlvt WHERE imlvtNvta <> 0  
  UNION     
  (     
  SELECT       
  imLvtNlvt, imLvtNNit,        
  imLvtRsoc, imLvtNrfc,      
  vtVxFNvta as imlvtNvta,    
  imLvtEsfc, imLvtMdel,         
  imLvtFech            
  FROM imlvt         
  JOIN vtVxF ON imLvtNlvt = vtVxFLvta 
  )     
  )as imlvt      
  ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0    
  LEFT JOIN    
  (        
  SELECT       
  crentCent,      
  maprfDplz as 'DiasPlazo'   
  FROM crEnt       
  LEFT JOIN maprf ON maprfCprf = crentClsf AND maPrfMdel = 0   
  WHERE crentMdel = 0 AND crentStat = 0   
  ) as crent     
  ON crentCent = cxcTrCcto   
  --COBROS DE CXC        
  LEFT JOIN 
  (       
  SELECT liqdCNtcc, SUM(liqdCAcmt) as AcuentaF    
  FROM liqdC   
  JOIN liqXC ON liqdCNtra = liqXCNtra       
  WHERE liqXCMdel = 0       
  AND liqXCFtra <= '".$fechaCarta."'    
      
  GROUP BY liqdCNtcc 
  )as cobros    
  ON cobros.liqdCNtcc = cxcTrNtra      
  WHERE (cxcTrImpt - cxcTrAcmt) <> 0 AND cxcTrMdel = 0      
  AND cxcTrCcbr IN (29,6,57,28,76,42,40,62,39,55,18,20,16,17,46,37,48,21,9,4,65,74,63,64,2,3,19,47,58)   
  AND ".$estadoY."  
  --AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30)  
  --and DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')>(30) 
--  AND DATEDIFF(DAY, cxcTrFtra, ''".$fecha."')) <= 30   
 
  and  cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2))<>0
-- and cxcTrNcto ='ANA CLAVIJO'        
and cxcTrNcto like '$clienteC%'   
AND cxcTrNcto NOT IN ('CAJERO 2 BALLIVIAN . ','CAJERO 2 CALACOTO .','CAJERO 2 HANDAL .','CAJERO 2 MARISCAL .','CAJERO BALLIVIAN .'
,'CAJERO CALACOTO .','CAJERO LIBRO BALLIVIAN','CAJERO LIBRO HANDAL','CAJERO LIBRO CALACOTO','CAJERO LIBRO MARISCAL')

order by Cliente
";
              
                  $cxcCarta=DB::connection('sqlsrv')->select(DB::raw($query));
               
             //totales----------------------
        $total="
        DECLARE @fechaA DATE    
        SELECT @fechaA = '".$fecha."'
        SELECT
        cxcTrNcto as 'Cliente' ,
        CONVERT(VARCHAR, cast(SUM(cxcTrImpt) as money),1) as 'ImporteCXCBS',
        CONVERT(VARCHAR, cast(SUM(ISNULL(cobros.AcuentaF,0)) as money),1) as 'ACuentaBS',
        CONVERT(VARCHAR, cast(SUM((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0))) as money),1) as 'SaldoBS',
        CONVERT(VARCHAR, cast(SUM((cxcTrImpt * 6.96)) as money),1) as 'ImporteCXCDolar',
        CONVERT(VARCHAR, cast(SUM((ISNULL(cobros.AcuentaF,0)*6.96)) as money),1) as 'ACuentaDolar', 
        CONVERT(VARCHAR, cast(SUM(((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)))*6.96) as money),1) as 'SaldoDolar'

       --sum(cast(cxcTrImpt as decimal(10,2)))as 'ImporteCXCBS',   
       --REPLACE(sum(cast(ISNULL(cobros.AcuentaF,0) as decimal(10,2))),',', '.') as 'ACuentaBS', 
       --REPLACE(sum(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2))),',', '.') as 'SaldoBS',    
       --sum(cast(cxcTrImpt * 6.96 as decimal(10,2)))as 'ImporteCXCDolar',   
       --REPLACE(sum(cast(ISNULL(cobros.AcuentaF*6.96,0) as decimal(10,2))),',', '.') as 'ACuentaDolar', 
       --REPLACE(sum(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0))*6.96 as decimal(10,2))),',', '.') as 'SaldoDolar' 
        
        FROM cxcTr       
        JOIN bd_admOlimpia.dbo.admon ON admonCmon = cxcTrMtra AND admonMdel = 0    
        JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0   
        JOIN inloc ON inlocCloc = cxcTrCloc AND inlocMdel = 0     
        JOIN cutcu ON cutcuCtcu = cxcTrCtcu AND cutcuMdel = 0     
        
        LEFT JOIN    
        (       
        SELECT   
        imLvtNlvt, imLvtNNit,     
        imLvtRsoc, imLvtNrfc,     
        imlvtNvta, imLvtEsfc,  
        imLvtMdel, imLvtFech  
        FROM imlvt WHERE imlvtNvta <> 0  
        UNION     
        (     
        SELECT       
        imLvtNlvt, imLvtNNit,        
        imLvtRsoc, imLvtNrfc,      
        vtVxFNvta as imlvtNvta,    
        imLvtEsfc, imLvtMdel,         
        imLvtFech            
        FROM imlvt         
        JOIN vtVxF ON imLvtNlvt = vtVxFLvta 
        )     
        )as imlvt      
        ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0    
        LEFT JOIN    
        (        
        SELECT       
        crentCent,      
        maprfDplz as 'DiasPlazo'   
        FROM crEnt       
        LEFT JOIN maprf ON maprfCprf = crentClsf AND maPrfMdel = 0   
        WHERE crentMdel = 0 AND crentStat = 0   
        ) as crent     
        ON crentCent = cxcTrCcto   
        --COBROS DE CXC        
        LEFT JOIN 
        (       
        SELECT liqdCNtcc, SUM(liqdCAcmt) as AcuentaF    
        FROM liqdC   
        JOIN liqXC ON liqdCNtra = liqXCNtra       
        WHERE liqXCMdel = 0         
        AND liqXCFtra <= '".$fechaCarta."'  
      --  AND liqXCFtra <= '07/10/2022'       
        GROUP BY liqdCNtcc 
        )as cobros    
        ON cobros.liqdCNtcc = cxcTrNtra      
        WHERE (cxcTrImpt - cxcTrAcmt) <> 0 AND cxcTrMdel = 0      
        AND cxcTrCcbr IN (29,6,57,28,76,42,40,62,39,55,18,20,16,17,46,37,48,21,9,4,65,74,63,64,2,3,19,47,58)   
        AND ".$estadoY."  
      --  AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30)  
      --  and DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')>(30) 
       -- AND DATEDIFF(DAY, cxcTrFtra, ''".$fecha."')) <= 30   
      
        and  cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2))<>0
       and cxcTrNcto like '$clienteC%'
      AND cxcTrNcto NOT IN ('CAJERO 2 BALLIVIAN . ','CAJERO 2 CALACOTO .','CAJERO 2 HANDAL .','CAJERO 2 MARISCAL .','CAJERO BALLIVIAN .'
,'CAJERO CALACOTO .','CAJERO LIBRO BALLIVIAN','CAJERO LIBRO HANDAL','CAJERO LIBRO CALACOTO','CAJERO LIBRO MARISCAL')
       GROUP BY cxcTr.cxcTrNcto
       order by Cliente
   ---   and cxcTrNcto ='ANA CLAVIJO'  
      "; 

           //totales---texto------------------
           $totalTexto="
           DECLARE @fechaA DATE    
           SELECT @fechaA = '".$fecha."'
           SELECT
           cxcTrNcto as 'Cliente' ,
           CONVERT(VARCHAR, cast(SUM(cxcTrImpt) as money),1) as 'ImporteCXCBS',
           CONVERT(VARCHAR, cast(SUM(cobros.AcuentaF) as money),1) as 'ACuentaBS',
          -- sum(cast(cxcTrImpt as decimal(10,2)))as 'ImporteCXCBS',   
          --  REPLACE(sum(cast(ISNULL(cobros.AcuentaF,0) as decimal(10,2))),',', '.') as 'ACuentaBS', 
       
           
         REPLACE(sum(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2))),',', '.') as 'SaldoBS',    
         
           sum(cast(cxcTrImpt * 6.96 as decimal(10,2)))as 'ImporteCXCDolar',   
           REPLACE(sum(cast(ISNULL(cobros.AcuentaF*6.96,0) as decimal(10,2))),',', '.') as 'ACuentaDolar', 
           REPLACE(sum(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0))*6.96 as decimal(10,2))),',', '.') as 'SaldoDolar' 
           
           FROM cxcTr       
           JOIN bd_admOlimpia.dbo.admon ON admonCmon = cxcTrMtra AND admonMdel = 0    
           JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0   
           JOIN inloc ON inlocCloc = cxcTrCloc AND inlocMdel = 0     
           JOIN cutcu ON cutcuCtcu = cxcTrCtcu AND cutcuMdel = 0     
           
           LEFT JOIN    
           (       
           SELECT   
           imLvtNlvt, imLvtNNit,     
           imLvtRsoc, imLvtNrfc,     
           imlvtNvta, imLvtEsfc,  
           imLvtMdel, imLvtFech  
           FROM imlvt WHERE imlvtNvta <> 0  
           UNION     
           (     
           SELECT       
           imLvtNlvt, imLvtNNit,        
           imLvtRsoc, imLvtNrfc,      
           vtVxFNvta as imlvtNvta,    
           imLvtEsfc, imLvtMdel,         
           imLvtFech            
           FROM imlvt         
           JOIN vtVxF ON imLvtNlvt = vtVxFLvta 
           )     
           )as imlvt      
           ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0    
           LEFT JOIN    
           (        
           SELECT       
           crentCent,      
           maprfDplz as 'DiasPlazo'   
           FROM crEnt       
           LEFT JOIN maprf ON maprfCprf = crentClsf AND maPrfMdel = 0   
           WHERE crentMdel = 0 AND crentStat = 0   
           ) as crent     
           ON crentCent = cxcTrCcto   
           --COBROS DE CXC        
           LEFT JOIN 
           (       
           SELECT liqdCNtcc, SUM(liqdCAcmt) as AcuentaF    
           FROM liqdC   
           JOIN liqXC ON liqdCNtra = liqXCNtra       
           WHERE liqXCMdel = 0         
           AND liqXCFtra <= '".$fechaCarta."'  
         --  AND liqXCFtra <= '07/10/2022'       
           GROUP BY liqdCNtcc 
           )as cobros    
           ON cobros.liqdCNtcc = cxcTrNtra      
           WHERE (cxcTrImpt - cxcTrAcmt) <> 0 AND cxcTrMdel = 0      
           AND cxcTrCcbr IN (29,6,57,28,76,42,40,62,39,55,18,20,16,17,46,37,48,21,9,4,65,74,63,64,2,3,19,47,58)   
           AND ".$estadoY."  
       --    AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30)  
      --    and DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')>(30) 
          -- AND DATEDIFF(DAY, cxcTrFtra, ''".$fecha."')) <= 30   
           and  cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2))<>0
          and cxcTrNcto like '$clienteC%'
         AND cxcTrNcto NOT IN ('CAJERO 2 BALLIVIAN . ','CAJERO 2 CALACOTO .','CAJERO 2 HANDAL .','CAJERO 2 MARISCAL .','CAJERO BALLIVIAN .'
   ,'CAJERO CALACOTO .','CAJERO LIBRO BALLIVIAN','CAJERO LIBRO HANDAL','CAJERO LIBRO CALACOTO','CAJERO LIBRO MARISCAL')
          GROUP BY cxcTr.cxcTrNcto
          order by Cliente
      ---   and cxcTrNcto ='ANA CLAVIJO'  
         "; 
      
        $cadenaBS="";
        $cadenaDL="";
            $bs="";
            $dolar="";
            $totalStTx=DB::connection('sqlsrv')->select(DB::raw($totalTexto));  
        $totalS=DB::connection('sqlsrv')->select(DB::raw($total));   
     
        $formatter = new NumeroALetras(); 



                 
           
        $arrayMoney=[];       
        $arraycxcCarta= [];  
        $bsNu="";

        foreach ($totalStTx as $key => $value) {
          $cadenaBS=strtolower($formatter->toMoney($value->SaldoBS));
        $cadenaDL=strtolower($formatter->toMoney($value->SaldoDolar));
           $bs= $value->SaldoBS;
           $dolar=$value->SaldoDolar;
           $bsNu=$value->SaldoBS;
           $dolarNu=$value->SaldoDolar;
      }  
  
//bolivianos

    $bsNu=explode(".", $bsNu);
    
    $bsNu[0]=mb_strtolower($formatter->toMoney($bsNu[0]));
   
    $bsNu[1]=$bsNu[1]."/100";
      
      //dolares
      $dolarNu=explode(".", $dolarNu);

      $dolarNu[0]=mb_strtolower($formatter->toMoney($dolarNu[0]));
      
    
      $dolarNu[1]=$dolarNu[1]."/100";
      
           $conta=count($carta); 
                       $pdf = \PDF::loadView('reports.pdf.carta2',compact('totalStTx','conta','dolarNu','bsNu','bs','dolar','cadenaDL','cadenaBS','totalS','cxcCarta','fechaH','clienteC','fecha','fechaCarta','fechaC','option'))
                        ->setPaper('letter')
                        ->setOption('margin-top',39)
                        ->setOption('margin-left', 15)
                        ->setOption('margin-right', 15)
                        ->setOption('margin-bottom', 33)
                        //->setOption('footer-right','Pag [page] de [toPage]')
                         ->setOption('footer-font-size',8);
                         return $pdf->inline('carta_pdf');
      
                        //  return $pdf->inline('Reportecotizacion_'.$fecha2.'.pdf');
                      }  
    }
    
    public function store(Request $request)
    {

        $fecha = date("d/m/Y", strtotime($request->ffin));
        $fechaCarta   = date("d/m/Y", strtotime($request->fini));
        $array=['enero','febrero','marzo','abril','mayo','junio','julio','agosto','septiembre','octubre','noviembre','diciembre'];
        $estadoX=$request->estado2;
        $estadoY="";
        if($request->estado2=="1"){
          $estadoY="DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= 30";
        }
        if($request->estado2=="2"){
          $estadoY="DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30)";
        }
        if($request->estado2=="3"){
         $estadoY="DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')>(30) ";   
        } 
       
      
        
       

       // fecha de hoy 
        $day=date("d", strtotime($request->ffin));
        $mes=date("m", strtotime($request->ffin));
        $año=date("Y", strtotime($request->ffin));
        for ($i=0; $i <=sizeof($array) ; $i++) { 
            if ($i==($mes-1)) {
                $mes=$array[$i];
                break;
                  }       
        }
        $fechaH=$day.' de '.$mes.' de '.$año;
      
        //fecha---- de consulta
        $dayC=date("d", strtotime($request->fini));
        $mesC=date("m", strtotime($request->fini));
        $añoC=date("Y", strtotime($request->fini));
        for ($i=0; $i <=sizeof($array) ; $i++) { 
            if ($i==($mesC-1)) {
                $mesC=$array[$i];
                break;
                  }       
        }
        $fechaC=$dayC.' de '.$mesC.' de '.$añoC;


       
    //////////////nombre de tabla///////////////////////
     $queryNameCxc =" 
     DECLARE @fechaA DATE    
     SELECT @fechaA = '".$fecha."'
    

     SELECT 
      DISTINCT
     cxcTrNcto as 'Cliente' 
     
     FROM cxcTr       
     JOIN bd_admOlimpia.dbo.admon ON admonCmon = cxcTrMtra AND admonMdel = 0    
     JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0   
     JOIN inloc ON inlocCloc = cxcTrCloc AND inlocMdel = 0     
     JOIN cutcu ON cutcuCtcu = cxcTrCtcu AND cutcuMdel = 0     
     
     LEFT JOIN    
     (       
     SELECT   
     imLvtNlvt, imLvtNNit,     
     imLvtRsoc, imLvtNrfc,     
     imlvtNvta, imLvtEsfc,  
     imLvtMdel, imLvtFech  
     FROM imlvt WHERE imlvtNvta <> 0  
     UNION     
     (     
     SELECT       
     imLvtNlvt, imLvtNNit,        
     imLvtRsoc, imLvtNrfc,      
     vtVxFNvta as imlvtNvta,    
     imLvtEsfc, imLvtMdel,         
     imLvtFech            
     FROM imlvt         
     JOIN vtVxF ON imLvtNlvt = vtVxFLvta 
     )     
     )as imlvt      
     ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0    
     LEFT JOIN    
     (        
     SELECT       
     crentCent,      
     maprfDplz as 'DiasPlazo'   
     FROM crEnt       
     LEFT JOIN maprf ON maprfCprf = crentClsf AND maPrfMdel = 0   
     WHERE crentMdel = 0 AND crentStat = 0   
     ) as crent     
     ON crentCent = cxcTrCcto   
     --COBROS DE CXC        
     LEFT JOIN 
     (       
     SELECT liqdCNtcc, SUM(liqdCAcmt) as AcuentaF    
     FROM liqdC   
     JOIN liqXC ON liqdCNtra = liqXCNtra       
     WHERE liqXCMdel = 0         
     AND liqXCFtra <= '".$fechaCarta."'      
     GROUP BY liqdCNtcc 
     )as cobros    
     ON cobros.liqdCNtcc = cxcTrNtra      
     WHERE (cxcTrImpt - cxcTrAcmt) <> 0 AND cxcTrMdel = 0      
     AND cxcTrCcbr IN (29,6,57,28,76,42,40,62,39,55,18,20,16,17,46,37,48,21,9,4,65,74,63,64,2,3,19,47,58)
 AND ".$estadoY."   
    -- AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30)  
     --and DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')>(30) 
    -- AND DATEDIFF(DAY, cxcTrFtra, ''".$fecha."')) <= 30   
     --AND DATEDIFF(DAY, cxcTrFtra, '".$fechaCarta."') <= (30 + 15) 
     and  cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2))<>0
     AND cxcTrNcto NOT IN ('CAJERO 2 BALLIVIAN . ','CAJERO 2 CALACOTO .','CAJERO 2 HANDAL .','CAJERO 2 MARISCAL .','CAJERO BALLIVIAN .'
,'CAJERO CALACOTO .','CAJERO LIBRO BALLIVIAN','CAJERO LIBRO HANDAL','CAJERO LIBRO CALACOTO','CAJERO LIBRO MARISCAL','CAJERO LIBRO HANDAL','CAJERO BALLIVIAN .','CAJERO 2 MARISCAL .','CAJERO 2 HANDAL .')
    
     ";

     $nameCxc=DB::connection('sqlsrv')->select(DB::raw($queryNameCxc));
     
     $ciclo=sizeof($nameCxc);
     $arrayName=[];
     $cadena="";
     foreach ($nameCxc as $key => $value) {
     $arrayName[$key]=$value->Cliente;
     }
    
      if (empty($nameCxc)) {
        return dd("DATOS NULOS REPORTE AL ADMINISTRADOR");
      }
      else { 
       
    foreach ($nameCxc as $key => $value) {
        
     /////////contenido de tabla////////////
     $query="
     DECLARE @fechaA DATE    
     SELECT @fechaA = '".$fecha."'
     SELECT 
  
  cxcTrNcto as 'Cliente',   
  imlvt.imLvtNrfc as 'NroFac',  
  CONVERT(varchar,cxcTrFtra,103) as 'Fecha',   
  CONVERT(varchar,DATEADD(day, 30/*DiasPlazo*/, cxcTrFtra), 103) as 'FechaVenc',  
    --DiasPlazo, 
  CASE      
  WHEN DATEDIFF(DAY, cxcTrFtra, @fechaA) <= 30/*DiasPlazo*/ THEN 'VIGENTE'   
  WHEN DATEDIFF(DAY, cxcTrFtra, @fechaA) <= (30/*DiasPlazo*/ + 15) THEN 'VENCIDO'  
  WHEN DATEDIFF(DAY, cxcTrFtra, @fechaA) > (30/*DiasPlazo*/ + 15) THEN 'MORA'   
  END as estado,
  cast(cxcTrImpt as decimal(10,2))as 'ImporteCXCBS',   
  REPLACE(cast(ISNULL(cobros.AcuentaF,0) as decimal(10,2)),',', '.') as 'ACuentaBS', 
  REPLACE(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2)),',', '.') as 'SaldoBS',    
   cast(cxcTrImpt * 6.96 as decimal(10,2))as 'ImporteCXCDolar',   
  REPLACE(cast(ISNULL(cobros.AcuentaF*6.96,0) as decimal(10,2)),',', '.') as 'ACuentaDolar', 
  REPLACE(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0))*6.96 as decimal(10,2)),',', '.') as 'SaldoDolar' 
  
  
  FROM cxcTr       
  JOIN bd_admOlimpia.dbo.admon ON admonCmon = cxcTrMtra AND admonMdel = 0    
  JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0   
  JOIN inloc ON inlocCloc = cxcTrCloc AND inlocMdel = 0     
  JOIN cutcu ON cutcuCtcu = cxcTrCtcu AND cutcuMdel = 0     
  --//CXC generadas por VENTAS     
  /*JOIN        
  (          SELECT *       
  FROM cptra      
  JOIN cptrd ON cptrdNtra = cptraNtra AND cptrdTtra = 11    
  WHERE cptraTtra = 21 AND cptraMdel = 0      
  ) cptra    
  ON cptrdNtrD = cxcTrNtra*/  
  --//CXC generadas por VENTAS    
  LEFT JOIN    
  (       
  SELECT   
  imLvtNlvt, imLvtNNit,     
  imLvtRsoc, imLvtNrfc,     
  imlvtNvta, imLvtEsfc,  
  imLvtMdel, imLvtFech  
  FROM imlvt WHERE imlvtNvta <> 0  
  UNION     
  (     
  SELECT       
  imLvtNlvt, imLvtNNit,        
  imLvtRsoc, imLvtNrfc,      
  vtVxFNvta as imlvtNvta,    
  imLvtEsfc, imLvtMdel,         
  imLvtFech            
  FROM imlvt         
  JOIN vtVxF ON imLvtNlvt = vtVxFLvta 
  )     
  )as imlvt      
  ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0    
  LEFT JOIN    
  (        
  SELECT       
  crentCent,      
  maprfDplz as 'DiasPlazo'   
  FROM crEnt       
  LEFT JOIN maprf ON maprfCprf = crentClsf AND maPrfMdel = 0   
  WHERE crentMdel = 0 AND crentStat = 0   
  ) as crent     
  ON crentCent = cxcTrCcto   
  --COBROS DE CXC        
  LEFT JOIN 
  (       
  SELECT liqdCNtcc, SUM(liqdCAcmt) as AcuentaF    
  FROM liqdC   
  JOIN liqXC ON liqdCNtra = liqXCNtra       
  WHERE liqXCMdel = 0       
  AND liqXCFtra <= '".$fechaCarta."'    
      
  GROUP BY liqdCNtcc 
  )as cobros    
  ON cobros.liqdCNtcc = cxcTrNtra      
  WHERE (cxcTrImpt - cxcTrAcmt) <> 0 AND cxcTrMdel = 0      
  AND cxcTrCcbr IN (29,6,57,28,76,42,40,62,39,55,18,20,16,17,46,37,48,21,9,4,65,74,63,64,2,3,19,47,58)   
  AND ".$estadoY."
  --AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30)  
 --and DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')>(30) 
 -- AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= 30   

 -- AND DATEDIFF(DAY, cxcTrFtra, '".$fechaCarta."') <= (30 + 15) 
  and  cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2))<>0
-- and cxcTrNcto ='ANA CLAVIJO'        
--and cxcTrNcto ='$value->Cliente'   
AND cxcTrNcto NOT IN ('CAJERO 2 BALLIVIAN . ','CAJERO 2 CALACOTO .','CAJERO 2 HANDAL .','CAJERO 2 MARISCAL .','CAJERO BALLIVIAN .'
,'CAJERO CALACOTO .','CAJERO LIBRO BALLIVIAN','CAJERO LIBRO HANDAL','CAJERO LIBRO CALACOTO','CAJERO LIBRO MARISCAL','CAJERO LIBRO HANDAL','CAJERO BALLIVIAN .','CAJERO 2 MARISCAL .','CAJERO 2 HANDAL .')
order by Cliente
";

   $cxcCarta=DB::connection('sqlsrv')->select(DB::raw($query));
  
   
        //totales----------------------
        $total="
        DECLARE @fechaA DATE    
        SELECT @fechaA = '".$fecha."'
        SELECT
        cxcTrNcto as 'Cliente' ,
        sum(cast(cxcTrImpt as decimal(10,2)))as 'ImporteCXCBS',   
        REPLACE(sum(cast(ISNULL(cobros.AcuentaF,0) as decimal(10,2))),',', '.') as 'ACuentaBS', 
        REPLACE(sum(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2))),',', '.') as 'SaldoBS',    
         sum(cast(cxcTrImpt * 6.96 as decimal(10,2)))as 'ImporteCXCDolar',   
        REPLACE(sum(cast(ISNULL(cobros.AcuentaF*6.96,0) as decimal(10,2))),',', '.') as 'ACuentaDolar', 
        REPLACE(sum(cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0))*6.96 as decimal(10,2))),',', '.') as 'SaldoDolar' 
        
        FROM cxcTr       
        JOIN bd_admOlimpia.dbo.admon ON admonCmon = cxcTrMtra AND admonMdel = 0    
        JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0   
        JOIN inloc ON inlocCloc = cxcTrCloc AND inlocMdel = 0     
        JOIN cutcu ON cutcuCtcu = cxcTrCtcu AND cutcuMdel = 0     
        
        LEFT JOIN    
        (       
        SELECT   
        imLvtNlvt, imLvtNNit,     
        imLvtRsoc, imLvtNrfc,     
        imlvtNvta, imLvtEsfc,  
        imLvtMdel, imLvtFech  
        FROM imlvt WHERE imlvtNvta <> 0  
        UNION     
        (     
        SELECT       
        imLvtNlvt, imLvtNNit,        
        imLvtRsoc, imLvtNrfc,      
        vtVxFNvta as imlvtNvta,    
        imLvtEsfc, imLvtMdel,         
        imLvtFech            
        FROM imlvt         
        JOIN vtVxF ON imLvtNlvt = vtVxFLvta 
        )     
        )as imlvt      
        ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0    
        LEFT JOIN    
        (        
        SELECT       
        crentCent,      
        maprfDplz as 'DiasPlazo'   
        FROM crEnt       
        LEFT JOIN maprf ON maprfCprf = crentClsf AND maPrfMdel = 0   
        WHERE crentMdel = 0 AND crentStat = 0   
        ) as crent     
        ON crentCent = cxcTrCcto   
        --COBROS DE CXC        
        LEFT JOIN 
        (       
        SELECT liqdCNtcc, SUM(liqdCAcmt) as AcuentaF    
        FROM liqdC   
        JOIN liqXC ON liqdCNtra = liqXCNtra       
        WHERE liqXCMdel = 0         
        AND liqXCFtra <= '".$fechaCarta."'  
      --  AND liqXCFtra <= '07/10/2022'       
        GROUP BY liqdCNtcc 
        )as cobros    
        ON cobros.liqdCNtcc = cxcTrNtra      
        WHERE (cxcTrImpt - cxcTrAcmt) <> 0 AND cxcTrMdel = 0      
        AND cxcTrCcbr IN (29,6,57,28,76,42,40,62,39,55,18,20,16,17,46,37,48,21,9,4,65,74,63,64,2,3,19,47,58)   
        AND ".$estadoY."
        -- AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30)  
     --  and DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')>(30) 
    --AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')) <= 30    
        and  cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2))<>0
      -- and cxcTrNcto ='$value->Cliente'
      AND cxcTrNcto NOT IN ('CAJERO 2 BALLIVIAN . ','CAJERO 2 CALACOTO .','CAJERO 2 HANDAL .','CAJERO 2 MARISCAL .','CAJERO BALLIVIAN .'
      ,'CAJERO CALACOTO .','CAJERO LIBRO BALLIVIAN','CAJERO LIBRO HANDAL','CAJERO LIBRO CALACOTO','CAJERO LIBRO MARISCAL','CAJERO LIBRO HANDAL','CAJERO BALLIVIAN .','CAJERO 2 MARISCAL .','CAJERO 2 HANDAL .')   GROUP BY cxcTr.cxcTrNcto
       order by Cliente
   ---   and cxcTrNcto ='ANA CLAVIJO'  
      "; 
        $cadenaBS="";
        $cadenaDL="";
        $totalS=DB::connection('sqlsrv')->select(DB::raw($total));   
        $formatter = new NumeroALetras();

                 
           
     $arrayMoney=[];       
     $arraycxcCarta= [];  
 
   //  foreach ($totalS as $key => $value) {
   //     $cadenaBS=$formatter->toMoney($value->SaldoBS);
   //    $cadenaDL=$formatter->toMoney($value->SaldoDolar);
   
  //  }  
$cadenaBS1=[];
$cadenaDL1=[];
     foreach ($cxcCarta as $key => $value) {
         if (!array_key_exists($value->Cliente, $arraycxcCarta)) 
         {
             $arraycxcCarta[$value->Cliente] = [$cxcCarta[$key]];
         }
         else
         {
             array_push($arraycxcCarta[$value->Cliente], $cxcCarta[$key]);
         }
     }
 
     foreach ($totalS as $key => $value) {
 
        if (!array_key_exists($value->Cliente, $totalS)) 
        {
            $totalS[$value->Cliente] = [$totalS[$key]];
            unset($totalS[$key]);
            
           
        }
        else
        {
            array_push($totalS[$value->Cliente], $totalS[$key]);
            unset($totalS[$key]);

        }
   
        array_push($cadenaBS1,strtolower($formatter->toMoney($value->SaldoBS)));
        array_push($cadenaDL1,strtolower($formatter->toMoney($value->SaldoDolar)));
          
    }

  //  return dd($totalS);


                      if($request->genPDF =="export")
                      {
                        $pdf = \PDF::loadView('reports.pdf.carta',compact('cadenaDL1','cadenaBS1','fechaC','fechaH','nameCxc','cxcCarta','totalS','cadenaDL','cadenaBS','arraycxcCarta','formatter'))
                        ->setPaper('letter')
                        ->setOption('margin-top',35)
                        ->setOption('margin-left', 15)
                        ->setOption('margin-right', 15)
                        ->setOption('margin-bottom', 35)
                        //->setOption('footer-right','Pag [page] de [toPage]')
              
                        ->setOption('footer-font-size',8);
                        
                    
                  
                        return $pdf->inline('cxc_pdf', compact('fecha','fechaCarta'));
                    
                        //  return $pdf->inline('Reportecotizacion_'.$fecha2.'.pdf');
                      }  
                      if($request->genVer =="ver")
                      {
                        ///lista de clientes 
                        $queryNameCxc2 =" 
                        DECLARE @fechaA DATE    
                        SELECT @fechaA = '".$fecha."'
                       
                   
                        SELECT 
                        DISTINCT
                        cxcTrNcto as 'Cliente' 
                        
                        FROM cxcTr       
                        JOIN bd_admOlimpia.dbo.admon ON admonCmon = cxcTrMtra AND admonMdel = 0    
                        JOIN bd_admOlimpia.dbo.adusr ON adusrCusr = cxcTrCcbr AND adusrMdel = 0   
                        JOIN inloc ON inlocCloc = cxcTrCloc AND inlocMdel = 0     
                        JOIN cutcu ON cutcuCtcu = cxcTrCtcu AND cutcuMdel = 0     
                        
                        LEFT JOIN    
                        (       
                        SELECT   
                        imLvtNlvt, imLvtNNit,     
                        imLvtRsoc, imLvtNrfc,     
                        imlvtNvta, imLvtEsfc,  
                        imLvtMdel, imLvtFech  
                        FROM imlvt WHERE imlvtNvta <> 0  
                        UNION     
                        (     
                        SELECT       
                        imLvtNlvt, imLvtNNit,        
                        imLvtRsoc, imLvtNrfc,      
                        vtVxFNvta as imlvtNvta,    
                        imLvtEsfc, imLvtMdel,         
                        imLvtFech            
                        FROM imlvt         
                        JOIN vtVxF ON imLvtNlvt = vtVxFLvta 
                        )     
                        )as imlvt      
                        ON (imLvtNvta = cxcTrNtrI) AND imLvtMdel = 0    
                        LEFT JOIN    
                        (        
                        SELECT       
                        crentCent,      
                        maprfDplz as 'DiasPlazo'   
                        FROM crEnt       
                        LEFT JOIN maprf ON maprfCprf = crentClsf AND maPrfMdel = 0   
                        WHERE crentMdel = 0 AND crentStat = 0   
                        ) as crent     
                        ON crentCent = cxcTrCcto   
                        --COBROS DE CXC        
                        LEFT JOIN 
                        (       
                        SELECT liqdCNtcc, SUM(liqdCAcmt) as AcuentaF    
                        FROM liqdC   
                        JOIN liqXC ON liqdCNtra = liqXCNtra       
                        WHERE liqXCMdel = 0         
                        AND liqXCFtra <= '".$fechaCarta."'      
                        GROUP BY liqdCNtcc 
                        )as cobros    
                        ON cobros.liqdCNtcc = cxcTrNtra      
                        WHERE (cxcTrImpt - cxcTrAcmt) <> 0 AND cxcTrMdel = 0      
                        AND cxcTrCcbr IN (29,6,57,28,76,42,40,62,39,55,18,20,16,17,46,37,48,21,9,4,65,74,63,64,2,3,19,47,58) 
                        ----------------  
                  AND ".$estadoY."
                     
                        --AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') <= (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30)  
                       
                        --and DATEDIFF(DAY, cxcTrFtra, '".$fecha."') > (30 + 15) AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')>(30) 
                     -- AND DATEDIFF(DAY, cxcTrFtra, '".$fecha."')) <= 30   
                        and  cast((ISNULL(cxcTrImpt,0)-ISNULL(cobros.AcuentaF,0)) as decimal(10,2))<>0
                    
                        -- and cxcTrNcto ='ANA CLAVIJO'
                        ";
                            
                       $nameCxc2=DB::connection('sqlsrv')->select(DB::raw($queryNameCxc2));
                     //  return dd($nameCxc2);

     
                        return view('carta.admin', compact('nameCxc2','fechaC','fechaH','fecha','fechaCarta','estadoX'));
                      }

                      
                      return dd("error..");
                     
   

        
            }

         }    

     //  return dd($fechaHoy);


   
   
     


                              
                              
                        

    


   
    }


    public function perfil(Request $request)
    {

        $data=request(); 
          
        $id_user=$data['USER'];
        return view('carta.perfil');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\generadorCarta  $generadorCarta
     * @return \Illuminate\Http\Response
     */
    public function show(generadorCarta $generadorCarta)
    {
       
return $generadorCarta;
       
    }
public function pdf(){

               return view('reports.pdf.carta');

     }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\generadorCarta  $generadorCarta
     * @return \Illuminate\Http\Response
     */
    public function edit(generadorCarta $generadorCarta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\generadorCarta  $generadorCarta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, generadorCarta $generadorCarta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\generadorCarta  $generadorCarta
     * @return \Illuminate\Http\Response
     */
    public function destroy(generadorCarta $generadorCarta)
    {
        //
    }
}
