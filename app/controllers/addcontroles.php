<?php
include_once "app/models/addcontroles.php";
class AddcontrolesController extends Controller {
    private $addcontrol;
    public function __construct($parametro) {
        $this->addcontrol=new Addcontroles();
        parent::__construct("addcontroles",$parametro,true);
    }

    public function getAll() {
        $records=$this->addcontrol->getAll();
        $info=array('success'=>true, 'records'=>$records);
        echo json_encode($info);
    }

    public function save() {
        //Proceso para guardar el archivo
        $datosAddcontrol=$this->addcontrol->getControlClinicoByName($_POST["id_controles"]);
        $records=$this->addcontrol->save($_POST);
        $info=array('success'=>true,'msg'=>"El Control ha sido guardado con exito");
        echo json_encode($info);
    }

}