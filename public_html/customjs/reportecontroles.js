//Variables y selectores
const btnViewReport=document.querySelector("#btnViewReport");
const idControles=document.querySelector("#id_controles");
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
function cargarExpediente() {
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
                        const {id_expediente,nombre_paciente}=item;
                        const optionExpediente=document.createElement("option");
                        optionExpediente.value=id_expediente;
                        optionExpediente.textContent=nombre_paciente;
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
function cargarDatos(){
    API.get("controlesclinico/getAll").then(
        data=>{
            if(data.success) {
                idControles.innerHTML="";
                const optionControles=document.createElement("option");
                optionControles.value="0";
                optionControles.textContent="Todos";
                idControles.append(optionControles);
                data.records.forEach(
                    (item,index)=>{
                        const {id_controles}=item;
                        const optionControles=document.createElement("option");
                        optionControles.value=id_controles;
                        optionControles.textContent=id_controles;
                        idControles.append(optionControles);
                    }
                );
            }
            cargarExpediente();
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
    frameReporte.src=`${BASE_API}reportecontroles/getReporte?idcontroles=${idControles.value}&idexpediente=${idExpediente.value}`;
}
