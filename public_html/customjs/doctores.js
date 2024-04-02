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
const FormDoctor=document.querySelector("#FormDoctor");
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
    btnNew.addEventListener("click",agregarDoctor);
    btnCancelar.addEventListener("click",cancelarDoctor);
    //console.log("Antes de cargar");
    document.addEventListener("DOMContentLoaded",cargarDatos);
    //console.log("Despues de cargar");
    searchText.addEventListener("input",aplicarFiltro);
    FormDoctor.addEventListener("submit",guardarDoctor);
}


//Funciones
function guardarDoctor(event){
    event.preventDefault();
    const formData = new FormData(FormDoctor);
    //console.log(formData);
    API.post(formData,"doctores/save").then(
        data=>{
            //console.log(data.msg);
            if (data.success){
                cancelarDoctor();
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
    API.get("doctores/getAll").then(
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
                const {id_doctor,nombre_doctor,apellido_doctor}=item;
                if (id_doctor.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
                    return item;
                }  
                if (nombre_doctor.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
                    return item;
                }              
                if (apellido_doctor.toUpperCase().search(objDatos.filter.toLocaleUpperCase())!=-1){
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
                    <td>${item.id_doctor}</td>
                    <td>${item.nombre_doctor}</td>
                    <td>${item.apellido_doctor}</td>
                    <td>
                        <button class="editarbtn" type="button" onclick="editarDoctor(${
                          item.id_doctor
                        })"><img src="public_html/iconos/edit.png" alt="x"/></button>
                        <button class="eliminarbtn" type="button" onclick="deleteDoctor(${
                          item.id_doctor
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
function agregarDoctor() {
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelForm.classList.remove("d-none");
    limpiarForm();
}
function limpiarForm(op) {
    FormDoctor.reset();
    document.querySelector("#id_doctor").value="0";
}
function cancelarDoctor() {
    panelDatos.classList.remove("d-none");
    panelDatos2.classList.remove("d-none");
    panelForm.classList.add("d-none");
    cargarDatos();
}
function editarDoctor(id) {
    limpiarForm(1);
    panelDatos.classList.add("d-none");
    panelDatos2.classList.add("d-none");
    panelForm.classList.remove("d-none");
    API.get("doctores/getOneDoctor?id="+id).then(
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
    const {id_doctor, nombre_doctor, apellido_doctor}=record;
    document.querySelector("#id_doctor").value=id_doctor;
    document.querySelector("#nombre_doctor").value=nombre_doctor;
    document.querySelector("#apellido_doctor").value=apellido_doctor;
}

function deleteDoctor(id) {
    Swal.fire({
        title:"¿Esta seguro de eliminar el Tratamiento?",
        showDenyButton:true,
        confirmButtonText:"Si",
        denyButtonText:"No"
    }).then(
        resultado=>{
            console.log(resultado.isConfirmed);
            if (resultado.isConfirmed){
                API.get("doctores/deleteDoctor?id="+id).then(
                    data=>{
                        if (data.success) {
                            cancelarDoctor();
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