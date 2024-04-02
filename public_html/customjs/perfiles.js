//Variables globales y selectores

const panelForm=document.querySelector("#contentForm");
const API=new Api();

//Configuracion de eventos
eventListiners();

function eventListiners() {

    document.addEventListener("DOMContentLoaded", cargarDatos);

}

function cargarDatos() {
  API.get("perfiles/getAll?id="+idperfil).then(
        data=>{
            //console.log(data.records);
            if (data.success) {
                //objDatos.records=data.records;
                //objDatos.currentPage=1;
                document.getElementById("nombrepaciente").innerHTML = data.name;
                document.getElementById("telefono").innerHTML = data.records[0].telefono_paciente;
                document.getElementById("sexo").innerHTML = data.records[0].sexo_paciente;
                document.getElementById("alergia").innerHTML = data.records[0].alergia_paciente;
                document.getElementById("observacion").innerHTML = data.records[0].observacion_paciente;
                document.getElementById("padecimiento").innerHTML = data.records[0].padecimiento_paciente;
                //document.getElementById("direccion").innerHTML = data.records[0].padecimiento_paciente;
                document.getElementById("idpaciente").innerHTML = data.records[0].id_paciente;
                document.getElementById("fechanacimiento").innerHTML = data.records[0].fecha_nacimiento;
                //crearTabla();
                //cargarPacientes();
            } else {
                console.log("Error al recuperar los registros");
            }
        }
    ).catch(
        error=>{
            console.error("Error en la llamada:",error);
        }
    );
}

function cargarPacientes() {
    API.get("pacientes/getAll").then(
        data=>{
            if(data.success) {
                const txtPaciente=document.querySelector("#id_paciente");
                txtPaciente.innerHTML="";
                data.records.forEach(
                    (item,index)=>{
                        const {id_paciente,nombre_paciente}=item;
                        const optionPaciente=document.createElement("option");
                        optionPaciente.value=id_paciente;
                        optionPaciente.textContent=nombre_paciente;  
                        txtPaciente.append(optionPaciente);
                    }
                );
            }
        }
    ).catch(
        error=>{
            console.error("Error:",error);
        }
    );
}
