<?php
include_once "app/models/controlesclinico.php";
include_once "vendor/autoload.php";
class ReporteControlesController extends Controller {
    private $controles;
    public function __construct($parametro) {
        $this->controles= new ControlesClinico();
        parent::__construct("reportecontroles",$parametro,true);
    }
    public function getReporte(){
       
        $registros=$this->controles->getControlesReporte($_GET);
        //print_r($registros);
        //Encabezado informe
        //Encabezado informe
        $htmlHeader = '<div style="text-align: center;">
        <h3 style="margin: 5px 0 0; font-size: 15px;  font-family: Roboto; display: inline-block; vertical-align: middle;">Clinica Dental Integral</h3>
        <h3 style="margin: 5px 0 0; font-size: 15px;  font-family: Roboto; display: inline-block; vertical-align: middle;">Dra.Ana Doris Rivera</h3>
        <img src="/var/www/html/clinicadentalintegral/public_html/images/logodiente.png" style="width:55px; display: inline-block; vertical-align: right;">
        <h3 style="margin: 5px 0 0; font-size: 15px;text-align: left;font-family: Roboto; margin-top:45px">Listado de Controles Clinicos</h3>
        </div>';
        //Informacion 
        //Cuerpo informe
        $html="<table widht='100%' border-collapse: collapse; ><thead><tr>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Id Control Clinico</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Tratamiento</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Fecha control clinico</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Diagnostico</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Observacion</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Expediente</th>";
        $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center; background-color: #e3e4e5;'>Nombre del Paciente</th>";

        $html.="</tr></thead><tbody>";
        $total=0;
        foreach($registros as $key => $value){
            $html.="<tr>";
            //$html.="<td>".($key+1)."</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["id_controles"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["nombre_tratamiento"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["fecha_control"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["diagnostico"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["observacion_control"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["id_expediente"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["nombre_paciente"]}</td>";
            $html.="</tr>";
        }


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