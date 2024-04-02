<?php
include_once "app/models/ingresos.php";
class IngresosController extends Controller {
    private $monto; 
    public function __construct($parametro) {
        $this->monto=new Ingresos();
        parent::__construct("ingresos",$parametro,true);
    }
    public function getAll() {
        $records=$this->monto->getAll();
        $info=array('success'=>true, 'records'=>$records);
        echo json_encode($info);
    }
    public function save() {
        if ($_POST["id_ingreso"]==0) {
            $datosIngreso=$this->monto->getIngresoByName($_POST["id_ingreso"]);
            if (count($datosIngreso)>0){
                $info=array('success'=>false, 'msg'=>"El Ingreso ya existe.");
            } else {
                $records=$this->monto->save($_POST);
                $info=array('success'=>true, 'msg'=>"Ingreso guardado con exito.");
            }
        } else {
            $records=$this->monto->update($_POST);
            $info=array('success'=>true, 'msg'=>"Ingreso guardado con exito.");
        }
        echo json_encode($info);
    }
    public function getOneIngreso() {
        $records=$this->monto->getOneIngreso($_GET["id"]);
        if (count ($records) > 0 ){
            $info=array('success'=>true, 'records'=>$records);
        } else {
            $info=array('success'=>false, 'msg'=>'El Ingreso no existe');
        }
        echo json_encode($info);
    }
    public function deleteIngreso(){
        $records=$this->monto->deleteIngreso($_GET["id"]);
        $info=array('success'=>true, 'msg'=>"Ingreso eliminado con exito");
        echo json_encode($info);
    }
}

