<?php
include_once "app/models/pagocontado.php";
class PagoContadoController extends Controller {
    private $pagocontad;
    public function __construct($parametro) {
        $this->pagocontad=new pagocontado();
        parent::__construct("pagocontado",$parametro,true);
    }

    public function getAll() {
        $records=$this->pagocontad->getAll();
        $total=$this->pagocontad->IngresosSemanaPasadaContado();
        $totalhoy=$this->pagocontad->IngresosContadoHoy();
        $info=array('success'=>true,'records'=>$records,'total'=>$total[0]["monto_contado"],'totalhoy'=>$totalhoy[0]["monto_contado"]);
        echo json_encode($info);
    }

    public function getSemana() {
        $records=$this->pagocontad->getSemana();
        $total=$this->pagocontad->IngresosSemanaPasadaContado();
        $totalhoy=$this->pagocontad->IngresosContadoHoy();
        $info=array('success'=>true,'records'=>$records,'total'=>$total[0]["monto_contado"],'totalhoy'=>$totalhoy[0]["monto_contado"]);
        echo json_encode($info);
    }

    public function getContadoHoy() {
        $records=$this->pagocontad->getContadoHoy();
        $total=$this->pagocontad->IngresosSemanaPasadaContado();
        $totalhoy=$this->pagocontad->IngresosContadoHoy();
        $info=array('success'=>true,'records'=>$records,'total'=>$total[0]["monto_contado"],'totalhoy'=>$totalhoy[0]["monto_contado"]);
        echo json_encode($info);
    }

    public function saveCuotas() {
        $records=$this->pagocontad->saveCuotas($_POST);
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }
    public function save() {
        //Proceso para guardar el archivo
        if ($_POST["id_pagocontado"]=="0") {
            $datosPagoContado=$this->pagocontad->getPagocontadoByName($_POST["id_pagocontado"]);
            if (count($datosPagoContado)>0) {
                $info=array('success'=>false,'msg'=>"Pago ya existente");
            } else {
                $records=$this->pagocontad->save($_POST);
                $info=array('success'=>true,'msg'=>"Pago guardado con exito");
            }
            } else {
                $records=$this->pagocontad->update($_POST);
                $info=array('success'=>true,'msg'=>"Pago guardado con exito");
            }
            echo json_encode($info);
        }

    public function getOnePagocontado() {
        $records=$this->pagocontad->getOnePagocontado($_GET["id"]);
        if (count($records)>0) {
            $info=array('success'=>true,'records'=>$records);
        } else {
            $info=array('success'=>false,'msg'=>'Pago no existe');
        }
        echo json_encode($info);
    }

    public function deletePagocontado() {
        $records=$this->pagocontad->deletePagocontado($_GET["id"]);
        $info=array('success'=>true,'msg'=>"Pago eliminado con exito");
        echo json_encode($info);
    }
}