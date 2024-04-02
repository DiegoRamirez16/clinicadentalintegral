<?php
include_once "app/models/tratamientos.php";
class TratamientosController extends Controller {
    private $nombre;
    public function __construct($parametro) {
        $this->nombre=new Tratamientos();
        parent::__construct("tratamientos",$parametro,true);
    }
    public function getAll() {
        $records=$this->nombre->getAll();
        $info=array('success'=>true, 'records'=>$records);
        echo json_encode($info);
    }
    public function save() {
        if ($_POST["id_tratamiento"]==0) {
            $datosTratamiento=$this->nombre->getTratamientoByName($_POST["nombre_tratamiento"]);
            if (count($datosTratamiento)>0){
                $info=array('success'=>false, 'msg'=>"El Tratamiento ya existe.");
            } else {
                $records=$this->nombre->save($_POST);
                $info=array('success'=>true, 'msg'=>"Tratamiento guardado con exito.");
            }
        } else {
            $records=$this->nombre->update($_POST);
            $info=array('success'=>true, 'msg'=>"Tratamiento guardado con exito.");
        }
        echo json_encode($info);
    }
    public function getOneTratamiento() {
        $records=$this->nombre->getOneTratamiento($_GET["id"]);
        if (count ($records) > 0 ){
            $info=array('success'=>true, 'records'=>$records);
        } else {
            $info=array('success'=>false, 'msg'=>'El Tratamiento no existe');
        }
        echo json_encode($info);
    }
    public function deleteTratamiento(){
        $records=$this->nombre->deleteTratamiento($_GET["id"]);
        $info=array('success'=>true, 'msg'=>"Tratamiento eliminado con exito");
        echo json_encode($info);
    }
}

