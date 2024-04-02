<?php
include_once "app/models/perfiles.php";
class PerfilesController extends Controller {
    private $perfil;
    public function __construct($parametro) {
        $this->perfil=new Perfiles();
        parent::__construct("perfiles",$parametro,true);
    }

    public function getAll() {
        $records=$this->perfil->getAll($_GET["id"]);
        $name=$this->perfil->getNamePac($_GET["id"]);
        $info=array('success'=>true, 'records'=>$records,'name'=>$name[0]["nombre"]);
        echo json_encode($info);
    }

    public function saveRadiografia() {
        $imgg="";
        //Proceso para guardar el archivo
        if (isset($_FILES)) {
            //IMAGEN GRANDE
            if (is_uploaded_file($_FILES["fotog"]["tmp_name"])) {
                if (($_FILES["fotog"]["type"]=="image/png") ||
                    ($_FILES["fotog"]["type"]=="image/jpeg")) {
                        copy($_FILES["fotog"]["tmp_name"],
                        __DIR__."/../../public_html/fotos/".$_FILES["fotog"]["name"])
                        or die("No se pudo copiar el archivo");
                        $imgg=URL."public_html/fotos/".$_FILES["fotog"]["name"];
                     
                    }
            }
        }
        $records=$this->perfil->saveRadiografia($imgg);
        $info=array('success'=>true,'msg'=>"Registro guardado con exito");
        echo json_encode($info);
    }

    public function getOnePaciente() {
        $records=$this->perfil->getOnePaciente($_GET["id"]);
        if (count($records)>0) {
            $info=array('success'=>true,'records'=>$records);
        } else {
            $info=array('success'=>false,'msg'=>'El Paciente no existe');
        }
        echo json_encode($info);
    }

}