<?php
include_once "app/models/cuotas.php";
include_once "vendor/autoload.php";
class ReporteCuotasController extends Controller {
    private $cuotas;
    public function __construct($parametro) {
        $this->cuotas= new Cuotas();
        parent::__construct("reportecuotas",$parametro,true);
    }
    public function getReporte(){
       
        $registros=$this->cuotas->getCuotaReporte($_GET);
        //print_r($registros);
        //Encabezado informe
        $htmlHeader = '<div style="text-align: center;">
        <h3 style="margin: 5px 0 0; font-size: 15px;  font-family: Roboto; display: inline-block; vertical-align: middle;">Clinica Dental Integral</h3>
        <h3 style="margin: 5px 0 0; font-size: 15px;  font-family: Roboto; display: inline-block; vertical-align: middle;">Dra.Ana Doris Rivera</h3>
        <img src="/var/www/html/clinicadentalintegral/public_html/images/logodiente.png" style="width:55px; display: inline-block; vertical-align: right;">
        <h3 style="margin: 5px 0 0; font-size: 15px;text-align: left;font-family: Roboto; margin-top:45px">Listado de Cuotas Pagadas</h3>
        </div>';
        //Informacion 
        //Cuerpo informe
        $html="<table widht='100%' border-collapse: collapse; ><thead><tr>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Fecha de pago</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Monto</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Cuota</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Id plan Cuota</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Nombre Paciente</th>";
        $html.="</tr></thead><tbody>";
        $total=0;
        foreach($registros as $key => $value){
            $html.="<tr>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>{$value["fecha_pago"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>{$value["monto_cuota"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>{$value["cuota"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>{$value["id_plancuota"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>{$value["nombre_paciente"]}</td>";
            $html.="</tr>";
            $total+=$value["monto_cuota"];
        }
        $html.="<tr>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;' colspan='5'>Total pagos cuotas:$$total</th>";
        //$html.="<td>$total</td>";
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