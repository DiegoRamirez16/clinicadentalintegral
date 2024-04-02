<?php
include_once "app/models/db.class.php";
class Expedientes extends BaseDeDatos {

    public function __construct() {
        $this->conectar();
    }

    // Funcion para obtener todos los datos a la tabla
    public function getAll() {
        return $this->executeQuery("select id_expediente,motivo_consulta,date_format(fecha_expediente,'%d-%m-%Y') as fecha_expediente,
        nombre_paciente,apellido_paciente from expediente inner join pacientes USING(id_paciente) order by id_expediente desc");
    }

    // Nombre del paciente por Expediente
    public function getNameExpe($id_expediente) {
        return $this->executeQuery("select nombre_paciente as Nombre from expediente inner join pacientes USING(id_paciente) where id_expediente='{$id_expediente}'");
    }

    // Funcion para guardar registro
    public function save($data) {

        $this->executeInsert("insert into logs set id_usr='{$_SESSION["id_usr"]}', descripcion='Se inserto un expediente para el paciente con id {$data["id_paciente"]}',fecha=now()");
        return $this->executeInsert("Insert into expediente set motivo_consulta='{$data["motivo_consulta"]}',id_paciente='{$data["id_paciente"]}',fecha_expediente='{$data["fecha_expediente"]}'");
    }

    // Funcion para obtener el id del expediente
    public function getExpedienteById($id_expediente) {
        return $this->executeQuery("Select id_expediente, motivo_consulta,fecha_expediente
        from expediente where id_expediente='{$id_expediente}'");
    }

    // Funcion para obtener el id paciente del expediente
    public function getExpedienteByName($id_paciente) {
        return $this->executeQuery("Select id_expediente, id_paciente, motivo_consulta,fecha_expediente
        from expediente where id_paciente='{$id_paciente}'");
    }

    // 
    public function getOneExpediente($id) {
        return $this->executeQuery("Select id_expediente, motivo_consulta,fecha_expediente,id_paciente 
        from expediente where id_expediente='{$id}'");
    }

    // Funcion para actualizar
    // UPDATE expediente JOIN pacientes ON expediente.id_paciente = pacientes.id_paciente 
    // SET expediente.motivo_consulta = 'Problemas en cordiales inferiores', expediente.fecha_expediente = '2023-05-22'
    // WHERE expediente.id_expediente = '12' AND pacientes.id_paciente = '1'
    public function update($data) {
        return $this->executeInsert("update expediente join pacientes on expediente.id_paciente = pacientes.id_paciente
        set expediente.motivo_consulta='{$data["motivo_consultac"]}', expediente.fecha_expediente='{$data["fecha_expedientec"]}'
        where expediente.id_expediente='{$data["id_expedientec"]}' and pacientes.id_paciente='{$data["id_pacientec"]}'");
    }
    public function update2($data) {
        return $this->executeInsert("update expediente set motivo_consulta='{$data["motivo_consulta"]}',
        id_paciente='{$data["id_paciente"]}',fecha_expediente='{$data["fecha_expediente"]}'
        where id_expediente='{$data["id_expediente"]}'");
    }

    // Borrar Expediente
    public function deleteExpediente($id) {
        return $this->executeInsert("delete from expediente where id_expediente='$id'");
    }

    // Reportes

    public function getExpedienteReporte($data) {
        $condicion="";
        if ($data["idpaciente"]!="0"){
            $condicion.=" and b.id_paciente='{$data["idpaciente"]}'";
        }
        if ($data["idexpediente"]!="0"){
            $condicion.=" and a.id_expediente='{$data["idexpediente"]}'";
        }

        return $this->executeQuery("select a.id_expediente,a.motivo_consulta,a.fecha_expediente,b.observacion_paciente,b.alergia_paciente,padecimiento_paciente,date_format(b.fecha_nacimiento, '%d-%m-%Y') as fecha_nacimiento,b.sexo_paciente,b.telefono_paciente,b.nombre_paciente,b.apellido_paciente,date_format(a.fecha_expediente, '%d-%m-%Y') as fecha_ex from pacientes b inner join expediente a USING(id_paciente) where 1=1 $condicion");
    
    }
    
} 
