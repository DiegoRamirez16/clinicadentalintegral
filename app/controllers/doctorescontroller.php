<?php
include_once "app/models/doctores.php";
class DoctoresController extends Controller {
    private $nombre;
    public function __construct($parametro) {
        $this->nombre=new Doctores();
        parent::__construct("doctores",$parametro,true);
    }
    public function getAll() {
        $records=$this->nombre->getAll();
        $info=array('success'=>true, 'records'=>$records);
        echo json_encode($info);
    }
    public function save() {
        if ($_POST["id_doctor"]==0) {
            $datosDoctor=$this->nombre->getDoctoresByName($_POST["nombre_doctor"]);
            if (count($datosDoctor)>0){
                $info=array('success'=>false, 'msg'=>"El Doctor ya existe.");
            } else {
                $records=$this->nombre->save($_POST);
                $info=array('success'=>true, 'msg'=>"Doctor guardado con exito.");
            }
        } else {
            $records=$this->nombre->update($_POST);
            $info=array('success'=>true, 'msg'=>"Doctor guardado con exito.");
        }
        echo json_encode($info);
    }
    public function getOneDoctor() {
        $records=$this->nombre->getOneDoctor($_GET["id"]);
        if (count ($records) > 0 ){
            $info=array('success'=>true, 'records'=>$records);
        } else {
            $info=array('success'=>false, 'msg'=>'El Doctor no existe');
        }
        echo json_encode($info);
    }
    public function deleteDoctor(){
        $records=$this->nombre->deleteDoctor($_GET["id"]);
        $info=array('success'=>true, 'msg'=>"Doctor eliminado con exito");
        echo json_encode($info);
    }
}
