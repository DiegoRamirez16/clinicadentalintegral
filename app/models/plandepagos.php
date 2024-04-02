<?php
include_once "app/models/db.class.php";
class Plandepagos extends BaseDeDatos {

    public function __construct() {
        $this->conectar();
    }
    // Todos
    public function getAll() {
        return $this->executeQuery("select id_plancuota, nombre_paciente, monto, cantidad_cuotas, DATE_FORMAT(fecha_plancuota, '%d-%m-%Y') as fecha_plancuota, estado, nombre_tratamiento
        FROM tratamientos
        INNER JOIN plan_cuota USING(id_tratamiento)
        INNER JOIN pacientes USING(id_paciente)");
    }
    // Funcion para contar los ingresos al contado de hoy
    public function IngresosCuotasHoy() {
        return $this->executeQuery("select CONCAT('$', SUM(monto_cuota)) as totalcuotashoy FROM detalle_cuota where fecha_pago=CURRENT_DATE()");
    }
    // Planes Activos
    public function getPlanesActivos() {
        return $this->executeQuery("select id_plancuota,nombre_paciente,monto,cantidad_cuotas,date_format(fecha_plancuota,'%d-%m-%Y') as fecha_plancuota, estado, nombre_tratamiento 
        FROM tratamientos
        INNER JOIN plan_cuota USING(id_tratamiento)
        INNER JOIN pacientes USING(id_paciente) where estado='Activo'");
    }
    // Planes Inactivos
    public function getPlanesInactivos() {
        return $this->executeQuery("select id_plancuota,nombre_paciente,monto,cantidad_cuotas,date_format(fecha_plancuota,'%d-%m-%Y') as fecha_plancuota, estado, nombre_tratamiento
        FROM tratamientos
        INNER JOIN plan_cuota USING(id_tratamiento)
        INNER JOIN pacientes USING(id_paciente) where estado='Inactivo'");
    }

    public function save($data) {
        return $this->executeInsert("insert into plan_cuota set id_paciente='{$data["id_paciente"]}', monto='{$data["monto"]}',
        cantidad_cuotas='{$data["cantidad_cuotas"]}', fecha_plancuota='{$data["fecha_plancuota"]}', estado='{$data["estado"]}', id_tratamiento='{$data["id_tratamiento"]}'");
    }

    public function saveCuotas($id) {
            $idplancuota = $id;
            $cantidad = $_POST["cantidad_cuotas"];
            $monto = $_POST["monto"];
            // monto total a pagar divido en la cantidad de cuotas para sacar cuanto va a pagar al mes el paciente
            $montocuota = $monto/$cantidad;
            for ($i = 0; $i < $cantidad; $i++) {
                $valor = $i+1;
                                
                $this->executeInsert("insert into detalle_cuota (cuota,monto_cuota,id_plancuota,estado) 
                values ($valor,$montocuota,$idplancuota,'Pago pendiente')");
            }
    }
    
    public function getPlanByName($cantidad_cuotas){
        return $this->executeQuery("Select id_plancuota, id_paciente, monto, cantidad_cuotas, fecha_plancuota, estado, id_tratamiento 
        from plan_cuota where cantidad_cuotas='{$cantidad_cuotas}'");
    }
    public function getOnePlan($id) {
        return $this->executeQuery("Select id_plancuota,id_paciente,monto,cantidad_cuotas,fecha_plancuota,estado, id_tratamiento from plan_cuota where id_plancuota='{$id}'");
    }
    public function update($data) {
        return $this->executeInsert("update plan_cuota set id_paciente='{$data["id_pacientec"]}', monto='{$data["montoc"]}', 
        cantidad_cuotas='{$data["cantidad_cuotasc"]}', fecha_plancuota='{$data["fecha_plancuotac"]}', estado='{$data["estadoc"]}', id_tratamiento='{$data["id_tratamientoc"]}' where id_plancuota='{$data["id_plancuotac"]}'");
    }
    public function deletePago($id) {
        return $this->executeInsert("delete from plan_cuota where id_plancuota='$id'");
    }
    
}