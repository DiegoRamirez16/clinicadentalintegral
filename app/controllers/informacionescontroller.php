<?php
include_once "app/models/informaciones.php";
class InformacionesController extends Controller {
    private $informacion;
    public function __construct($parametro) {
        $this->informacion=new Informaciones();
        parent::__construct("informaciones",$parametro,true);
    }

}