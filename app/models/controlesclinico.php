<?php
include_once "app/models/db.class.php";
class ControlesClinico extends BaseDeDatos {

    public function __construct() {
        $this->conectar();
    }

    public function getAll() {
        return $this->executeQuery("select id_controles, nombre_tratamiento, date_format(fecha_control,'%d-%m-%Y') as fecha_control, 
        diagnostico, observacion_control, nombre_paciente from controles_clinico 
        INNER join tratamientos USING(id_tratamiento) 
        INNER JOIN(expediente inner join pacientes USING(id_paciente)) USING(id_expediente) order by fecha_control ASC");
    }
    // Todos los controles por el ID
    public function getAllId($id) {
        return $this->executeQuery("select id_controles, nombre_tratamiento, date_format(fecha_control,'%d-%m-%Y') as fecha_control, 
        diagnostico, observacion_control, nombre_paciente from controles_clinico 
        INNER join tratamientos USING(id_tratamiento) 
        INNER JOIN(expediente inner join pacientes USING(id_paciente)) USING(id_expediente) where id_expediente='{$id}' order by fecha_control ASC");
    }

    public function getNameExpe($id) {
        return $this->executeQuery("select nombre_paciente as Nombre from expediente inner join pacientes USING(id_paciente) where id_expediente='{$id}'");
    }

    public function getAllOrderByName() {
        return $this->executeQuery("select id_controles, id_tratamiento, fecha_control, diagnostico, observacion_control, id_expediente from controles_clinico order by diagnostico");
    }

    public function getNameById() {
        return $this->executeQuery("select id_expediente,nombre_paciente,id_controles from controles_clinico INNER join(expediente inner join pacientes USING(id_paciente)) USING(id_expediente)");
    }

    public function save($data) {
        $this->executeInsert("insert into logs set id_usr='{$_SESSION["id_usr"]}', descripcion='Se inserto una control para el expediente con id {$data["id_expediente"]}',fecha=now()");
        return $this->executeInsert("insert into controles_clinico set id_tratamiento='{$data["id_tratamiento"]}', fecha_control='{$data["fecha_control"]}',
        diagnostico='{$data["diagnostico"]}',observacion_control='{$data["observacion_control"]}',id_expediente='{$data["id_expediente"]}'");
    }

    public function getControlClinicoByName($diagnostico) {
        return $this->executeQuery("Select id_controles, id_tratamiento, fecha_control, diagnostico, observacion_control, id_expediente from controles_clinico where id_controles='{$diagnostico}'");
    }

    public function getOneControlClinico($id) {
        return $this->executeQuery("Select id_controles, id_tratamiento, fecha_control, diagnostico, observacion_control, 
        id_expediente from controles_clinico where id_controles='{$id}'");
    }
    public function update($data) {
        return $this->executeInsert("update controles_clinico set id_tratamiento='{$data["id_tratamiento"]}', 
        fecha_control='{$data["fecha_control"]}', diagnostico='{$data["diagnostico"]}', observacion_control='{$data["observacion_control"]}',
        id_expediente='{$data["id_expediente"]}'
        where id_controles={$data["id_controles"]}");
    }

    public function deleteControlClinico($id) {
        return $this->executeInsert("delete from controles_clinico where id_controles='$id'");
    }

    public function getControlesByPaciente() {
        return $this->executeQuery("Select a.id_controles, b.nombre_tratamiento, DATE_FORMAT(a.fecha_control,'%d-%m-%Y') as fecha_control, 
        a.diagnostico, a.observacion_control, c.id_expediente, d.nombre_paciente FROM controles_clinico a INNER JOIN tratamientos b USING (id_tratamiento) 
        INNER JOIN expediente c USING (id_expediente) INNER JOIN pacientes d USING (id_paciente)");
    }

    // Reportes
    public function getControlesReporte($data) {
        $condicion="";
        if ($data["idcontroles"]!="0"){
            $condicion.=" and a.id_controles='{$data["idcontroles"]}'";
        }
        if ($data["idexpediente"]!="0"){
            $condicion.=" and c.id_expediente='{$data["idexpediente"]}'";
        }

        return $this->executeQuery("Select a.id_controles, b.nombre_tratamiento, DATE_FORMAT(a.fecha_control,'%d-%m-%Y') as fecha_control, 
        a.diagnostico, a.observacion_control, c.id_expediente, d.nombre_paciente FROM controles_clinico a INNER JOIN tratamientos b USING (id_tratamiento) 
        INNER JOIN expediente c USING (id_expediente) INNER JOIN pacientes d USING (id_paciente) where 1=1 $condicion");
    
    }

};