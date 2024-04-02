<?php
include_once "app/models/cuotas.php";
class CuotasController extends Controller {
    private $cuota;
    public function __construct($parametro) {
        $this->cuota=new Cuotas();
        parent::__construct("cuotas",$parametro,true);
    }

    public function getAll() {
        $records=$this->cuota->getAll();
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }

    public function getOnePlan() {
        $records=$this->cuota->getOnePlan($_GET["id"]);
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }

    public function save() {
        //Proceso para guardar el archivo
        if ($_POST["id_cuota"]=="0") {
            $datosCuota=$this->cuota->getCuotaByName($_POST["id_cuota"]);
            if (count($datosCuota)>0) {
                $info=array('success'=>false,'msg'=>"La cuota ya existe");
            } else {
                $records=$this->cuota->save($_POST);
                $info=array('success'=>true,'msg'=>"Cuota guardada con exito");
            }
            } else {
                $records=$this->cuota->update($_POST);
                $info=array('success'=>true, 'msg'=>"Cuota guardado con exito.");
            }
            echo json_encode($info);
        }

    public function getOneCuota() {
        $records=$this->cuota->getOneCuota($_GET["id"]);
        if (count($records)>0) {
            $info=array('success'=>true,'records'=>$records);
        } else {
            $info=array('success'=>false,'msg'=>'La cuota no existe');
        }
        echo json_encode($info);
    }

    public function deleteCuota() {
        $records=$this->cuota->deleteCuota($_GET["id"]);
        $info=array('success'=>true,'msg'=>"Cuota eliminada con exito");
        echo json_encode($info);
    }
}