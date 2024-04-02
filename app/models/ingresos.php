<?php
include_once "app/models/db.class.php";
class Ingresos extends BaseDeDatos {

    public function __construct() {
        $this->conectar();
    }
    public function getAll(){
        return $this->executeQuery("select id_ingreso, id_pagocontado, id_cuota from ingresos");
    }
    public function getFechas() {
        return $this->executeQuery("select distinct date_format(fecha_pago,'%d-%m-%Y') as fecha_pago from pago_contado");
    }

    public function getContadoReporte($data){
        $condicion="";
        if ($data["idpagocontado"]!="0"){
            $condicion.=" and a.id_pagocontado='{$data["idpagocontado"]}'";
        }
        if ($data["idpaciente"]!="0"){
            $condicion.=" and b.id_paciente='{$data["idpaciente"]}'";
        }

        return $this->executeQuery("select a.id_pagocontado,a.monto_contado,date_format(a.fecha_pago,'%d-%m-%Y') as fecha_pago,b.telefono_paciente,b.nombre_paciente,b.apellido_paciente from pacientes b INNER JOIN pago_contado a USING(id_paciente)  where 1=1 $condicion");
    
    }
} 



