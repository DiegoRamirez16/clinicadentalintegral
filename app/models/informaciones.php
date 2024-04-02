<?php
include_once "app/models/db.class.php";
class Informaciones extends BaseDeDatos {
    public function __construct() {
        $this->conectar();
    }

}