<?php
include_once "app/models/db.class.php";
class Addcontroles extends BaseDeDatos {
    public function __construct() {
        $this->conectar();
    }

    public function getAll() {
        return $this->executeQuery("select id_expediente,motivo_consulta,date_format(fecha_expediente,'%d-%m-%Y') as fecha_expediente,nombre_paciente,apellido_paciente from expediente inner join pacientes USING(id_paciente)");
    }

    // Nombre del paciente por Expediente
    public function getNameExpe($id_expediente) {
        return $this->executeQuery("select nombre_paciente as Nombre from expediente inner join pacientes USING(id_paciente) where id_expediente='{$id_expediente}'");
    }

    public function getControlClinicoByName($diagnostico) {
        return $this->executeQuery("Select id_controles, id_tratamiento, fecha_control, diagnostico, observacion_control, id_expediente from controles_clinico where id_controles='{$diagnostico}'");
    }
}