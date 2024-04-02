<?php
include_once "app/models/db.class.php";
class Perfiles extends BaseDeDatos {
    public function __construct() {
        $this->conectar();
    }

    public function getAll($id) {
        return $this->executeQuery("Select id_paciente, nombre_paciente, apellido_paciente, telefono_paciente,
        date_format(fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente from pacientes where id_paciente='$id'");
    }

    public function saveRadiografia($data,$imgg,$id) {
        return $this->executeInsert("insert into pacientes set fotog='{$imgg}' where id_paciente='{$id}'");
    }

    public function getNamePac($id) {
        return $this->executeQuery("Select nombre_paciente as nombre from pacientes where id_paciente='$id'");
    }

    public function getOnePaciente($id) {
        return $this->executeQuery("Select id_paciente,nombre_paciente,apellido_paciente,
        telefono_paciente,fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente from pacientes where id_paciente='{$id}'");
    }

}