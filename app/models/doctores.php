<?php
include_once "app/models/db.class.php";
class Doctores extends BaseDeDatos {

    public function __construct() {
        $this->conectar();
    }
    public function getAll(){
        return $this->executeQuery("Select id_doctor, nombre_doctor, apellido_doctor 
        from doctores");
    }
    public function getAllOrderByName(){
        return $this->executeQuery("Select id_doctor, nombre_doctor, apellido_doctor 
        from doctores order by nombre_doctor");
    }
    public function save($data){
        return $this->executeInsert("Insert into doctores set 
        nombre_doctor='{$data["nombre_doctor"]}',
        apellido_doctor='{$data["apellido_doctor"]}'");
    }
    public function getDoctoresByName($nombre_doctor){
        return $this->executeQuery("Select id_doctor, nombre_doctor, apellido_doctor 
        from doctores where nombre_doctor='{$nombre_doctor}'");
    }
    public function getOneDoctor($id) {
        return $this->executeQuery("Select id_doctor, nombre_doctor, apellido_doctor 
        from doctores where id_doctor='{$id}'");
    }
    public function update($data) {
        return $this->executeInsert("update doctores set nombre_doctor='{$data["nombre_doctor"]}',
        apellido_doctor='{$data["apellido_doctor"]}' 
        where id_doctor='{$data["id_doctor"]}'");
    }
    public function deleteDoctor($id) {
        return $this->executeInsert("delete from doctores where id_doctor='$id'");
    }
} 