//Variables y selectores
const btnViewReport=document.querySelector("#btnViewReport");
const idPaciente=document.querySelector("#id_paciente");
const idExpediente=document.querySelector("#id_expediente");
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
    API.get("expedientes/getAll").then(
        data=>{
            if(data.success) {
                idExpediente.innerHTML="";
                const optionExpediente=document.createElement("option");
                optionExpediente.value="0";
                optionExpediente.textContent="Todos";
                idExpediente.append(optionExpediente);
                data.records.forEach(
                    (item,index)=>{
                        const {id_expediente}=item;
                        const optionExpediente=document.createElement("option");
                        optionExpediente.value=id_expediente;
                        optionExpediente.textContent=id_expediente;
                        idExpediente.append(optionExpediente);
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
    API.get("pacientes/getAllConExp").then(
        data=>{
            if(data.success) {
                idPaciente.innerHTML="";
                const optionPaciente=document.createElement("option");
                //optionPaciente.value="0";
                optionPaciente.textContent="Seleccione un paciente";
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
    frameReporte.src=`${BASE_API}reporteexpedientes/getReporte?idpaciente=${idPaciente.value}&idexpediente=${idExpediente.value}`;
}
