//Variables y selectores
const btnViewReport=document.querySelector("#btnViewReport");
const idPaciente=document.querySelector("#id_paciente");
const idContado=document.querySelector("#id_pagocontado");
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
    API.get("pagocontado/getAll").then(
        data=>{
            if(data.success) {
                idContado.innerHTML="";
                const optionContado=document.createElement("option");
                optionContado.value="0";
                optionContado.textContent="Todos";
                idContado.append(optionContado);
                data.records.forEach(
                    (item,index)=>{
                        const {id_pagocontado,fecha_pago}=item;
                        const optionContado=document.createElement("option");
                        optionContado.value=id_pagocontado;
                        optionContado.textContent=fecha_pago;
                        idContado.append(optionContado);
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
    frameReporte.src=`${BASE_API}reporteingresos/getReporte?idpagocontado=${idContado.value}&idpaciente=${idPaciente.value}`;
}
