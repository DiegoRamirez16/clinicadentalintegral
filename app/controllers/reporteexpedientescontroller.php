<?php
include_once "app/models/expedientes.php";
include_once "vendor/autoload.php";
class ReporteExpedientesController extends Controller {
    private $expediente;
    public function __construct($parametro) {
        $this->expediente= new Expedientes();
        parent::__construct("reporteexpedientes",$parametro,true);
    }
    public function getReporte(){
       
        $registros=$this->expediente->getExpedienteReporte($_GET);
        //print_r($registros);
        //Encabezado informe
        //$registros=$this->expediente->getExpedienteReporte($_GET);
        //Encabezado informe
        $htmlHeader = '<div style="text-align: center;">
        <h3 style="margin: 5px 0 0; font-size: 15px;  font-family: Roboto; display: inline-block; vertical-align: middle;">Clinica Dental Integral</h3>
        <h3 style="margin: 5px 0 0; font-size: 15px;  font-family: Roboto; display: inline-block; vertical-align: middle;">Dra.Ana Doris Rivera</h3>
        <img src="/var/www/html/clinicadentalintegral/public_html/images/logodiente.png" style="width:55px; display: inline-block; vertical-align: right;">
        <h3 style="margin: 5px 0 0; font-size: 15px;text-align: left;font-family: Roboto; margin-top:45px">Listado de Expedientes</h3>
        </div>';
        //Informacion 
        //Cuerpo informe
        //$html="<table widht='100%' border='1'><thead><tr>";
        $html="<table widht='100%' border-collapse: collapse; ><thead><tr>";
        $html.="<th colspan=5 style='text-align: center;'>Información de Expediente</th>";
        $html.="</tr></thead><tbody>";
        $total=0;
        foreach($registros as $key => $value){
            $html.="<tr>";
            //$html.="<td>".($key+1)."</td>";
            $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center;'>ID Expediente</th>";
            $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center;'>Nombre </th>";
            $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center;'>Apellido </th>";
            $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center;'>Motivo Consulta</th>";
            $html.="<th style='padding: 10px; border: 1px solid #999; text-align: center;'>Fecha expediente</th>";
            $html.="<tr>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["id_expediente"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["nombre_paciente"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["apellido_paciente"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["motivo_consulta"]}</td>";
            $html.="<td style='padding: 10px; border: 1px solid #999; text-align: center;'>{$value["fecha_ex"]}</td>";
            //$html.="</tr>";
            $html.="<tr>";
            $html.="<th colspan=5 style='text-align: center;'>Información Personal</th>";
            $html.="<tr>";
            $html.="<td colspan=5 style='padding: 10px; border: 1px solid #999; text-align: center;'>Fecha de nacimiento:{$value["fecha_nacimiento"]} </td>";
            $html.="<tr>";
            $html.="<td colspan=5 style='padding: 10px; border: 1px solid #999; text-align: center;'>Telefono:{$value["telefono_paciente"]} </td>";
            $html.="<tr>";
            $html.="<td colspan=5 style='padding: 10px; border: 1px solid #999; text-align: center;'>Sexo:{$value["sexo_paciente"]} </td>";
            $html.="<tr>";
            $html.="<th colspan=5 style='text-align: center;'>Historial medico</th>";
            $html.="<tr>";
            $html.="<td colspan=5 style='padding: 10px; border: 1px solid #999; text-align: center;'>Observación:{$value["observacion_paciente"]} </td>";
            $html.="<tr>";
            $html.="<td colspan=5 style='padding: 10px; border: 1px solid #999; text-align: center;'>Alergia:{$value["alergia_paciente"]} </td>";
            $html.="<tr>";
            $html.="<td colspan=5 style='padding: 10px; border: 1px solid #999; text-align: center;'>Padecimientos:{$value["padecimiento_paciente"]} </td>";
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