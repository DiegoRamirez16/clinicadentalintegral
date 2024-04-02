//Variables y selectores
const btnViewReport=document.querySelector("#btnViewReport");
const idPaciente=document.querySelector("#id_paciente");
const idCita=document.querySelector("#id_cita");
const frameReporte=document.querySelector("#framereporte");
const API=new Api();

//Eventos

eventListener();

function eventListener(){
    document.addEventListener("DOMContentLoaded", cargarDatos);
    btnViewReport.addEventListener("click", verReporte);

}

//Funciones
function cargarDatos() {
    API.get("citas/getAll").then(
        data=>{
            if(data.success) {
                idCita.innerHTML="";
                const optionCita=document.createElement("option");
                optionCita.value="0";
                optionCita.textContent="Todos";
                idCita.append(optionCita);
                data.records.forEach(
                    (item,index)=>{
                        const {id_cita,fecha_cita}=item;
                        const optionCita=document.createElement("option");
                        optionCita.value=id_cita;
                        optionCita.textContent=fecha_cita;
                        idCita.append(optionCita);
                    }
                );
            }
            cargarPacientes();
        }
    ).catch(
        error=>{
            console.error("Error:",error);
        }
    );
}
function cargarPacientes(){
    API.get("pacientes/getAll").then(
        data=>{
            if(data.success) {
                idPaciente.innerHTML="";
                const optionPaciente=document.createElement("option");
                optionPaciente.value="0";
                optionPaciente.textContent="Todos";
                idPaciente.append(optionPaciente);
                data.records.forEach(
                    (item,index)=>{
                        const {id_paciente,nombre_paciente}=item;
                        const optionPaciente=document.createElement("option");
                        optionPaciente.value=id_paciente;
                        optionPaciente.textContent=nombre_paciente;
                        idPaciente.append(optionPaciente);
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

function verReporte(){
    frameReporte.src=`${BASE_API}reportecitas/getReporte?idcita=${idCita.value}&idpaciente=${idPaciente.value}`;
}
