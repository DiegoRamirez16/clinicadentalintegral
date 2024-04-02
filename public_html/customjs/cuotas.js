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
const formCuota=document.querySelector("#formCuota");
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
    btnNew.addEventListener("click",agregarCuota);
    btnCancelar.addEventListener("click",cancelarCuota);
    //console.log("Antes de cargar");
    document.addEventListener("DOMContentLoaded",cargarDatos);
    //console.log("Despues de cargar");
    searchText.addEventListener("input", aplicarFiltro);
    formCuota.addEventListener("submit",guardarCuota);
}

//Funciones

function guardarCuota(event) {
    event.preventDefault();
    const formData=new FormData(formCuota);
    //console.log(formData);
    API.post(formData,"cuotas/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success) {
                cancelarCuota();
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
    API.get("cuotas/getAll").then(
        data=>{
            //console.log(data.records);
            if (data.success) {
                objDatos.records=data.records;
                objDatos.currentPage=1;
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
                    <td>${item.id_plancuota}</td>
                    <td>${item.cuota}</td>
                    <td>$ ${item.monto_cuota}</td>
                    <td>${item.fecha_pago}</td>
                    <td>${item.estado}</td>
                    <td>
                        <button class="editarbtn" type="button" onclick="editarCuota(${item.id_cuota})"><img src="public_html/iconos/edit.png" alt="x"/></button>
                        <button class="eliminarbtn" type="button" onclick="deleteCuota(${item.id_cuota})"><img src="public_html/iconos/trash.png" alt="x"/></button>
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

function agregarCuota() {
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelForm.classList.remove("d-none");
    limpiarForm();
}

function limpiarForm(op) {
    formCuota.reset();
    document.querySelector("#id_cuota").value="0";
}

function cancelarCuota() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelForm.classList.add("d-none");
    cargarDatos();
}

function editarCuota(id) {
    limpiarForm(1);
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelForm.classList.remove("d-none");
    API.get("cuotas/getOneCuota?id="+id).then(
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
    const {id_cuota,id_plancuota,cuota, monto_cuota, fecha_pago, estado}=record;
    document.querySelector("#id_cuota").value=id_cuota;
    document.querySelector("#id_plancuota").value=id_plancuota;
    document.querySelector("#cuota").value=cuota;
    document.querySelector("#monto_cuota").value=monto_cuota;
    document.querySelector("#fecha_pago").value=fecha_pago;
    document.querySelector("#estado").value=estado;
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