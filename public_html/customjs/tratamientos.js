//Variables globales y selectores
const btnNew=document.querySelector("#btnAgregar");
// Contenido del Nombre del Listado, Boton Agregar y Cuadro de busqueda
const panelDatos=document.querySelector("#contentList");
// Contenido de listado tablas
const panelDatos2=document.querySelector("#contentList2");
// Formulario
const panelForm=document.querySelector("#contentForm");
const btnCancelar=document.querySelector("#btnCancelar");
const tableContent=document.querySelector("#contentTable table tbody");
const searchText=document.querySelector("#txtSearch");
const pagination=document.querySelector(".pagination");
const FormTratamiento=document.querySelector("#FormTratamiento");
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
    btnNew.addEventListener("click",agregarTratamiento);
    btnCancelar.addEventListener("click",cancelarTratamiento);
    //console.log("Antes de cargar");
    document.addEventListener("DOMContentLoaded",cargarDatos);
    //console.log("Despues de cargar");
    searchText.addEventListener("input",aplicarFiltro);
    FormTratamiento.addEventListener("submit",guardarTratamiento);
}


//Funciones
function guardarTratamiento(event){
    event.preventDefault();
    const formData = new FormData(FormTratamiento);
    //console.log(formData);
    API.post(formData,"tratamientos/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success){
                cancelarTratamiento();
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
    API.get("tratamientos/getAll").then(
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
                const {id_tratamiento,nombre_tratamiento,descripcion_tratamiento}=item;
                if (id_tratamiento.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
                    return item;
                }  
                if (nombre_tratamiento.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
                    return item;
                }              
                if (descripcion_tratamiento.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
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
                    <td>${item.id_tratamiento}</td>
                    <td>${item.nombre_tratamiento}</td>
                    <td>${item.descripcion_tratamiento}</td>
                    <td>
                        <button class="editarbtn" type="button" onclick="editarTratamiento(${
                          item.id_tratamiento
                        })"><img src="public_html/iconos/edit.png" alt="x"/></button>
                        <button class="eliminarbtn" type="button" onclick="deleteTratamiento(${
                          item.id_tratamiento
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
function crearPaginacion(){
    //Borrar elementos
    pagination.innerHTML="";
    //Boton Anterior
    const elAnterior=document.createElement("li")
    elAnterior.classList.add("page-item");
    elAnterior.innerHTML=`<a class="page-link" href="#">Anterior</a>`;
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
    elSiguiente.innerHTML=`<a class="page-link" href="#">Siguiente</a>`;
    elSiguiente.onclick=()=> {
        objDatos.currentPage=(objDatos.currentPage==totalPage ? totalPage : ++objDatos.currentPage);
        crearTabla();
    }
    pagination.append(elSiguiente);
}
function agregarTratamiento() {
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelForm.classList.remove("d-none");
    limpiarForm();
}
function limpiarForm(op) {
    FormTratamiento.reset();
    document.querySelector("#id_tratamiento").value="0";
}
function cancelarTratamiento() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelForm.classList.add("d-none");
    cargarDatos();
}
function editarTratamiento(id) {
    limpiarForm(1);
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelForm.classList.remove("d-none");
    API.get("tratamientos/getOneTratamiento?id="+id).then(
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
    const {id_tratamiento, nombre_tratamiento, descripcion_tratamiento}=record;
    document.querySelector("#id_tratamiento").value=id_tratamiento;
    document.querySelector("#nombre_tratamiento").value=nombre_tratamiento;
    document.querySelector("#descripcion_tratamiento").value=descripcion_tratamiento;
}

function deleteTratamiento(id) {
    Swal.fire({
        title:"¿Esta seguro de eliminar el Tratamiento?",
        showDenyButton:true,
        confirmButtonText:"Si",
        denyButtonText:"No"
    }).then(
        resultado=>{
            console.log(resultado.isConfirmed);
            if (resultado.isConfirmed){
                API.get("tratamientos/deleteTratamiento?id="+id).then(
                    data=>{
                        if (data.success) {
                            cancelarTratamiento();
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
