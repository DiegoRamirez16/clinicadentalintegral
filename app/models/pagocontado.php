<?php
include_once "app/models/db.class.php";
class PagoContado extends BaseDeDatos {

    public function __construct() {
        $this->conectar();
    }

    public function getAll() {
        return $this->executeQuery("Select id_pagocontado, monto_contado, date_format(fecha_pago,'%d-%m-%Y') as fecha_pago, nombre_paciente, apellido_paciente,nombre_tratamiento 
        from tratamientos INNER JOIN (pago_contado inner join pacientes using(id_paciente)) USING (id_tratamiento) order by fecha_pago asc");
    }
    public function getSemana() {
        return $this->executeQuery("Select id_pagocontado, monto_contado, date_format(fecha_pago,'%d-%m-%Y') as fecha_pago, nombre_paciente, apellido_paciente,nombre_tratamiento 
        from tratamientos INNER JOIN (pago_contado inner join pacientes using(id_paciente)) USING (id_tratamiento) WHERE WEEK(fecha_pago) = WEEK(CURDATE()) - 1");
    }
    public function getContadoHoy() {
        return $this->executeQuery("Select id_pagocontado, monto_contado, date_format(fecha_pago,'%d-%m-%Y') as fecha_pago, nombre_paciente, apellido_paciente,nombre_tratamiento 
        from tratamientos INNER JOIN (pago_contado inner join pacientes using(id_paciente)) USING (id_tratamiento) where fecha_pago=CURRENT_DATE()");
    }
    public function getAllOrderByName() {
        return $this->executeQuery("Select id_pagocontado, monto_contado, date_format(fecha_pago,'%d-%m-%Y') as fecha_pago, id_paciente
        from pago_contado order by id_pagocontado");
    }
    // Funcion para contar los ingresos de la semana pasada
    public function IngresosSemanaPasadaContado() {
        return $this->executeQuery("select CONCAT('$', SUM(monto_contado)) as monto_contado FROM pago_contado WHERE WEEK(fecha_pago) = WEEK(CURDATE()) - 1");
    }
    // Funcion para contar los ingresos al contado de hoy
    public function IngresosContadoHoy() {
        return $this->executeQuery("select CONCAT('$', SUM(monto_contado)) as monto_contado FROM pago_contado where fecha_pago=CURRENT_DATE()");
    }

    public function save($data) {
        $this->executeInsert("insert into logs set id_usr='{$_SESSION["id_usr"]}', descripcion='Se inserto un pago para el paciente con id {$data["id_paciente"]}',fecha=now()");

        return $this->executeInsert("insert into pago_contado set monto_contado='{$data["monto_contado"]}', 
        fecha_pago='{$data["fecha_pago"]}',id_paciente='{$data["id_paciente"]}',id_tratamiento='{$data["id_tratamiento"]}'");
    }

    public function getPagocontadoByName($fecha_pago) {
        return $this->executeQuery("Select id_pagocontado, monto_contado, fecha_pago, id_paciente,id_tratamiento
        from pago_contado where id_pagocontado='{$fecha_pago}'");
    }

    public function getOnePagocontado($id) {
        return $this->executeQuery("Select id_pagocontado, monto_contado, fecha_pago, id_paciente,id_tratamiento 
        from pago_contado where id_pagocontado='{$id}'");
    }
    public function update($data) {
        return $this->executeInsert("update pago_contado set 
        monto_contado='{$data["monto_contado"]}', 
        fecha_pago='{$data["fecha_pago"]}', 
        id_paciente='{$data["id_paciente"]}',
        id_tratamiento='{$data["id_tratamiento"]}'
        where id_pagocontado={$data["id_pagocontado"]}");      
    }
    public function deletePagocontado($id) {
        return $this->executeInsert("delete from pago_contado where id_pagocontado='$id'");
    }
}