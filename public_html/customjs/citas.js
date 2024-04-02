//Variables globales y selectores
const btnNew=document.querySelector("#btnAgregar");
// Contenido del Nombre del Listado, Boton Agregar y Cuadro de busqueda
const panelDatos=document.querySelector("#contentList");
// Contenido de listado tablas
const panelDatos2=document.querySelector("#contentList2");
// Contenido de opciones de filtrar tabla
const panelFiltros=document.querySelector("#contentListOP");
// Formulario
const panelForm=document.querySelector("#contentForm");
const btnCancelar=document.querySelector("#btnCancelar");
const tableContent=document.querySelector("#contentTable table tbody");
const searchText=document.querySelector("#txtSearch");
const pagination=document.querySelector(".pagination");
const formCita=document.querySelector("#formCita");
const API=new Api();
const objDatos={
    records:[],
    recordsFilter:[],
    currentPage:1,
    recordsShow:6,
    filter:""
}

//Configuracion de eventos
eventListiners();

function eventListiners() {
    btnNew.addEventListener("click",agregarCita);
    btnCancelar.addEventListener("click",cancelarCita);
    //console.log("Antes de cargar");
    document.addEventListener("DOMContentLoaded",cargarDatos);
    //console.log("Despues de cargar");
    searchText.addEventListener("input", aplicarFiltro);
    formCita.addEventListener("submit",guardarCita);
}

//Funciones
function guardarCita(event) {
    event.preventDefault();
    const formData=new FormData(formCita);
    //console.log(formData);
    API.post(formData,"citas/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success) {
                cancelarCita();
                Swal.fire({
                    icon:"info",
                    text:data.msg
                });
            } else {
                Swal.fire({
                    icon:"error",
                    title:"Error",
                    text:data.msg
                });
            }
        }
    ).catch(
        error=> {
            console.log("Error:",error);
        }
    );
}

function aplicarFiltro(element) {
    element.preventDefault();
    objDatos.filter=this.value;
    crearTabla();
}
let api = "citas/getCitasSemanaPendientes";

function cambiarApi(nuevaApi) {
    api = nuevaApi;
    cargarDatos();
    
}
function cargarDatos() {
    //console.log("Cargando datos");
    API.get(api).then(
        data=>{
            //console.log(data.records);
            if (data.success) {
                objDatos.records=data.records;
                objDatos.currentPage=1;
                document.getElementById("totalcitas").innerHTML=data.total;
                document.getElementById("totalcitasma").innerHTML=data.totalma;
                crearTabla();
                cargarPacientes();
                cargarDoctores();
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
                        const {id_paciente,nombre_paciente,apellido_paciente}=item;
                        const optionPaciente=document.createElement("option");
                        optionPaciente.value=id_paciente;
                        optionPaciente.textContent=nombre_paciente + ' ' + apellido_paciente;
                        txtPaciente.append(optionPaciente);
                    }
                );
            }
            //cargarDoctores();
        }
    ).catch(
        error=>{
            console.error("Error:",error);
        }
    );
}

function cargarDoctores() {
    API.get("doctores/getAll").then(
        data=>{
            if(data.success) {
                const txtDoctor=document.querySelector("#id_doctor");
                txtDoctor.innerHTML="";
                data.records.forEach(
                    (item,index)=>{
                        const {id_doctor,nombre_doctor, apellido_doctor}=item;
                        const optionDoctor=document.createElement("option");
                        optionDoctor.value=id_doctor;
                        optionDoctor.textContent=nombre_doctor + ' ' + apellido_doctor;  
                        txtDoctor.append(optionDoctor);
                    }
                );
            }
            //cargarDoctores();
        }
    ).catch(
        error=>{
            console.error("Error:",error);
        }
    );
}

function crearTabla() {
    if (objDatos.filter==""){
        objDatos.recordsFilter=objDatos.records.map(item=>item);
    } else {
        objDatos.recordsFilter=objDatos.records.filter(
            item=>{
                const {id_cita,nombre_paciente,apellido_paciente,descripcion_cita, fecha_cita, hora_cita, nombre_doctor, estado}=item;
                if (id_cita.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (nombre_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (apellido_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (descripcion_cita.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (fecha_cita.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (hora_cita.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (nombre_doctor.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (estado.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
            }
        );
    }
    const recordIni=(objDatos.currentPage*objDatos.recordsShow)-objDatos.recordsShow;
    const recordFin=(recordIni+objDatos.recordsShow)-1;
    let html="";
    objDatos.recordsFilter.forEach(
        (item,index)=>{
            if ((index>=recordIni) && (index<=recordFin)) {
                html+=`
                    <tr>
                    <td>${item.id_cita}</td>
                    <td>${item.nombre_paciente}</td>
                    <td>${item.apellido_paciente}</td>
                    <td>${item.descripcion_cita}</td>
                    <td>${item.fecha_cita}</td>
                    <td>${item.hora_cita}</td>
                    <td>${item.nombre_doctor}</td>
                    <td class="estado">${item.estado}</td>
                    <td>
                        <button class="editarbtn" type="button" onclick="editarCita(${item.id_cita})"><img src="public_html/iconos/edit.png" alt="x"/></button>
                        <button class="eliminarbtn" type="button" onclick="deleteCita(${item.id_cita})"><img src="public_html/iconos/trash.png" alt="x"/></button>
                    </td>
                    </tr>
                `;
            }
        }
    );
    tableContent.innerHTML=html;
    crearPaginacion();
}

function crearPaginacion() {
    //Borrar elementos
    pagination.innerHTML="";
    //Boton Anterior
    const elAnterior=document.createElement("li");
    elAnterior.classList.add("page-item");
    elAnterior.innerHTML=`<a class="page-link" href="#"><img class="anteriorbtn" src="public_html/iconos/next.png" alt="x"/> Anterior</a>`;
    elAnterior.onclick=()=>{
        objDatos.currentPage=(objDatos.currentPage==1 ? 1 : --objDatos.currentPage);
        crearTabla();
    }
    pagination.append(elAnterior);
    //Agregando los numeros de pagina
    const totalPage=Math.ceil(objDatos.recordsFilter.length/objDatos.recordsShow);
    for (let i=1; i<=totalPage;i++) {
        const el=document.createElement("li");
        el.classList.add("page-item");
        el.innerHTML=`<a class="page-link" href="#">${i}</a>`;
        el.onclick=()=> {
            objDatos.currentPage=i;
            crearTabla();
        }
        pagination.append(el);
    }
    //Boton siguiente
    const elSiguiente=document.createElement("li");
    elSiguiente.classList.add("page-item");
    elSiguiente.innerHTML=`<a class="page-link" href="#">Siguiente <img src="public_html/iconos/next.png" alt="x"/></a>`;
    elSiguiente.onclick=()=>{
        objDatos.currentPage=(objDatos.currentPage==totalPage ? totalPage : ++objDatos.currentPage);
        crearTabla();
    }
    pagination.append(elSiguiente);
}

function agregarCita() {
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelFiltros.classList.add("d-none");
    panelForm.classList.remove("d-none");
    limpiarForm();
}

function limpiarForm(op) {
    formCita.reset();
    document.querySelector("#id_cita").value="0";
}

function cancelarCita() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelFiltros.classList.remove("d-none");
    panelForm.classList.add("d-none");
    cargarDatos();
}

function editarCita(id) {
    limpiarForm(1);
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelFiltros.classList.add("d-none");
    panelForm.classList.remove("d-none");
    API.get("citas/getOneCita?id="+id).then(
        data=>{
            if (data.success) {
                mostrarDatosForm(data.records[0]);
            } else {
                Swal.fire({
                    icon:"error",
                    title:"Error",
                    text:data.msg
                });
            }
        }
    ).catch(
        error=>{
            console.error("Error:",error);
        }
    );
}

function mostrarDatosForm(record) {
    const {id_cita, id_paciente, descripcion_cita, fecha_cita, hora_cita, id_doctor, estado}=record;
    document.querySelector("#id_cita").value=id_cita;
    document.querySelector("#id_paciente").value=id_paciente;
    document.querySelector("#descripcion_cita").value=descripcion_cita;
    document.querySelector("#fecha_cita").value=fecha_cita;
    document.querySelector("#hora_cita").value=hora_cita;
    document.querySelector("#id_doctor").value=id_doctor;
    document.querySelector("#estado").value=estado;
}

function deleteCita(id) {
    Swal.fire({
        title:"Esta seguro de eliminar la cita?",
        showDenyButton:true,
        confirmButtonText:"Si",
        denyButtonText:"No"
    }).then(
        resultado=>{
            console.log(resultado.isConfirmed);
            if (resultado.isConfirmed) {
                API.get("citas/deleteCita?id="+id).then(
                    data=>{
                        if (data.success) {
                            cancelarCita();
                        } else {
                            Swal.fire({
                                icon:"error",
                                title:"Error",
                                text:data.msg
                            });
                        }
                    }
                ).catch(
                    error=>{
                        console.log("Error:",error);
                    }
                );
            }
        }       
    );
    console.log("Mensaje de texto");
    
}
