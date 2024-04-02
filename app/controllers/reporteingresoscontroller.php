<?php
include_once "app/models/ingresos.php";
include_once "vendor/autoload.php";
class ReporteIngresosController extends Controller {
    private $ingresos;
    public function __construct($parametro) {
        $this->ingresos= new Ingresos();
        parent::__construct("reporteingresos",$parametro,true);
    }
    public function getReporte(){
       
        $registros=$this->ingresos->getContadoReporte($_GET);
        //print_r($registros);
        //Encabezado informe
        $htmlHeader = '<div style="text-align: center;">
        <h3 style="margin: 5px 0 0; font-size: 15px;  font-family: Roboto; display: inline-block; vertical-align: middle;">Clinica Dental Integral</h3>
        <h3 style="margin: 5px 0 0; font-size: 15px;  font-family: Roboto; display: inline-block; vertical-align: middle;">Dra.Ana Doris Rivera</h3>
        <img src="/var/www/html/clinicadentalintegral/public_html/images/logodiente.png" style="width:55px; display: inline-block; vertical-align: right;">
        <h3 style="margin: 5px 0 0; font-size: 15px;text-align: left;font-family: Roboto; margin-top:45px">Listado de Pagos al contado</h3>
        </div>';
        //Informacion 
        //Cuerpo informe
        $html="<table widht='100%' border-collapse: collapse; ><thead><tr>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Id Pago Contado</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Nombre</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Apellido</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Telefono</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Fecha realizada del pago</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Monto pagado</th>";
        

        $html.="</tr></thead><tbody>";
        $total=0;
        foreach($registros as $key => $value){
            $html.="<tr>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["id_pagocontado"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["nombre_paciente"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["apellido_paciente"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["telefono_paciente"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["fecha_pago"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>$ {$value["monto_contado"]}</td>";
            $html.="</tr>";
            $total+=$value["monto_contado"];
        }
        $html.="<tr>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;' colspan='6'>Total pagos contado: $ $total</th>";
       // $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>$total</td>";
        $html.="</tr>";


        $html.="</tbody></table>";
        //echo $html;
        $mpdfConfig=array(
            'mode'=>'utf-8',
            'format'=>'Letter',
            'default_font_size'=>0,
            'default_font'=>'',
            'margin_left'=>10,
            'margin_right'=>10,
            'margin_top'=>40,
            'margin_header'=>10,
            'margin_footer'=>20,
            'orientation'=>'P'
        );
        
        $mpdf=new \Mpdf\Mpdf($mpdfConfig);
        $mpdf->SetHTMLHeader($htmlHeader);
        $mpdf->WriteHtml($html);
        $mpdf->Output();
    }

   

}