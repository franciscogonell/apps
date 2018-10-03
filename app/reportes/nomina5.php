<?php





set_time_limit(0);

$time2=strtotime($_GET["f2"]);



$newformat2 = date('d-m-Y',$time2);



$fecha = $newformat2;
$nuevafecha = strtotime ( '+1 day' , strtotime ( $fecha ) ) ;
$nuevafecha = date ( 'm/d/Y' , $nuevafecha );





   require_once('../lib/pdf/mpdf.php');

# Invoco el JSON desde la API


///$data = file_get_contents('https://script.google.com/macros/s/AKfycbwcwCvTi9VWWGc-A4tPerRWe41RcRGpcD_f_bfedUNtcWnyBupd/exec?apiKey=1234f&operation=GetTickers&f1='.$_GET["f1"].'&f2='.$_GET["f2"].'');


$data = file_get_contents('https://script.google.com/macros/s/AKfycbwcwCvTi9VWWGc-A4tPerRWe41RcRGpcD_f_bfedUNtcWnyBupd/exec?apiKey=1234f&operation=GetTickers&f1='.$_GET["f1"].'&f2='.$nuevafecha.'');


$time = strtotime($_GET["f1"]);

$newformat = date('d-m-Y',$time);

$time = strtotime($_GET["f2"]);

$newformat1 = date('d-m-Y',$time);






$data_array = json_decode($data);

$matches=count($data_array->records)-1;

$css=file_get_contents('css/style4.css');

$z=0;

   
 
 

 


for ($x =0; $x <= $matches; $x++) {


  


  $html2.= '
    <link rel="stylesheet" href="css/style4.css" media="all" />
  </head>
  <body>


  <header class="clearfix">
                   <div id="logo">
                   <img src="img/farm.png">
                  

        
                   </div>
                   <h1>COMPROBANTE DE NOMINA AGRICOLA</h1>

                  
                  
                  



                   <div id="company" class="clearfix">


        
                   <div id="project">
                      
                      
                      <div><img src="'.$data_array->records[$x]->foto.'"><h2>'. $data_array->records[$x]->ticker.'</h2></div>
                      <div><span></span>'. $data_array->records[$x]->name.'</div>
        
                     <div><span>DESDE </span>'.$newformat.'</div>
                     <div><span>HASTA </span>'.$newformat1.'</div>
                   </div>
                 </header>
                 <main>
                     <table class ="table-condensed">
                       <thead>
                           <tr>
                             <th class="service">FECHA</th>
                             <th class="desc">LABOR</th>
                             <th class="desc">CANTIDAD</th>
                             <th class="desc">CC</th>
                             <th>HORAS</th>
                             <th>PRECIO</th>
                             <th>BRUTO</th>
                             </tr>
                        </thead>
                        <tbody>';

                        $totalbruto=0;
                        $totalhoras=0;
                        $totalhorasextras=0;
                        $vhorasextras=0;
                        $vtss=0;

                        for ($j = 0; $j <= count ($data_array->records[$x]->items) -1; $j++) {
                          $totalbruto=$totalbruto+$data_array->records[$x]->items[$j]->bruto;
                          $totalhoras=$totalhoras+$data_array->records[$x]->items[$j]->horas;
                          $totalhorasextras=$totalhorasextras+$data_array->records[$x]->items[$j]->hrsextras;
                          $vhorasextras=$vhorasextras+$data_array->records[$x]->items[$j]->vhorasextras;
                          $vtss=$vtss+$data_array->records[$x]->items[$j]->tss;
                         $html2.='
  
    
 


                              <tr>
                                    <td class="service">'.$data_array->records[$x]->items[$j]->fecha .'</td>
                                    <td class="desc">'.$data_array->records[$x]->items[$j]->nlabor.'</td>
                                    <td class="desc">'.$data_array->records[$x]->items[$j]->cantidad.'</td>
                                    <td class="desc">'.$data_array->records[$x]->items[$j]->cc.'</td>
                                    <td class="total">'.number_format($data_array->records[$x]->items[$j]->horas,2).'</td>
                                    <td class="total">$'.number_format($data_array->records[$x]->items[$j]->precio,2).'</td>
                                    <td class="total">$'.number_format($data_array->records[$x]->items[$j]->bruto,2).'</td>

                                  
                                    
                                    
                                    
                               </tr>';
                          

                          }

                         $html2.='
                         <tr>
                            <td class="service">Total de Horas Normales ('.number_format($totalhoras,2).')</th>
                            <td class="desc">Total de Horas Extras ('.number_format($totalhorasextras,2).')</th>
                            
                             <td colspan="4">SUBTOTAL</td>
                             <td class="total">$'.number_format($totalbruto,2).'</td>
                         </tr>
                         <tr>
                             <td></td>
                              <td></td>

                             <td colspan="4">HORAS EXTRAS</td>
                             <td class="total">$'.number_format($vhorasextras,2).'</td>
                         </tr>
                         <tr>
                         <td></td>
                         <td></td>
                             <td colspan="4" class="tss">RETENCION TSS 5.91%</td>
                             <td class="tss">($'.number_format($vtss,2).')</td>
                         </tr>
                         <tr >
                            <td colspan="6" class="grand total">TOTAL</td>
                            <td class="grand total">$'.number_format($totalbruto+$vhorasextras-$vtss,2).'</td>
                          </tr>
                       </tbody>
                   </table>

                  
                   
                   
                   
                 

                </main>';

         $html2 .= '"<pagebreak />"';

         

         
              
                
                


                

} 




//$mpdf = new mPdf('',array(215.9,139.7),'','',5,5,10,5,5,5);

$mpdf = new mPdf('',array(215.9,139.7),'','',5,5,10,5,5,5);
//$mpdf = new mPdf('c','A4');
                
               

            // $mpdf->WriteHTML($css,1);
            $mpdf->WriteHTML($html2);


                



   
              $mpdf->Output('reporte.pdf','I');


?>

