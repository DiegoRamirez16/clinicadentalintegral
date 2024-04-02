<?php
include_once "app/models/expedientes.php";
class ExpedientesController extends Controller {
    private $expediente;
    public function __construct($parametro) {
        $this->expediente=new Expedientes();
        parent::__construct("expedientes",$parametro,true);
    }
    public function getAll() {
        $records=$this->expediente->getAll();
        $info=array('success'=>true, 'records'=>$records);
        echo json_encode($info);
    }
    public function getNameExpe() {
        $name=$this->expediente->getNameExpe();
        $info=array('success'=>true, 'name'=>$name[0]["Nombre"]);
        echo json_encode($info);
    }
    public function update() {
        $records=$this->expediente->update($_POST);
        $info=array('success'=>true, 'msg'=>"Expediente guardado con exito.");
        echo json_encode($info);
    }

    public function save() {
        if ($_POST["id_expediente"]==0)  {
            $datosExpediente=$this->expediente->getExpedienteById($_POST["id_expediente"]);
            if (count($datosExpediente)>0){
                $info=array('success'=>false, 'msg'=>"El Expediente ya existe.");
            } else {
                $records=$this->expediente->save($_POST);
                $info=array('success'=>true, 'msg'=>"Expediente guardado con exito.");
            }
        } else {
            $records=$this->expediente->update($_POST);
            $info=array('success'=>true, 'msg'=>"Expediente guardado con exito.");
        }
        echo json_encode($info);
    }
    
    public function getOneExpediente() {
        $records=$this->expediente->getOneExpediente($_GET["id"]);
        if (count ($records) > 0 ){
            $info=array('success'=>true, 'records'=>$records);
        } else {
            $info=array('success'=>false, 'msg'=>'El Expediente no existe');
        }
        echo json_encode($info);
    }
    public function deleteExpediente(){
        $records=$this->expediente->deleteExpediente($_GET["id"]);
        $info=array('success'=>true, 'msg'=>"Expediente eliminado con exito");
        echo json_encode($info);
    }
}

