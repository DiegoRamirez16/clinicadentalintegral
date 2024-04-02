//Variables globales y selectores
const btnNew=document.querySelector("#btnAgregar");
const panelDatos=document.querySelector("#contentList");
const panelDatosM=document.querySelector("#contentListMenu");
const panelDatos2=document.querySelector("#contentList2");
const panelForm=document.querySelector("#contentForm");
const panelFormExpecambios=document.querySelector("#contentFormExpecambios");
const btnCancelar=document.querySelector("#btnCancelar");
const btnCancelarCambios=document.querySelector("#btnCancelarCambios");
const btnAdd=document.querySelector("#agregarC");
const formExpediente=document.querySelector("#formExpediente");
const formExpecambios=document.querySelector("#formExpecambios");
const tableContent=document.querySelector("#contentTable table tbody");
const searchText=document.querySelector("#txtSearch");
const pagination=document.querySelector(".pagination");
// Controles
const tableContentC = document.querySelector("#contentTableC table tbody");
const paginationC=document.querySelector(".paginationC");
const formControlClinico = document.querySelector("#formControlClinico");
const panelFormC=document.querySelector("#contentFormC");
const btnCancelarC=document.querySelector("#btnCancelarC");

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
    btnNew.addEventListener("click",agregarExpediente);
    btnCancelar.addEventListener("click",cancelarExpediente);
    btnCancelarCambios.addEventListener("click", cancelarExpecambios);
    btnCancelarC.addEventListener("click",cancelarControlClinico);
    btnAdd.addEventListener("click",agregarC);
    document.addEventListener("DOMContentLoaded",cargarDatos);
    document.addEventListener("DOMContentLoaded",cargarDatosC);
    searchText.addEventListener("input", aplicarFiltro);
    formExpediente.addEventListener("submit",guardarExpediente);
    formControlClinico.addEventListener("submit", guardarControlClinico);
    formExpecambios.addEventListener("submit", guardarExpecambios);
}
//Funciones
function guardarExpediente(event){
    event.preventDefault();
    const formData = new FormData(formExpediente);
    //console.log(formData);
    API.post(formData,"expedientes/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success){
                cancelarExpediente();
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
        error=>{
            console.log("Error:",error);
        }
    );
}

function guardarExpecambios(event){
    event.preventDefault();
    const formData = new FormData(formExpecambios);
    //console.log(formData);
    API.post(formData,"expedientes/update").then(
        data=>{
            //console.log(data.msg);
            if (data.success){
                cancelarExpecambios();
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
        error=>{
            console.log("Error:",error);
        }
    );
}


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

function aplicarFiltro (element) {
    element.preventDefault();
    objDatos.filter=this.value;
    crearTabla();
}

function cargarDatos() {
    //console.log("Cargando datos");
    API.get("expedientes/getAll").then(
        data=>{
            //console.log(data.records);
            if (data.success) {
                objDatos.records=data.records;
                objDatos.currentPage=1;
                crearTabla();
                cargarPacientes();
                cargarPacientesEditar();
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
// Carga de datos de los controles en el modal
function cargarDatosC(id) {
  //console.log("Cargando datos");
  API.get("controlesclinico/getAllId?id="+id)
    .then((data) => {
      //console.log(data.records);
      if (data.success) {
        objDatos.records = data.records;
        objDatos.currentPage = 1;
        crearTablaC();
        cargarTratamientos();
        cargarPacientesC();
        
      } else {
        console.log("Error al recuperar los registros");
      }
    })
    .catch((error) => {
      console.error("Error en la llamada:", error);
    });
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
    API.get("pacientes/getAllNoExp").then(
        data=>{
            if(data.success) {
                const txtPaciente=document.querySelector("#id_paciente");
                txtPaciente.innerHTML="";
                data.records.forEach(
                    (item,index)=>{
                        const {id_paciente,nombre_paciente, apellido_paciente}=item;
                        const optionPaciente=document.createElement("option");
                        optionPaciente.value=id_paciente;
                        optionPaciente.textContent=nombre_paciente + ' ' + apellido_paciente;  
                        txtPaciente.append(optionPaciente);
                    }
                );
            }
            //cargarTratamientos();
        }
    ).catch(
        error=>{
            console.error("Error:",error);
        }
    );
}

function cargarPacientesEditar() {
    API.get("pacientes/getAll").then(
        data=>{
            if(data.success) {
                const txtPaciente=document.querySelector("#id_pacientec");
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
            //cargarTratamientos();
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
                const {id_expediente,nombre_paciente,apellido_paciente,motivo_consulta,fecha_expediente}=item;
                if (id_expediente.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
                    return item;
                } 
                if (nombre_paciente.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
                    return item;
                }     
                if (apellido_paciente.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
                    return item;
                }    
                if (motivo_consulta.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
                    return item;
                }
                if (fecha_expediente.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
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
            if ((index>=recordIni) && (index<=recordFin)){           
                html += `<tr>
                    <td>${item.id_expediente}</td>
                    <td>${item.nombre_paciente}</td>
                    <td>${item.apellido_paciente}</td>
                    <td>${item.motivo_consulta}</td>
                    <td>${item.fecha_expediente}</td>
                    <td>
                        <button class="addctrlbtn" type="button" id="agregarC" onclick="agregarC(${
                          item.id_expediente
                        })"><img src="public_html/iconos/add24.png" alt="x"/></button>
                        <button class="listarbtn" type="button" id="listaControles" onclick="listarC(${
                          item.id_expediente
                        })"><img src="public_html/iconos/eyelupa24.png" alt="x"/></button>
                        <button class="editarbtn" type="button" onclick="editarExpediente(${
                          item.id_expediente
                        })"><img src="public_html/iconos/edit.png" alt="x"/></button>
                        <button class="eliminarbtn" type="button" onclick="eliminarExpediente(${
                          item.id_expediente
                        })"><img src="public_html/iconos/trash.png" alt="x"/></button>
                    </td>
                    </tr> `;
            }
        }
    );
    //console.log(html);
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


// MODAL Controles Listado tabla
function crearTablaC() {
  if (objDatos.filter == "") {
    objDatos.recordsFilter = objDatos.records.map((item) => item);
  } else {
    objDatos.recordsFilter = objDatos.records.filter((item) => {
      const {
        id_controles,
        nombre_tratamiento,
        fecha_control,
        diagnostico,
        observacion_control,
        nombre_paciente,
      } = item;
      if (
        id_controles.toUpperCase().search(objDatos.filter.toUpperCase()) != -1
      ) {
        return item;
      }
      if (
        nombre_tratamiento
          .toUpperCase()
          .search(objDatos.filter.toUpperCase()) != -1
      ) {
        return item;
      }
      if (
        fecha_control.toUpperCase().search(objDatos.filter.toUpperCase()) != -1
      ) {
        return item;
      }
      if (
        diagnostico.toUpperCase().search(objDatos.filter.toUpperCase()) != -1
      ) {
        return item;
      }
      if (
        observacion_control
          .toUpperCase()
          .search(objDatos.filter.toUpperCase()) != -1
      ) {
        return item;
      }
      if (
        nombre_paciente.toUpperCase().search(objDatos.filter.toUpperCase()) !=
        -1
      ) {
        return item;
      }
    });
  }
  const recordIni =
    objDatos.currentPage * objDatos.recordsShow - objDatos.recordsShow;
  const recordFin = recordIni + objDatos.recordsShow - 1;
  let html = "";
  objDatos.recordsFilter.forEach((item, index) => {
    if (index >= recordIni && index <= recordFin) {
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
  });
  tableContentC.innerHTML = html;
  crearPaginacionC();
}

function crearPaginacionC() {
    //Borrar elementos
    paginationC.innerHTML="";
    //Boton Anterior
    const elAnteriorC=document.createElement("li");
    elAnteriorC.classList.add("page-itemC");
    elAnteriorC.innerHTML=`<a class="page-linkC" href="#">Anterior</a>`;
    elAnteriorC.onclick=()=>{
        objDatos.currentPage=(objDatos.currentPage==1 ? 1 : --objDatos.currentPage);
        crearTablaC();
    }
    paginationC.append(elAnteriorC);
    //Agregando los numeros de pagina
    const totalPage=Math.ceil(objDatos.recordsFilter.length/objDatos.recordsShow);
    for (let i=1; i<=totalPage;i++) {
        const elC=document.createElement("li");
        elC.classList.add("page-itemC");
        elC.innerHTML=`<a class="page-linkC" href="#">${i}</a>`;
        elC.onclick=()=> {
            objDatos.currentPage=i;
            crearTablaC();
        }
        paginationC.append(elC);
    }
    //Boton siguiente
    const elSiguienteC=document.createElement("li");
    elSiguienteC.classList.add("page-itemC");
    elSiguienteC.innerHTML=`<a class="page-linkC" href="#">Siguiente</a>`;
    elSiguienteC.onclick=()=>{
        objDatos.currentPage=(objDatos.currentPage==totalPage ? totalPage : ++objDatos.currentPage);
        crearTablaC();
    }
    paginationC.append(elSiguienteC);
}

// EDITAR y BORRAR CONTROLES
function limpiarFormC(op) {
    formControlClinico.reset();
    document.querySelector("#id_controles").value="0";
}
function editarControlClinico(id) {
    limpiarFormC(1);
    panelDatos2.classList.add("d-none");
    panelFormC.classList.remove("d-none");
    API.get("controlesclinico/getOneControlClinico?id="+id).then(
        data=>{
            if (data.success) {
                mostrarDatosFormC(data.records[0]);
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

function cancelarControlClinico() {
    panelDatos2.classList.remove("d-none");
    panelFormC.classList.add("d-none");
    crearTablaC();
    
}

function mostrarDatosFormC(record) {
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

function cargarPacientesC() {
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

// Expediente
function agregarExpediente() {
    panelDatos.classList.add("d-none");
    panelDatosM.classList.add("d-none");
    panelForm.classList.remove("d-none");
    limpiarForm();
}
function limpiarForm(op) {
    formExpediente.reset();
    document.querySelector("#id_expediente").value="0";
}
function limpiarFormExpecambios(op) {
    formExpecambios.reset();
    document.querySelector("#id_expediente").value="0";
}
function cancelarExpediente() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelDatosM.classList.remove("d-none");
    panelForm.classList.add("d-none");
    cargarDatos();
}
function cancelarExpecambios() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelDatosM.classList.remove("d-none");
    panelFormExpecambios.classList.add("d-none");
    cargarDatos();
}

function agregarC(id) {
    location.href="controlesclinico/addcontroles?id="+id;
}

function editarExpediente(id) {
    limpiarFormExpecambios(1);
    panelDatos.classList.add("d-none");
    panelDatosM.classList.add("d-none");
    panelFormExpecambios.classList.remove("d-none");
    API.get("expedientes/getOneExpediente?id="+id).then(
        data=>{
            if (data.success) {
                mostrarDatosFormCambios(data.records[0]);
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

function mostrarDatosFormCambios(record){
    const {id_expediente,motivo_consulta,id_paciente,fecha_expediente}=record;
    document.querySelector("#id_expedientec").value=id_expediente;
    document.querySelector("#id_pacientec").value=id_paciente;
    document.querySelector("#motivo_consultac").value=motivo_consulta;
    document.querySelector("#fecha_expedientec").value=fecha_expediente;
    
}

function mostrarDatosForm(record){
    const {id_expediente,motivo_consulta,id_paciente,fecha_expediente}=record;
    document.querySelector("#id_expediente").value=id_expediente;
    document.querySelector("#motivo_consulta").value=motivo_consulta;
    document.querySelector("#id_paciente").value=id_paciente;
    document.querySelector("#fecha_expediente").value=fecha_expediente;
    
}

function eliminarExpediente(id) {
    Swal.fire({
        title:"Esta seguro de eliminar el registro?",
        showDenyButton:true,
        confirmButtonText:"Si",
        denyButtonText:"No"
    }).then(
        resultado=>{
            console.log(resultado.isConfirmed);
            if (resultado.isConfirmed) {
                API.get("expedientes/deleteExpediente?id="+id).then(
                    data=>{
                        if (data.success) {
                            cancelarExpediente();
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

function listarC(id) {
    console.log(id);
    var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'),{
        keyboard: false
    })
    myModal.show();
    cargarDatosC(id);
}