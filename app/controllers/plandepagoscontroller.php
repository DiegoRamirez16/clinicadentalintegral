<?php
include_once "app/models/plandepagos.php";
class PlandepagosController extends Controller {
    private $plan; 
    public function __construct($parametro) {
        $this->plan=new Plandepagos();
        parent::__construct("plandepagos",$parametro,true);
    }
    public function getAll() {
        $records=$this->plan->getAll();
        $totalhoy=$this->plan->IngresosCuotasHoy();
        $info=array('success'=>true,'records'=>$records,'totalhoy'=>$totalhoy[0]["totalcuotashoy"]);
        echo json_encode($info);
    }

    public function getPlanesActivos() {
        $records=$this->plan->getPlanesActivos();
        $totalhoy=$this->plan->IngresosCuotasHoy();
        $info=array('success'=>true,'records'=>$records,'totalhoy'=>$totalhoy[0]["totalcuotashoy"]);
        echo json_encode($info);
    }
    public function getPlanesInactivos() {
        $records=$this->plan->getPlanesInactivos();
        $totalhoy=$this->plan->IngresosCuotasHoy();
        $info=array('success'=>true,'records'=>$records,'totalhoy'=>$totalhoy[0]["totalcuotashoy"]);
        echo json_encode($info);
    }
    public function update() {
        $records=$this->plan->update($_POST);
        $info=array('success'=>true, 'msg'=>"Expediente guardado con exito.");
        echo json_encode($info);
    }
    public function save() {
        if ($_POST["id_plancuota"]=="0") {
            $datosPlanpago=$this->plan->getPlanByName($_POST["id_plancuota"]);
            
            if (count($datosPlanpago)>0) {
                $info=array('success'=>false,'msg'=>"El paciente ya tiene un plan de pago existe");
            } else {
                $records=$this->plan->save($_POST);
                $this->plan->saveCuotas($records);
                $info=array('success'=>true,'msg'=>"Registro guardado con exito");
            }
        } else {
            $records=$this->plan->update($_POST);
            $info=array('success'=>true,'msg'=>"Registro guardado con exito");
        }
        echo json_encode($info);
    }
    public function saveCuotas() {
        $records=$this->plan->saveCuotas($_POST);
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }
    
    public function deletePago() {
        $records=$this->plan->deletePago($_GET["id"]);
        $info=array('success'=>true,'msg'=>"Plan de pago  eliminado con exito");
        echo json_encode($info);
    }
    public function getOnePlan() {
        $records=$this->plan->getOnePlan($_GET["id"]);
        if (count($records)>0) {
            $info=array('success'=>true,'records'=>$records);
        } else {
            $info=array('success'=>false,'msg'=>'El plan de pago no existe');
        }
        echo json_encode($info);
    }
}
