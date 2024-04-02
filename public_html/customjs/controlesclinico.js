//Variables globales y selectores
const btnNew=document.querySelector("#btnAgregar");
// Contenido del Nombre del Listado, Boton Agregar y Cuadro de busqueda
const panelDatos=document.querySelector("#contentList");
// Contenido de listado tablas
const panelDatos2=document.querySelector("#contentList2");
const panelForm=document.querySelector("#contentForm");
const btnCancelar=document.querySelector("#btnCancelar");
const tableContent=document.querySelector("#contentTable table tbody");
const searchText=document.querySelector("#txtSearch");
const pagination=document.querySelector(".pagination");
const formControlClinico=document.querySelector("#formControlClinico");
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
    btnNew.addEventListener("click",agregarControlClinico);
    btnCancelar.addEventListener("click",cancelarControlClinico);
    //console.log("Antes de cargar");
    document.addEventListener("DOMContentLoaded",cargarDatos);
    //console.log("Despues de cargar");
    searchText.addEventListener("input", aplicarFiltro);
    formControlClinico.addEventListener("submit",guardarControlClinico);
}

//Funciones

function guardarControlClinico(event) {
    event.preventDefault();
    const formData=new FormData(formControlClinico);
    //console.log(formData);
    API.post(formData,"controlesclinico/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success) {
                cancelarControlClinico();
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

function cargarDatos() {
    //console.log("Cargando datos");
    API.get("controlesclinico/getAll").then(
        data=>{
            //console.log(data.records);
            if (data.success) {
                objDatos.records=data.records;
                objDatos.currentPage=1;
                crearTabla();
                cargarTratamientos();
                cargarPacientes();
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

function cargarTratamientos() {
  API.get("tratamientos/getAll")
    .then((data) => {
      if (data.success) {
        const txtTratamiento = document.querySelector("#id_tratamiento");
        txtTratamiento.innerHTML = "";
        data.records.forEach((item, index) => {
          const { id_tratamiento, nombre_tratamiento } = item;
          const optionTratamiento = document.createElement("option");
          optionTratamiento.value = id_tratamiento;
          optionTratamiento.textContent = nombre_tratamiento;
          txtTratamiento.append(optionTratamiento);
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}
function cargarPacientes() {
  API.get("controlesclinico/getNameById")
    .then((data) => {
      if (data.success) {
        const txtExpediente = document.querySelector("#id_expediente");
        txtExpediente.innerHTML = "";
        data.records.forEach((item, index) => {
          const { id_expediente, nombre_paciente } = item;
          const optionExpediente = document.createElement("option");
          optionExpediente.value = id_expediente;
          optionExpediente.textContent = nombre_paciente;
          txtExpediente.append(optionExpediente);
        });
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function crearTabla() {
    if (objDatos.filter==""){
        objDatos.recordsFilter=objDatos.records.map(item=>item);
    } else {
        objDatos.recordsFilter=objDatos.records.filter(
            item=>{
                const {id_controles,nombre_tratamiento,fecha_control, diagnostico, observacion_control, nombre_paciente}=item;
                if (id_controles.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (nombre_tratamiento.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (fecha_control.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (diagnostico.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (observacion_control.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (nombre_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
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
                html += `
                    <tr>
                    <td>${item.id_controles}</td>
                    <td>${item.nombre_tratamiento}</td>
                    <td>${item.fecha_control}</td>
                    <td>${item.diagnostico}</td>
                    <td>${item.observacion_control}</td>
                    <td>${item.nombre_paciente}</td>
                    <td>
                        <button class="editarbtn" type="button" onclick="editarControlClinico(${item.id_controles})"><img src="public_html/iconos/edit.png" alt="x"/></button>
                        <button class="eliminarbtn" type="button" onclick="deleteControlClinico(${item.id_controles})"><img src="public_html/iconos/trash.png" alt="x"/></button>
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

function agregarControlClinico() {
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelForm.classList.remove("d-none");
    limpiarForm();
}

function limpiarForm(op) {
    formControlClinico.reset();
    document.querySelector("#id_controles").value="0";
}

function cancelarControlClinico() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelForm.classList.add("d-none");
    cargarDatos();
}

function editarControlClinico(id) {
    limpiarForm(1);
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelForm.classList.remove("d-none");
    API.get("controlesclinico/getOneControlClinico?id="+id).then(
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
    const {id_controles,id_tratamiento,fecha_control, diagnostico, observacion_control, id_expediente}=record;
    document.querySelector("#id_controles").value=id_controles;
    document.querySelector("#id_tratamiento").value=id_tratamiento;
    document.querySelector("#fecha_control").value=fecha_control;
    document.querySelector("#diagnostico").value=diagnostico;
    document.querySelector("#observacion_control").value=observacion_control;
    document.querySelector("#id_expediente").value=id_expediente;
}

function deleteControlClinico(id) {
    Swal.fire({
        title:"Esta seguro de eliminar el control?",
        showDenyButton:true,
        confirmButtonText:"Si",
        denyButtonText:"No"
    }).then(
        resultado=>{
            console.log(resultado.isConfirmed);
            if (resultado.isConfirmed) {
                API.get("controlesclinico/deleteControlClinico?id="+id).then(
                    data=>{
                        if (data.success) {
                            cancelarControlClinico();
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