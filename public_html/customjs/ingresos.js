//Variables globales y selectores
const btnNew=document.querySelector("#btnAgregar");
const panelDatos=document.querySelector("#contentList");
const panelForm=document.querySelector("#contentForm");
const btnCancelar=document.querySelector("#btnCancelar");
const tableContent=document.querySelector("#contentTable table tbody");
const searchText=document.querySelector("#txtSearch");
const pagination=document.querySelector(".pagination");
const FormIngreso=document.querySelector("#FormIngreso");
const API=new Api();
const objDatos={
    records:[],
    recordsFilter:[],
    currentPage:1,
    recordsShow:3,
    filter:""
}

//Configuracion de eventos
eventListiners();
function eventListiners() {
    btnNew.addEventListener("click",agregarIngreso);
    btnCancelar.addEventListener("click",cancelarIngreso);
    //console.log("Antes de cargar");
    document.addEventListener("DOMContentLoaded",cargarDatos);
    //console.log("Despues de cargar");
    searchText.addEventListener("input",aplicarFiltro);
    FormIngreso.addEventListener("submit",guardarIngreso);
}


//Funciones
function guardarIngreso(event){
    event.preventDefault();
    const formData = new FormData(FormIngreso);
    //console.log(formData);
    API.post(formData,"ingresos/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success){
                cancelarIngreso();
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

function aplicarFiltro (element) {
    element.preventDefault();
    objDatos.filter=this.value;
    crearTabla();
}
function cargarDatos() {
    //console.log("Cargando datos");
    API.get("ingresos/getAll").then(
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
                const {id_ingreso,id_pagocontado,id_detalleplanpago}=item;
                if (id_ingreso.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
                    return item;
                }  
                if (id_pagocontado.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
                    return item;
                }              
                if (id_detalleplanpago.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
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
                html+=`<tr>
                    <td>${item.id_ingreso}</td>
                    <td>${item.id_pagocontado}</td>
                    <td>${item.id_detalleplanpago}</td>
                    <td>
                        <button type="button" class="btn btn-primary" onclick="editarIngreso(${item.id_ingreso})"><i class="bi bi-pencil-square"></i></button>
                        <button type="button" class="btn btn-danger" onclick="deleteIngreso(${item.id_ingreso})"><i class="bi bi-trash"></i></button>
                    </td>
                    </tr> `;
            }
        }
    );
    //console.log(html);
    tableContent.innerHTML=html;
    crearPaginacion(); 
}
function crearPaginacion(){
    //Borrar elementos
    pagination.innerHTML="";
    //Boton Anterior
    const elAnterior=document.createElement("li")
    elAnterior.classList.add("page-item");
    elAnterior.innerHTML=`<a class="page-link" href="#">Previous</a>`;
    elAnterior.onclick=()=>{
        objDatos.currentPage=(objDatos.currentPage==1 ? 1 : --objDatos.currentPage);
        crearTabla();
    }
    pagination.append(elAnterior);
    //Agregando los numeors de pagina
    const totalPage=Math.ceil(objDatos.recordsFilter.length/objDatos.recordsShow);
    for (let i=1; i<=totalPage; i++) {
        const el=document.createElement("li");
        el.classList.add("page=item");
        el.innerHTML=`<a class="page-link" href="#">${i}</a>`;
        el.onclick=()=> {
            objDatos.currentPage=i;
            crearTabla();
        }
        pagination.append(el);
    }
    //Bonton siguiente
    const elSiguiente=document.createElement("li");
    elSiguiente.classList.add("page-item");
    elSiguiente.innerHTML=`<a class="page-link" href="#">Next</a>`;
    elSiguiente.onclick=()=> {
        objDatos.currentPage=(objDatos.currentPage==totalPage ? totalPage : ++objDatos.currentPage);
        crearTabla();
    }
    pagination.append(elSiguiente);
}
function agregarIngreso() {
    panelDatos.classList.add("d-none");
    panelForm.classList.remove("d-none");
    limpiarForm();
}
function limpiarForm(op) {
    FormIngreso.reset();
    document.querySelector("#id_ingreso").value="0";
}
function cancelarIngreso() {
    panelDatos.classList.remove("d-none");
    panelForm.classList.add("d-none");
    cargarDatos();
}
function editarIngreso(id) {
    limpiarForm(1);
    panelDatos.classList.add("d-none");
    panelForm.classList.remove("d-none");
    API.get("ingresos/getOneIngreso?id="+id).then(
        data=>{
            if (data.success) {
                mostrarDatosForm(data.records[0]);
            } else {
                Swal.fire({
                    icon:"error",
                    title:"Error",
                    text:data.msg
                })
            }
        }
    ).catch(
        error=>{
            console.error("Error:",error);
        }
    );
}
function mostrarDatosForm(record) {
    const {id_ingreso, id_pagocontado, id_detalleplanpago}=record;
    document.querySelector("#id_ingreso").value=id_ingreso;
    document.querySelector("#id_pagocontado").value=id_pagocontado;
    document.querySelector("#id_detalleplanpago").value=id_detalleplanpago;
}

function deleteIngreso(id) {
    Swal.fire({
        title:"¿Esta seguro de eliminar el Ingreso?",
        showDenyButton:true,
        confirmButtonText:"Si",
        denyButtonText:"No"
    }).then(
        resultado=>{
            console.log(resultado.isConfirmed);
            if (resultado.isConfirmed){
                API.get("ingresos/deleteIngreso?id="+id).then(
                    data=>{
                        if (data.success) {
                            cancelarIngreso();
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
                        console.log("Error",error);
                    }
                );                
            }
        }
    ); 
    console.log("Mensaje de texto");
}