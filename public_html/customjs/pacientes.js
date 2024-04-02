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
const formPaciente=document.querySelector("#formPaciente");
const btnAdd=document.querySelector("#perfilPaciente");
const tableContent=document.querySelector("#contentTable table tbody");
const searchText=document.querySelector("#txtSearch");
const pagination=document.querySelector(".pagination");
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
    btnNew.addEventListener("click",agregarPaciente);
    btnAdd.addEventListener("click",perfilPaciente);
    btnCancelar.addEventListener("click",cancelarPaciente);
    document.addEventListener("DOMContentLoaded",cargarDatos);
    searchText.addEventListener("input", aplicarFiltro);
    formPaciente.addEventListener("submit",guardarPaciente);

}

//Funciones

function guardarPaciente(event) {
    event.preventDefault();
    const formData=new FormData(formPaciente);
    //console.log(formData);
    API.post(formData,"pacientes/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success) {
                cancelarPaciente();
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
let api = "pacientes/getAll";

function cambiarApi(nuevaApi) {
    api = nuevaApi;
    cargarDatos();
    
}
function cargarDatos() {
    API.get(api).then(
        data=>{
            //console.log(data.records);
            if (data.success) {
                objDatos.records=data.records;
                objDatos.currentPage=1;
                document.getElementById("totalpacientes").innerHTML = data.total;
                document.getElementById("totalmas").innerHTML = data.totalmas;
                document.getElementById("totalfem").innerHTML = data.totalfem;
                crearTabla();
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


function crearTabla() {
    if (objDatos.filter==""){
        objDatos.recordsFilter=objDatos.records.map(item=>item);
    } else {
        objDatos.recordsFilter=objDatos.records.filter(
            item=>{
                const {nombre_paciente,apellido_paciente,telefono_paciente,fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente}=item;
                if (nombre_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (apellido_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (telefono_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (fecha_nacimiento.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (sexo_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (observacion_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (alergia_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (padecimiento_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
            }
        );
    }
    const recordIni=(objDatos.currentPage*objDatos.recordsShow)-objDatos.recordsShow;
    const recordFin=(recordIni+objDatos.recordsShow)-1;
    let html="";
    console.log(recordIni,recordFin);
    objDatos.recordsFilter.forEach(
        (item,index)=>{
            if ((index>=recordIni) && (index<=recordFin)) {
                html += `
                    <tr>
                    <td>${item.id_paciente}</td>
                    <td>${item.nombre_paciente}</td>
                    <td>${item.apellido_paciente}</td>
                    <td>${item.telefono_paciente}</td>
                    <td>${item.fecha_nacimiento}</td>
                    <td>${item.sexo_paciente}</td>
                    <td>${item.observacion_paciente}</td>
                    <td>${item.alergia_paciente}</td>
                    <td>${item.padecimiento_paciente}</td>
                    <td>
                        <button class="addctrlbtn" type="button" id="perfilPaciente" onclick="perfilPaciente(${item.id_paciente})"><img src="public_html/iconos/profile24.png" alt="x"/></button>
                        <button class="editarbtn" type="button" onclick="editarPaciente(${item.id_paciente})"><img src="public_html/iconos/edit.png" alt="x"/></button>
                        <button class="eliminarbtn" type="button" onclick="deletePaciente(${item.id_paciente})"><img src="public_html/iconos/trash.png" alt="x"/></button>
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
    elAnterior.innerHTML=`<a class="page-link" href="#">Anterior</a>`;
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
    elSiguiente.innerHTML=`<a class="page-link" href="#">Siguiente</a>`;
    elSiguiente.onclick=()=>{
        objDatos.currentPage=(objDatos.currentPage==totalPage ? totalPage : ++objDatos.currentPage);
        crearTabla();
    }
    pagination.append(elSiguiente);
}

function agregarPaciente() {
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelFiltros.classList.add("d-none");
    panelForm.classList.remove("d-none");
    limpiarForm();

}

function perfilPaciente(id) {
  location.href="pacientes/perfiles?id="+id;
}

function limpiarForm(op) {
    formPaciente.reset();
    document.querySelector("#id_paciente").value="0";
}

function cancelarPaciente() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelFiltros.classList.remove("d-none");
    panelForm.classList.add("d-none");
    cargarDatos();
}
function editarPaciente(id) {
    limpiarForm(1);
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelFiltros.classList.add("d-none");
    panelForm.classList.remove("d-none");
    API.get("pacientes/getOnePaciente?id="+id).then(
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
    const {id_paciente, nombre_paciente,apellido_paciente,telefono_paciente,fecha_nacimiento,sexo_paciente,observacion_paciente,alergia_paciente,padecimiento_paciente}=record;
    document.querySelector("#id_paciente").value=id_paciente;
    document.querySelector("#nombre_paciente").value=nombre_paciente;
    document.querySelector("#apellido_paciente").value=apellido_paciente;
    document.querySelector("#telefono_paciente").value=telefono_paciente;
    document.querySelector("#fecha_nacimiento").value=fecha_nacimiento;
    document.querySelector("#sexo_paciente").value=sexo_paciente;
    document.querySelector("#observacion_paciente").value=observacion_paciente;
    document.querySelector("#alergia_paciente").value=alergia_paciente;
    document.querySelector("#padecimiento_paciente").value=padecimiento_paciente;
}
function deletePaciente(id) {
    Swal.fire({
        title:"Esta seguro de eliminar el registro?",
        showDenyButton:true,
        confirmButtonText:"Si",
        denyButtonText:"No"
    }).then(
        resultado=>{
            console.log(resultado.isConfirmed);
            if (resultado.isConfirmed) {
                API.get("pacientes/deletePaciente?id="+id).then(
                    data=>{
                        if (data.success) {
                            cancelarPaciente();
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