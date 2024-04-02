<?php
include_once "app/models/controlesclinico.php";
class ControlesClinicoController extends Controller {
    private $controlclinico;
    public function __construct($parametro) {
        $this->controlclinico=new ControlesClinico();
        parent::__construct("controlesclinico",$parametro,true);
    }

    public function getAll() {
        $records=$this->controlclinico->getAll();
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }

    public function getAllId() {
        $records=$this->controlclinico->getAllId($_GET["id"]);
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }
    public function save() {
        //Proceso para guardar el archivo
        if ($_POST["id_controles"]=="0") {
            $datosControlClinico=$this->controlclinico->getControlClinicoByName($_POST["id_controles"]);
            if (count($datosControlClinico)>0) {
                $info=array('success'=>false,'msg'=>"El Control ya existe");
            } else {
                $records=$this->controlclinico->save($_POST);
                $info=array('success'=>true,'msg'=>"El Control ha sido guardado con exito");
            }
            } else {
                $records=$this->controlclinico->update($_POST);
                $info=array('success'=>true, 'msg'=>"Control guardado con exito.");
            }
            echo json_encode($info);
    }
    public function getNameById() {
        $records=$this->controlclinico->getNameById();
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }
    public function getNameExpe() {
        $records=$this->controlclinico->getNameExpe();
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }

    public function getOneControlClinico() {
        $records=$this->controlclinico->getOneControlClinico($_GET["id"]);
        if (count($records)>0) {
            $info=array('success'=>true,'records'=>$records);
        } else {
            $info=array('success'=>false,'msg'=>'El control no existe');
        }
        echo json_encode($info);
    }

    public function deleteControlClinico() {
        $records=$this->controlclinico->deleteControlClinico($_GET["id"]);
        $info=array('success'=>true,'msg'=>"El control ha sido eliminado con exito");
        echo json_encode($info);
    }

    // Render pagina desde la clase de Addcontroles de Controller de addcontroles
    public function Addcontroles() {
        $this->view->render("addcontroles");
    }
}