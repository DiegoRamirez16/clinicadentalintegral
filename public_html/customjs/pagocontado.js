//Variables globales y selectores
const btnNew=document.querySelector("#btnAgregar");
const panelDatos=document.querySelector("#contentList");
// Contenido de listado tablas
const panelDatos2=document.querySelector("#contentList2");
// Contenido de opciones de filtrar tabla
const panelFiltros=document.querySelector("#contentListOP");
const panelForm=document.querySelector("#contentForm");
const btnCancelar=document.querySelector("#btnCancelar");
const tableContent=document.querySelector("#contentTable table tbody");
const searchText=document.querySelector("#txtSearch");
const pagination=document.querySelector(".pagination");
const formPagocontado=document.querySelector("#formPagocontado");
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
    btnNew.addEventListener("click",agregarPagocontado);
    btnCancelar.addEventListener("click",cancelarPagocontado);
    //console.log("Antes de cargar");
    document.addEventListener("DOMContentLoaded",cargarDatos);
    //console.log("Despues de cargar");
    searchText.addEventListener("input", aplicarFiltro);
    formPagocontado.addEventListener("submit",guardarPagocontado);
}

//Funciones

function guardarPagocontado(event) {
    event.preventDefault();
    const formData=new FormData(formPagocontado);
    //console.log(formData);
    API.post(formData,"pagocontado/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success) {
                cancelarPagocontado();
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
let api = "pagocontado/getAll";

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
                document.getElementById("totalweek").innerHTML=data.total;
                document.getElementById("totalhoy").innerHTML=data.totalhoy;
                crearTabla();
                cargarTratamientos();
            } else {
                console.log("Error al recuperar los registros");
            }
            cargarPacientes();
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

function crearTabla() {
    if (objDatos.filter==""){
        objDatos.recordsFilter=objDatos.records.map(item=>item);
    } else {
        objDatos.recordsFilter=objDatos.records.filter(
            item=>{
                const {id_pagocontado, monto_contado, fecha_pago, nombre_paciente, apellido_paciente,nombre_tratamiento}=item;
                if (id_pagocontado.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (monto_contado.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (fecha_pago.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (nombre_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
                    return item;
                }
                if (apellido_paciente.toUpperCase().search(objDatos.filter.toUpperCase())!=-1) {
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
    objDatos.recordsFilter.forEach(
        (item,index)=>{
            if ((index>=recordIni) && (index<=recordFin)) {
                html+=`
                    <tr>
                    <td>${index+1}</td>
                    <td>$ ${item.monto_contado}</td>
                    <td>${item.fecha_pago}</td>
                    <td>${item.nombre_paciente}</td>
                    <td>${item.apellido_paciente}</td>
                    <td>${item.nombre_tratamiento}</td>
                    <td>
                        <button class="editarbtn" type="button" onclick="editarPagocontado(${item.id_pagocontado})"><img src="public_html/iconos/edit.png" alt="x"/></button>
                        <button class="eliminarbtn" type="button" onclick="deletePagocontado(${item.id_pagocontado})"><img src="public_html/iconos/trash.png" alt="x"/></button>
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

function agregarPagocontado() {
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelFiltros.classList.add("d-none");
    panelForm.classList.remove("d-none");
    limpiarForm();
}

function limpiarForm(op) {
    formPagocontado.reset();
    document.querySelector("#id_pagocontado").value="0";
}

function cancelarPagocontado() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelFiltros.classList.remove("d-none");
    panelForm.classList.add("d-none");
    cargarDatos();
}

function editarPagocontado(id) {
    limpiarForm(1);
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelFiltros.classList.add("d-none");
    panelForm.classList.remove("d-none");
    API.get("pagocontado/getOnePagocontado?id="+id).then(
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
    const {id_pagocontado, monto_contado, fecha_pago, id_paciente,id_tratamiento}=record;
    document.querySelector("#id_pagocontado").value=id_pagocontado;
    document.querySelector("#monto_contado").value=monto_contado;
    document.querySelector("#fecha_pago").value=fecha_pago;
    document.querySelector("#id_paciente").value=id_paciente;
    document.querySelector("#id_tratamiento").value=id_tratamiento;
}

function cargarPacientes() {
    API.get("pacientes/getAll").then(
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
        }
    ).catch(
        error=>{
            console.error("Error:",error);
        }
    );
}


function deletePagocontado(id) {
    Swal.fire({
        title:"¿Esta seguro de eliminar el Pago?",
        showDenyButton:true,
        confirmButtonText:"Si",
        denyButtonText:"No"
    }).then(
        resultado=>{
            console.log(resultado.isConfirmed);
            if (resultado.isConfirmed) {
                API.get("pagocontado/deletePagocontado?id="+id).then(
                    data=>{
                        if (data.success) {
                            cancelarPagocontado();
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
