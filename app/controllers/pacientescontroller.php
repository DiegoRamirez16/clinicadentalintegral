<?php
include_once "app/models/pacientes.php";
class PacientesController extends Controller {
    private $paciente;
    public function __construct($parametro) {
        $this->paciente=new Pacientes();
        parent::__construct("pacientes",$parametro,true);
    }

    public function getAll() {
        $records=$this->paciente->getAll();
        $total=$this->paciente->getTotalPacientes();
        $totalmas=$this->paciente->getTotalMasculino();
        $totalfem=$this->paciente->getTotalFemenino();
        $info=array('success'=>true,'records'=>$records,'totalmas'=>$totalmas[0]["TotalMas"],'totalfem'=>$totalfem[0]["TotalFem"]
        ,'total'=>$total[0]["TotalPacientes"]);
        echo json_encode($info);
    }
    public function getAllMasculino() {
        $records=$this->paciente->getAllMasculino();
        $total=$this->paciente->getTotalPacientes();
        $totalmas=$this->paciente->getTotalMasculino();
        $totalfem=$this->paciente->getTotalFemenino();
        $info=array('success'=>true,'records'=>$records,'totalmas'=>$totalmas[0]["TotalMas"],'totalfem'=>$totalfem[0]["TotalFem"]
        ,'total'=>$total[0]["TotalPacientes"]);
        echo json_encode($info);
    }
    public function getAllFemenino() {
        $records=$this->paciente->getAllFemenino();
        $total=$this->paciente->getTotalPacientes();
        $totalmas=$this->paciente->getTotalMasculino();
        $totalfem=$this->paciente->getTotalFemenino();
        $info=array('success'=>true,'records'=>$records,'totalmas'=>$totalmas[0]["TotalMas"],'totalfem'=>$totalfem[0]["TotalFem"]
        ,'total'=>$total[0]["TotalPacientes"]);
        echo json_encode($info);
    }
    public function getAllNoExp() {
        $records=$this->paciente->getAllNoExp();
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }
    public function getAllConExp() {
        $records=$this->paciente->getAllConExp();
        $info=array('success'=>true,'records'=>$records);
        echo json_encode($info);
    }
    public function save() {
        if ($_POST["id_paciente"]=="0") {
            $datosPaciente=$this->paciente->getPacienteByName($_POST["nombre_paciente"]);
            if (count($datosPaciente)>0) {
                $info=array('success'=>false,'msg'=>"El paciente ya existe");
            } else {
                $records=$this->paciente->save($_POST);
                $info=array('success'=>true,'msg'=>"Registro guardado con exito");
            }
        } else {
            $records=$this->paciente->update($_POST);
            $info=array('success'=>true,'msg'=>"Registro guardado con exito");
        }
        echo json_encode($info);
    }
    public function deletePaciente() {
        $records=$this->paciente->deletePaciente($_GET["id"]);
        $info=array('success'=>true,'msg'=>"Paciente eliminado con exito");
        echo json_encode($info);
    }
    public function getOnePaciente() {
        $records=$this->paciente->getOnePaciente($_GET["id"]);
        if (count($records)>0) {
            $info=array('success'=>true,'records'=>$records);
        } else {
            $info=array('success'=>false,'msg'=>'El Paciente no existe');
        }
        echo json_encode($info);
    }
    // Render pagina desde la clase de Perfiles de Controller de perfiles
    public function Perfiles() {
        $this->view->render("perfiles");
    }
}