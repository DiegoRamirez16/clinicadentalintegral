//Variables y selectores
const btnViewReport=document.querySelector("#btnViewReport");
const idDetalle=document.querySelector("#id_detalleplanpago");
const idPlan=document.querySelector("#id_planpago");
const idPaciente=document.querySelector("#id_paciente");
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
    API.get("cuotas/getAll").then(
        data=>{
            if(data.success) {
                idDetalle.innerHTML="";
                const optionDetalle=document.createElement("option");
                optionDetalle.value="0";
                optionDetalle.textContent="Todos";
                idDetalle.append(optionDetalle);
                data.records.forEach(
                    (item,index)=>{
                        const {id_cuota}=item;
                        const optionDetalle=document.createElement("option");
                        optionDetalle.value=id_cuota;
                        optionDetalle.textContent=id_cuota;
                        idDetalle.append(optionDetalle);
                    }
                );
            }
            cargarPlandePago();
            
        }
    ).catch(
        error=>{
            console.error("Error:",error);
        }
    );


}
function cargarPlandePago() {
    API.get("plandepagos/getAll").then(
        data=>{
            if(data.success) {
                idPlan.innerHTML="";
                const optionPlan=document.createElement("option");
                optionPlan.value="0";
                optionPlan.textContent="Todos";
                idPlan.append(optionPlan);
                data.records.forEach(
                    (item,index)=>{
                        const {id_plancuota,nombre_paciente}=item;
                        const optionPlan=document.createElement("option");
                        optionPlan.value=id_plancuota;
                        optionPlan.textContent=nombre_paciente
                        idPlan.append(optionPlan);
                    }
                );
            }cargarPacientes()
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
    frameReporte.src=`${BASE_API}reportecuotas/getReporte?iddetalleplanpago=${idDetalle.value}&idplanpago=${idPlan.value}`;
}
