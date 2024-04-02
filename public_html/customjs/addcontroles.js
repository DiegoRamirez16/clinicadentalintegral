//Variables globales y selectores
const idexp=document.querySelector("#id_expediente");
const formControlClinico = document.querySelector("#formControlClinico");
const btnCancelar = document.querySelector("#btnCancelar");
const API = new Api();
//Configuracion de eventos
eventListiners();

function eventListiners() {
  btnCancelar.addEventListener("click", cancelarControlClinico);
  document.addEventListener("DOMContentLoaded", cargarDatos);

  formControlClinico.addEventListener("submit", guardarControlClinico);
}

//Funciones

function cargarDatos() {
  idexp.value = idexpediente;
  cargarTratamientos();
  //console.log("Cargando datos");
  //src="<?php echo URL;?>public_html/iconos/arrowdown.png"
  API.get("addcontroles/getNameExpe")
    .then((data) => {
      //console.log(data.records);
      if (data.success) {
        cargarTratamientos();
        document.getElementById("namepaciente").innerHTML = data.name;
      } else {
        console.log("Error al recuperar los registros");
      }
    })
    .catch((error) => {
      console.error("Error en la llamada:", error);
    });
}

function cancelarControlClinico() {
  location.href = "/clinicadentalintegral/expedientes";
}

function guardarControlClinico(event) {
  event.preventDefault();
  const formData = new FormData(formControlClinico);
  //console.log(formData);
  API.post(formData, "/controlesclinico/save")
    .then((data) => {
      //console.log(data.msg);
      if (data.success) {
        cancelarControlClinico();
        Swal.fire({
          icon: "info",
          text: data.msg,
        });
      } else {
        Swal.fire({
          icon: "error",
          title: "Error",
          text: data.msg,
        });
      }
    })
    .catch((error) => {
      console.log("Error:", error);
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