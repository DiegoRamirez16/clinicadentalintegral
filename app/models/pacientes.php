<?php
include_once "app/models/db.class.php";
class Pacientes extends BaseDeDatos {

    public function __construct() {
        $this->conectar();
    }

    // Funcion para obtener todos los datos a la tabla
    public function getAll() {
        return $this->executeQuery("Select id_paciente, nombre_paciente, apellido_paciente, telefono_paciente,
        date_format(fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente from pacientes order by id_paciente desc");
    }
    // Funcion para obtener todos los pacientes masculinos
    public function getAllMasculino() {
        return $this->executeQuery("Select id_paciente, nombre_paciente, apellido_paciente, telefono_paciente,
        date_format(fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente from pacientes 
        where sexo_paciente='Masculino' order by id_paciente desc");
    }
    // Funcion para obtener todos los pacientes femeninos
    public function getAllFemenino() {
        return $this->executeQuery("Select id_paciente, nombre_paciente, apellido_paciente, telefono_paciente,
        date_format(fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente from pacientes 
        where sexo_paciente='Femenino' order by id_paciente desc");
    }
    // Todos los pacientes sin expediente
    public function getAllNoExp() {
        return $this->executeQuery("Select id_paciente, nombre_paciente, apellido_paciente, telefono_paciente, 
        date_format(fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente, exp 
        from pacientes where exp=0 order by nombre_paciente asc");
    }
    // Todos los pacientes con expediente
    public function getAllConExp() {
        return $this->executeQuery("Select id_paciente, nombre_paciente, apellido_paciente, telefono_paciente, 
        date_format(fecha_nacimiento,'%d-%m-%Y') as fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente, exp 
        from pacientes where exp=1 order by nombre_paciente asc");
    }
    // Funcion contar total de pacientes
    public function getTotalPacientes() {
        return $this->executeQuery("select COUNT(*) as TotalPacientes from pacientes");
    }
    // Funcion contar total de pacientes masculinos
    public function getTotalMasculino() {
        return $this->executeQuery("select COUNT(*) as TotalMas from pacientes where sexo_paciente='Masculino'");
    }
    // Funcion contar total de pacientes masculinos
    public function getTotalFemenino() {
        return $this->executeQuery("select COUNT(*) as TotalFem from pacientes where sexo_paciente='Femenino'");
    }

    // Funcion obtener datos por name
    public function getPacienteByName($paciente) {
        return $this->executeQuery("Select id_paciente, nombre_paciente,apellido_paciente,telefono_paciente,
        fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente from pacientes where nombre_paciente='{$paciente}'");
    }

    // Funcion para guardar registro
    public function save($data) {
        $this->executeInsert("insert into logs set id_usr='{$_SESSION["id_usr"]}', descripcion='Se inserto un paciente para el paciente con nombre {$data["nombre_paciente"]} {$data["apellido_paciente"]}' ,fecha=now()");

        return $this->executeInsert("insert into pacientes set nombre_paciente='{$data["nombre_paciente"]}',apellido_paciente='{$data["apellido_paciente"]}'
        ,telefono_paciente='{$data["telefono_paciente"]}',fecha_nacimiento='{$data["fecha_nacimiento"]}',
        sexo_paciente='{$data["sexo_paciente"]}',observacion_paciente='{$data["observacion_paciente"]}',alergia_paciente='{$data["alergia_paciente"]}',
        padecimiento_paciente='{$data["padecimiento_paciente"]}', exp='{$data["exp"]}'");
    }

    // Borrar
    public function deletePaciente($id) {
        return $this->executeInsert("delete from pacientes where id_paciente='$id'");
    }

    // Funcion para Actualizar
    public function update($data) {
        return $this->executeInsert("update pacientes set 
        nombre_paciente='{$data["nombre_paciente"]}',apellido_paciente='{$data["apellido_paciente"]}',
        telefono_paciente='{$data["telefono_paciente"]}',fecha_nacimiento='{$data["fecha_nacimiento"]}',
        sexo_paciente='{$data["sexo_paciente"]}',observacion_paciente='{$data["observacion_paciente"]}',alergia_paciente='{$data["alergia_paciente"]}',
        padecimiento_paciente='{$data["padecimiento_paciente"]}' where id_paciente={$data["id_paciente"]}");
    }

    //
    public function getOnePaciente($id) {
        return $this->executeQuery("Select id_paciente,nombre_paciente,apellido_paciente,
        telefono_paciente,fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente from pacientes where id_paciente='{$id}'");
    }
}
