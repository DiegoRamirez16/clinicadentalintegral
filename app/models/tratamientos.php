<?php
include_once "app/models/db.class.php";
class Tratamientos extends BaseDeDatos {

    public function __construct() {
        $this->conectar();
    }
    public function getAll(){
        return $this->executeQuery("Select id_tratamiento, nombre_tratamiento, descripcion_tratamiento 
        from tratamientos order by id_tratamiento");
    }
    public function getAllOrderByName(){
        return $this->executeQuery("Select id_tratamiento, nombre_tratamiento, descripcion_tratamiento 
        from tratamientos order by nombre_tratamiento");
    }
    public function save($data){
        return $this->executeInsert("Insert into tratamientos set 
        nombre_tratamiento='{$data["nombre_tratamiento"]}',
        descripcion_tratamiento='{$data["descripcion_tratamiento"]}'");
    }
    public function getTratamientoByName($nombre_tratamiento){
        return $this->executeQuery("Select id_tratamiento, nombre_tratamiento, descripcion_tratamiento 
        from tratamientos where nombre_tratamiento='{$nombre_tratamiento}'");
    }
    public function getOneTratamiento($id) {
        return $this->executeQuery("Select id_tratamiento, nombre_tratamiento, descripcion_tratamiento 
        from tratamientos where id_tratamiento='{$id}'");
    }
    public function update($data) {
        return $this->executeInsert("update tratamientos set nombre_tratamiento='{$data["nombre_tratamiento"]}',
        descripcion_tratamiento='{$data["descripcion_tratamiento"]}' 
        where id_tratamiento='{$data["id_tratamiento"]}'");
    }
    public function deleteTratamiento($id) {
        return $this->executeInsert("delete from tratamientos where id_tratamiento='$id'");
    }
} 


