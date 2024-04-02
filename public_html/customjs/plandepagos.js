//Variables globales y selectores
const btnNew=document.querySelector("#btnAgregar");
const panelDatos=document.querySelector("#contentList");
const panelDatosM=document.querySelector("#contentListMenu");
const panelDatos2=document.querySelector("#contentList2");
// Contenido de opciones de filtrar tabla
const panelFiltros=document.querySelector("#contentListOP");
const panelForm=document.querySelector("#contentForm");
const panelFormPlancambios=document.querySelector("#contentFormPlancambios");
const btnCancelar=document.querySelector("#btnCancelar");
const btnCancelarCambios=document.querySelector("#btnCancelarCambios");
const formPago=document.querySelector("#formPago");
const formPlancambios=document.querySelector("#formPlancambios");
const tableContent=document.querySelector("#contentTable table tbody");
const searchText=document.querySelector("#txtSearch");
const pagination=document.querySelector(".pagination");
// Cuotas
const tableContentC = document.querySelector("#contentTableC table tbody");
const paginationC=document.querySelector(".paginationC");
const formCuota=document.querySelector("#formCuota");
const panelFormC=document.querySelector("#contentFormC");
const btnCancelarC=document.querySelector("#btnCancelarC");
let codigoCuota=0;

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
    btnNew.addEventListener("click",agregarPago);
    btnCancelar.addEventListener("click",cancelarPago);
    btnCancelarCambios.addEventListener("click", cancelarPlancambios);
    // cuotas
    btnCancelarC.addEventListener("click",cancelarCuota);
    document.addEventListener("DOMContentLoaded",cargarDatos);
    document.addEventListener("DOMContentLoaded",cargarDatosC);
    searchText.addEventListener("input", aplicarFiltro);
    formPago.addEventListener("submit",guardarPago);
    formPago.addEventListener("submit",guardarPagoCuotas);
    formPlancambios.addEventListener("submit", guardarPlancambios);
    // cuotas
    btnCancelarCambios.addEventListener("click", cancelarPlancambios);
    formCuota.addEventListener("submit",guardarCuota);
}

//Funciones

function guardarPago(event) {
    event.preventDefault();
    const formData=new FormData(formPago);
    //console.log(formData);
    API.post(formData,"plandepagos/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success) {
                cancelarPago();
                
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
function calcularDivision() {
    var monto = parseFloat(document.getElementById('monto').value);
    var cuotas = parseInt(document.getElementById('cantcuotas').value);
      
    if (cuotas === 0) {
        alert("La cantidad de cuotas debe ser mayor que cero.");
        return;
    }
      
    var resultado = monto / cuotas;
      
    document.getElementById('resultado').innerHTML = "Monto Cuota: $ " + resultado.toFixed(2);
}
function guardarPlancambios(event){
    event.preventDefault();
    const formData = new FormData(formPlancambios);
    //console.log(formData);
    API.post(formData,"plandepagos/update").then(
        data=>{
            //console.log(data.msg);
            if (data.success){
                cancelarPlancambios();
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

function guardarPagoCuotas(event) {
    return
    event.preventDefault();
    const formData=new FormData(formPago);
    //console.log(formData);
    API.post(formData,"plandepagos/saveCuo").then(
        data=>{
            //console.log(data.msg);
            if (data.success) {
                cancelarPago();
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

let api = "plandepagos/getPlanesActivos";

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
                document.getElementById("totalcuotashoy").innerHTML=data.totalhoy;
                crearTabla();
                cargarPacientes();
                cargarPacientesEditar();
                cargarTratamientos();
                cargarTratamientosEditar();
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
        }
    ).catch(
        error=>{
            console.error("Error:",error);
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
function cargarTratamientosEditar() {
  API.get("tratamientos/getAll")
    .then((data) => {
      if (data.success) {
        const txtTratamiento = document.querySelector("#id_tratamientoc");
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


function cargarPacientesEditar() {
    API.get("pacientes/getAll").then(
        data=>{
            if(data.success) {
                const txtPaciente=document.querySelector("#id_pacientec");
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
                const {nombre_paciente, monto,cantidad_cuotas,fecha_plancuota,estado, nombre_tratamiento}=item;
                if (nombre_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (monto.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (cantidad_cuotas.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (fecha_plancuota.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (estado.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (nombre_tratamiento.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
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
                html+=`
                    <tr>
                    <td>${item.id_plancuota}</td>
                    <td>${item.nombre_paciente}</td>
                    <td>$ ${item.monto}</td>
                    <td>${item.cantidad_cuotas}</td>
                    <td>${item.fecha_plancuota}</td>
                    <td>${item.estado}</td>
                    <td>${item.nombre_tratamiento}</td>
                    <td>
                        <button class="listarbtn" type="button" id="listaControles" onclick="listarC(${item.id_plancuota})"><img src="public_html/iconos/eyelupa24.png" alt="x"/></button>
                        <button class="editarbtn" type="button" onclick="editarPago(${item.id_plancuota})"><img src="public_html/iconos/edit.png" alt="x"/></button>
                        <button class="eliminarbtn" type="button" onclick="eliminarPago(${item.id_plancuota})"><img src="public_html/iconos/trash.png" alt="x"/></button>
                    </td>
                    </tr> `;
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

function agregarPago() {
    panelDatos.classList.add("d-none");
    panelDatosM.classList.add("d-none");
    panelFiltros.classList.add("d-none");
    panelForm.classList.remove("d-none");
    limpiarForm();
}

function limpiarForm(op) {
    formPago.reset();
    document.querySelector("#id_plancuota").value="0";
}

function limpiarFormPlancambios(op) {
    formPlancambios.reset();
    document.querySelector("#id_plancuota").value="0";
}

function cancelarPago() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelDatosM.classList.remove("d-none");
    panelFiltros.classList.remove("d-none");
    panelForm.classList.add("d-none");
    cargarDatos();
}

function cancelarPlancambios() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelDatosM.classList.remove("d-none");
    panelFiltros.classList.remove("d-none");
    panelFormPlancambios.classList.add("d-none");
    cargarDatos();
}

function editarPago(id) {
    limpiarFormPlancambios(1);
    panelDatos.classList.add("d-none");
    panelDatosM.classList.add("d-none");
    panelFiltros.classList.add("d-none");
    panelFormPlancambios.classList.remove("d-none");
    API.get("plandepagos/getOnePlan?id="+id).then(
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

function mostrarDatosForm(record){
    const {id_plancuota,id_paciente,monto,cantidad_cuotas,fecha_plancuota,estado,id_tratamiento}=record;
    document.querySelector("#id_plancuota").value=id_plancuota;
    document.querySelector("#id_paciente").value=id_paciente;
    document.querySelector("#monto").value=monto;
    document.querySelector("#cantidad_cuotas").value=cantidad_cuotas;
    document.querySelector("#fecha_plancuota").value=fecha_plancuota;
    document.querySelector("#estado").value=estado;
    document.querySelector("#id_tratamiento").value=id_tratamiento;

}
function mostrarDatosFormCambios(record){
    const {id_plancuota,id_paciente,monto,cantidad_cuotas,fecha_plancuota,estado,id_tratamiento}=record;
    document.querySelector("#id_plancuotac").value=id_plancuota;
    document.querySelector("#id_pacientec").value=id_paciente;
    document.querySelector("#montoc").value=monto;
    document.querySelector("#cantidad_cuotasc").value=cantidad_cuotas;
    document.querySelector("#fecha_plancuotac").value=fecha_plancuota;
    document.querySelector("#estadoc").value=estado;
    document.querySelector("#id_tratamientoc").value=id_tratamiento;

}

function eliminarPago(id) {
    Swal.fire({
        title:"Esta seguro de eliminar el registro?",
        showDenyButton:true,
        confirmButtonText:"Si",
        denyButtonText:"No"
    }).then(
        resultado=>{
            console.log(resultado.isConfirmed);
            if (resultado.isConfirmed) {
                API.get("plandepagos/deletePago?id="+id).then(
                    data=>{
                        if (data.success) {
                            cancelarPago();
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

// ___________________ * CUOTAS MODAL *____________________________

function listarC(id) {
    console.log(id);
    var myModal = new bootstrap.Modal(document.getElementById('staticBackdrop'),{
        keyboard: false
    })
    myModal.show();
    cargarDatosC(id);
}

function cargarDatosC(id) {
    //console.log("Cargando datos");
    API.get("cuotas/getOnePlan?id="+id).then(
        data=>{
            //console.log(data.records);
            if (data.success) {
                objDatos.records=data.records;
                objDatos.currentPage=1;
                crearTablaC();
                codigoCuota=id;
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

function crearTablaC() {
    if (objDatos.filter==""){
        objDatos.recordsFilter=objDatos.records.map(item=>item);
    } else {
        objDatos.recordsFilter=objDatos.records.filter(
            item=>{
                const {id_cuota,id_plancuota,cuota, monto_cuota, fecha_pago, estado}=item;
                if (id_cuota.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (id_plancuota.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (cuota.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (monto_cuota.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (fecha_pago.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
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
                    <td>${item.id_cuota}</td>
                    <td>${item.fecha_pago}</td>
                    <td>${item.cuota}</td>
                    <td>$ ${item.monto_cuota}</td>
                    <td>${item.id_plancuota}</td>
                    
                    <td>${item.estado}</td>
                    <td>
                        <button class="editarbtn" type="button" onclick="editarCuota(${item.id_cuota})"><img src="public_html/iconos/credit-card.png" alt="x"/></button>
                        <button class="eliminarbtn" type="button" onclick="deleteCuota(${item.id_cuota})"><img src="public_html/iconos/trash.png" alt="x"/></button>
                    </td>
                    </tr>
                `;
            }
        }
    );
    tableContentC.innerHTML=html;
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

function guardarCuota(event) {
    event.preventDefault();
    const formData=new FormData(formCuota);
    //console.log(formData);
    API.post(formData,"cuotas/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success) {
                cancelarCuota();
                cargarDatosC(codigoCuota);
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

// Botones editar y eliminar cuota

function limpiarFormC(op) {
    formCuota.reset();
    document.querySelector("#id_cuota").value="0";
}

function editarCuota(id) {
    limpiarFormPlancambios(1);
    panelDatos2.classList.add("d-none");
    panelFormC.classList.remove("d-none");
    API.get("cuotas/getOneCuota?id="+id).then(
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

function mostrarDatosFormC(record) {
    const {id_cuota,id_plancuota,cuota, monto_cuota, fecha_pago, estado}=record;
    document.querySelector("#id_cuota").value=id_cuota;
    document.querySelector("#id_plancuota").value=id_plancuota;
    document.querySelector("#cuota").value=cuota;
    document.querySelector("#monto_cuota").value=monto_cuota;
    document.querySelector("#fecha_pago").value=fecha_pago;
    document.querySelector("#estado").value=estado;
}

function cancelarCuota() {
    panelDatos2.classList.remove("d-none");
    panelFormC.classList.add("d-none");
    crearTablaC();
    
}

function deleteCuota(id) {
    Swal.fire({
        title:"Esta seguro de eliminar la cuota?",
        showDenyButton:true,
        confirmButtonText:"Si",
        denyButtonText:"No"
    }).then(
        resultado=>{
            console.log(resultado.isConfirmed);
            if (resultado.isConfirmed) {
                API.get("cuotas/deleteCuota?id="+id).then(
                    data=>{
                        if (data.success) {
                            cancelarCuota();
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
