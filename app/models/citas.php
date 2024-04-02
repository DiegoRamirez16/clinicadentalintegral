<?php
include_once "app/models/db.class.php";
class Citas extends BaseDeDatos {

    public function __construct() {
        $this->conectar();
    }
    
    // Funcion para obtener todos los datos a la tabla
    public function getAll() {
        return $this->executeQuery("select id_cita,nombre_paciente,apellido_paciente,descripcion_cita,date_format(fecha_cita,'%d-%m-%Y') as fecha_cita,hora_cita,nombre_doctor, estado from doctores 
        INNER join(citas inner join pacientes USING(id_paciente)) USING(id_doctor) order by id_cita asc");
    }

    // Funcion para obtener la citas de hoy
    public function getAllhoy() {
        return $this->executeQuery("select id_cita,nombre_paciente,apellido_paciente,descripcion_cita,date_format(fecha_cita,'%d-%m-%Y') as fecha_cita,hora_cita,nombre_doctor,estado from doctores 
        INNER join(citas inner join pacientes USING(id_paciente)) USING(id_doctor) where fecha_cita=CURRENT_DATE() order by id_cita asc");
    }
    // Funcion para contar las citas
    public function getCounthoy() {
        return $this->executeQuery("select COUNT(*) as CitasDeHoy FROM citas where fecha_cita=CURDATE()");
    }
    // Funcion para contar las citas manana
    public function getCountma() {
        return $this->executeQuery("select COUNT(*) as CitasDeMa FROM citas where fecha_cita = curdate() + interval 1 day");
    }
    // Obtener citas para el dia de mañana
    public function getCitasMA() {
        return $this->executeQuery("select id_cita,nombre_paciente,apellido_paciente,descripcion_cita,date_format(fecha_cita,'%d-%m-%Y') as fecha_cita,hora_cita,nombre_doctor,estado from doctores 
        INNER join(citas inner join pacientes USING(id_paciente)) USING(id_doctor) where fecha_cita = curdate() + interval 1 day order by date_format(fecha_cita,'%d-%m-%Y') ASC");
    }
    // Citas pendientes de la semana
    public function getCitasSemanaPendientes() {
        return $this->executeQuery("select id_cita,nombre_paciente,apellido_paciente,descripcion_cita,date_format(fecha_cita,'%d-%m-%Y') as fecha_cita,hora_cita,nombre_doctor, estado from doctores 
        INNER join(citas inner join pacientes USING(id_paciente)) USING(id_doctor) WHERE WEEK(fecha_cita) = WEEK(CURDATE()) AND estado='Pendiente' order by fecha_cita ASC");
    }

    public function getFechas() {
        return $this->executeQuery("select distinct date_format(fecha_cita,'%d-%m-%Y') as fecha_cita from doctores 
        INNER join(citas inner join pacientes USING(id_paciente)) USING(id_doctor)");
    }

    // Funcion para ordenar las citas por el ID
    //public function getAllOrderByName() {
      //  return $this->executeQuery("Select id_cita, id_paciente, descripcion_cita, fecha_cita, hora_cita,
        //id_doctor from citas order by id_cita");
    //}

    // Funcion para guardar registro
    public function save($data) {
        $this->executeInsert("insert into logs set id_usr='{$_SESSION["id_usr"]}', descripcion='Se inserto una cita para el paciente con id {$data["id_paciente"]}',fecha=now()");

        return $this->executeInsert("insert into citas set id_paciente='{$data["id_paciente"]}', descripcion_cita='{$data["descripcion_cita"]}', 
        fecha_cita='{$data["fecha_cita"]}', hora_cita='{$data["hora_cita"]}', id_doctor='{$data["id_doctor"]}', estado='{$data["estado"]}'");
        
    }

    // Funcion para obtener el id
    public function getCitaById($id_cita) {
        return $this->executeQuery("Select id_cita, id_paciente, descripcion_cita, fecha_cita, hora_cita, id_doctor, estado
        from citas where descripcion_cita='{$id_cita}'");
    }

    //
    public function getOneCita($id) {
        return $this->executeQuery("Select id_cita, id_paciente, descripcion_cita, fecha_cita, hora_cita, id_doctor, estado
        from citas where id_cita='{$id}'");
    }

    // Funcion para actualizar SQL
    public function update($data) {
        return $this->executeInsert("update citas set id_paciente='{$data["id_paciente"]}', 
        descripcion_cita='{$data["descripcion_cita"]}', 
        fecha_cita='{$data["fecha_cita"]}', hora_cita='{$data["hora_cita"]}', id_doctor='{$data["id_doctor"]}', estado='{$data["estado"]}' where id_cita={$data["id_cita"]}");
    }

    // Funcion Borrar SQL
    public function deleteCita($id) {
        return $this->executeInsert("delete from citas where id_cita='$id'");
    }

    // Funcion Reportes
    public function getCitaReporte($data){
        $condicion="";
        if ($data["idpaciente"]!="0"){
            $condicion.=" and b.id_paciente='{$data["idpaciente"]}'";
        }
        if ($data["idfecha"]!="0"){
            $condicion.=" and a.fecha_cita=str_to_date('{$data["idfecha"]}','%d-%m-%Y')";
        }
        return $this->executeQuery("Select a.*, b.nombre_paciente,b.apellido_paciente, date_format(a.fecha_cita, '%d-%m-%Y') as fecha_ci from pacientes b inner join 
        citas a using(id_paciente) where 1=1 $condicion");
    }
}