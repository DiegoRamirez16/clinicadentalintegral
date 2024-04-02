<?php
include_once "app/models/db.class.php";
class Cuotas extends BaseDeDatos {

    public function __construct() {
        $this->conectar();
    }

    public function getAll() {
        return $this->executeQuery("Select id_cuota, id_plancuota, cuota, monto_cuota, date_format(fecha_pago,'%d-%m-%Y') as fecha_pago,
        estado from detalle_cuota");
    }

    // Funcion para contar los ingresos al contado de hoy
    public function IngresosCuotasHoy() {
        return $this->executeQuery("select CONCAT('$', SUM(monto_cuota)) as monto_cuota FROM detalle_cuota where fecha_pago=CURRENT_DATE()");
    }

    // Todos los controles por el ID

    //Select id_cuota, id_plancuota, cuota, monto_cuota, fecha_pago, estado from detalle_cuota where id_plancuota=6;
    public function getAllId($id) {
        return $this->executeQuery("Select id_cuota, id_plancuota, cuota, monto_cuota, date_format(fecha_pago,'%d-%m-%Y') as fecha_pago,
        estado from detalle_cuota where id_plancuota='{$id}'");
    }

    public function getOnePlan($id) {
        return $this->executeQuery("select a.id_cuota,date_format(a.fecha_pago,'%d-%m-%Y') as fecha_pago,a.cuota,a.monto_cuota,b.id_plancuota,a.estado,b.id_paciente from plan_cuota b 
        INNER JOIN detalle_cuota a USING(id_plancuota) where id_plancuota='{$id}'");
    }

    public function save($data) {
        return $this->executeInsert("insert into detalle_cuota set id_plancuota='{$data["id_plancuota"]}', cuota='{$data["cuota"]}', 
        monto_cuota='{$data["monto_cuota"]}', estado='{$data["estado"]}'");
    }

    public function getCuotaByName($estado) {
        return $this->executeQuery("Select id_cuota, id_plancuota, cuota, monto_cuota, fecha_pago,
        estado from detalle_cuota where estado='{$estado}'");
    }

    public function getOneCuota($id) {
        return $this->executeQuery("Select id_cuota, id_plancuota, cuota, monto_cuota, fecha_pago,
        estado from detalle_cuota where id_cuota='{$id}'");
    }
    public function update($data) {
        return $this->executeInsert("update detalle_cuota set 
        id_plancuota='{$data["id_plancuota"]}', cuota='{$data["cuota"]}', 
        monto_cuota='{$data["monto_cuota"]}',fecha_pago='{$data["fecha_pago"]}', estado='{$data["estado"]}' 
        where id_cuota={$data["id_cuota"]}");
    }

    public function deleteCuota($id) {
        return $this->executeInsert("delete from detalle_cuota where id_cuota='$id'");
    }

    public function getCuotaReporte($data){
        $condicion="";
        if ($data["iddetalleplanpago"]!="0"){
            $condicion.=" and a.id_cuota='{$data["iddetalleplanpago"]}'";
        }
        if ($data["idplanpago"]!="0"){
            $condicion.=" and b.id_plancuota='{$data["idplanpago"]}'";
        }

        return $this->executeQuery("select a.id_cuota,a.fecha_pago,a.cuota,a.monto_cuota,b.id_plancuota,a.estado,b.id_paciente,c.nombre_paciente from plan_cuota b INNER JOIN detalle_cuota a USING(id_plancuota) INNER JOIN pacientes c USING (id_paciente)  where 1=1 $condicion and a.estado='Pagado'");
    
    }

}