<?php
include_once "app/models/citas.php";
class CitasController extends Controller {
    private $cita;
    public function __construct($parametro) {
        $this->cita=new Citas();
        parent::__construct("citas",$parametro,true);
    }

    public function getAll() {
        $records=$this->cita->getAll();
        $total=$this->cita->getCounthoy();
        $totalma=$this->cita->getCountma();
        $info=array('success'=>true,'records'=>$records,'total'=>$total[0]["CitasDeHoy"],'totalma'=>$totalma[0]["CitasDeMa"]);
        echo json_encode($info);
    }

    public function getCitasSemanaPendientes() {
        $records=$this->cita->getCitasSemanaPendientes();
        $total=$this->cita->getCounthoy();
        $totalma=$this->cita->getCountma();
        $info=array('success'=>true,'records'=>$records,'total'=>$total[0]["CitasDeHoy"],'totalma'=>$totalma[0]["CitasDeMa"]);
        echo json_encode($info);
    }

    public function getAllhoy() {
        $records=$this->cita->getAllhoy();
        $total=$this->cita->getCounthoy();
        $totalma=$this->cita->getCountma();
        $info=array('success'=>true,'records'=>$records,'total'=>$total[0]["CitasDeHoy"],'totalma'=>$totalma[0]["CitasDeMa"]);
        echo json_encode($info);
    }

    public function getCitasMA() {
        $records=$this->cita->getCitasMA();
        $total=$this->cita->getCounthoy();
        $totalma=$this->cita->getCountma();
        $info=array('success'=>true,'records'=>$records,'totalma'=>$totalma[0]["CitasDeMa"],'total'=>$total[0]["CitasDeHoy"]);
        echo json_encode($info);
    }

    public function getFechas() {
        $records=$this->cita->getFechas();
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }

    public function save() {
        //Proceso para guardar el archivo
        // Si el id_cita trae el valor de 0 es porque es un nuevo registro si es diferente de 0 es un update
        if ($_POST["id_cita"]=="0") {
            $datosCita=$this->cita->getCitaById($_POST["id_cita"]);
            if (count($datosCita)>0) {
                $info=array('success'=>false,'msg'=>"La cita ya existe");
            } else {
                $records=$this->cita->save($_POST);
                $info=array('success'=>true,'msg'=>"Cita guardada con exito");
            }
        } else {
                $records=$this->cita->update($_POST);
                $info=array('success'=>true, 'msg'=>"Cita guardado con exito.");
        }
        echo json_encode($info);
    }

    public function getOneCita() {
        $records=$this->cita->getOneCita($_GET["id"]);
        if (count($records)>0) {
            $info=array('success'=>true,'records'=>$records);
        } else {
            $info=array('success'=>false,'msg'=>'La cita no existe');
        }
        echo json_encode($info);
    }

    public function deleteCita() {
        $records=$this->cita->deleteCita($_GET["id"]);
        $info=array('success'=>true,'msg'=>"Cita eliminada con exito");
        echo json_encode($info);
    }
}