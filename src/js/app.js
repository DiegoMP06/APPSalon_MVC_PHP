let paso = 1;

const pasoInicial = 1;
const pasoFinal = 3;

const cita = {
    id: "",
    nombre: "",
    fecha: "",
    hora: "",
    servicios: []
}

document.addEventListener("DOMContentLoaded", () => {
    iniciarApp();
});

function iniciarApp() {
    // Muestra y Oculta las Secciones
    mostrarSeccion();
    // Cambia la Seccion Cuando se Presionan los Tabs
    tabs();
    // Agrega o Quita los Botones del Paginador
    botonesPaginador();

    paginaSiguiente();
    paginaAnterior();

    // Consulta la API en el Backend
    consultarAPI();
    idCliente();
    // Añade el Nombre del Cliente al Objeto de Cita
    nombreCliente();

    // Añade la Fecha de la cita
    seleccionarFecha();
    // Añade la hora de la cita
    seleccionarHora();

    // Muestra EL Resumen De La cita
    mostrarResumen();
}


function mostrarSeccion() {
    // Ocultar la seccion que tenga la clase de mostrar
    const seccionAnterior = document.querySelector(".mostrar");
    if (seccionAnterior) {
        seccionAnterior.classList.remove("mostrar");
    }

    // Seleccionar la seccion con el paso
    const seccion = document.querySelector(`#paso-${paso}`);
    // console.log(seccion);
    seccion.classList.add("mostrar");

    // Quita la clase de actual
    const tabAnterior = document.querySelector(".actual");
    if (tabAnterior) {
        tabAnterior.classList.remove("actual");
    }

    // Resalta el tab actual
    const tab = document.querySelector(`[data-paso="${paso}"]`);
    tab.classList.add("actual");
}

function tabs() {
    const botones = document.querySelectorAll(".tabs button");

    botones.forEach(boton => {
        boton.addEventListener("click", e => {
            paso = parseInt(e.target.dataset.paso);
            botonesPaginador();
        });
    });
}

function botonesPaginador() {
    const paginaAnterior = document.querySelector("#anterior");
    const paginaSiguiente = document.querySelector("#siguiente");

    if (paso === 1) {
        paginaAnterior.classList.add("ocultar");
        paginaSiguiente.classList.remove("ocultar");
    } else if (paso === 3) {
        paginaAnterior.classList.remove("ocultar");
        paginaSiguiente.classList.add("ocultar");
        mostrarResumen();
    } else {
        paginaAnterior.classList.remove("ocultar");
        paginaSiguiente.classList.remove("ocultar");
    }

    mostrarSeccion();
}

function paginaAnterior() {
    const paginaAnterior = document.querySelector("#anterior");

    paginaAnterior.addEventListener("click", () => {
        if (paso <= pasoInicial) return;
        paso--;
        botonesPaginador();
    });
}

function paginaSiguiente() {
    const paginaSiguiente = document.querySelector("#siguiente");

    paginaSiguiente.addEventListener("click", () => {
        if (paso >= pasoFinal) return;
        paso++;
        botonesPaginador();
    });
}

async function consultarAPI(){
    try {
        const url = "/api/servicios";

        const resultado = await fetch(url);
        const servicios = await resultado.json();

        mostrarServicios(servicios);
    } catch (error) {
        console.log(error);
    }
}

function mostrarServicios(servicios){

    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio;

        const nombreServicio = document.createElement("P");
        nombreServicio.classList.add("nombre-servicio");
        nombreServicio.textContent = nombre;

        const precioServicio = document.createElement("P");
        precioServicio.classList.add("precio-servicio");
        precioServicio.textContent = `$${precio}`;

        const servicioDiv = document.createElement("DIV");
        servicioDiv.classList.add("servicio");
        servicioDiv.dataset.idServicio = id;
        servicioDiv.onclick = () => {
            seleccionarServicio(servicio);
        }

        servicioDiv.appendChild(nombreServicio);
        servicioDiv.appendChild(precioServicio);

        document.querySelector("#servicios").appendChild(servicioDiv);
    });
}

function seleccionarServicio(servicio){
    const {id} = servicio;
    const {servicios} = cita;
    const divServicio = document.querySelector(`[data-id-servicio="${id}"]`);

    // Comprobarsi un servicio ya fue agregado
    if(servicios.some(agregado => agregado.id === id)){
    cita.servicios = servicios.filter(agregado => agregado.id !== id);
    divServicio.classList.remove("seleccionado");
    }else{
        cita.servicios = [...servicios, servicio];
        divServicio.classList.add("seleccionado");
    }
}

function idCliente(){
    const id = document.querySelector("#id").value;
    cita.id = id;
}

function nombreCliente(){
    const nombre = document.querySelector("#nombre").value;
    cita.nombre = nombre;
}

function seleccionarFecha(){
    const inputFecha = document.querySelector("#fecha");

    inputFecha.addEventListener("input", e => {

        const dia = new Date(e.target.value).getUTCDay();

        if([6, 0].includes(dia)){
            e.target.value = "";

            mostraAlerta("Fines de Semana no Permitidos", "error", ".formulario");
        }else{
            cita.fecha = e.target.value;
        }
    })
}

function seleccionarHora(){
    const inputHora = document.querySelector("#hora");

    inputHora.addEventListener("input", e => {
        const horaCita = e.target.value;
        const hora = horaCita.split(":")[0];

        if(hora < 10 || hora > 18){
            e.target.value = "";

            mostraAlerta("Hora no Valida", "error", ".formulario");
        }else{
            cita.hora = e.target.value;
        }
    });
}

function mostraAlerta(mensaje, tipo, elemento, desaparece = true){

    const alertaAnterior = document.querySelector(`.alerta.${tipo}`);
    if(alertaAnterior){
        alertaAnterior.remove();
    }

    const alerta = document.createElement("DIV");

    alerta.textContent = mensaje;
    alerta.classList.add("alerta");
    alerta.classList.add(tipo);

    const referencia = document.querySelector(elemento);
    referencia.appendChild(alerta);

    if(desaparece){
        setTimeout(() => {
            alerta.remove();
        }, 3000);
    }
}

function mostrarResumen(){
    const resumen = document.querySelector(".contenido-resumen");

    // Limpiar el Contenido de Resumen
    while(resumen.firstChild){
        resumen.removeChild(resumen.firstChild);
    }

    if(Object.values(cita).includes("") || cita.servicios.length === 0){
        mostraAlerta("Faltan Datos de Servicios, Fecha u Hora", "error", ".contenido-resumen",false);
        return;
    }

    const {nombre, fecha,  hora, servicios} = cita;

    // Heading de Resumen
    const headingServicios = document.createElement("H3");
    headingServicios.textContent = "Resumen De Servicios";
    resumen.appendChild(headingServicios);
    
    servicios.forEach(servicio => {
        const {id, nombre, precio} = servicio;

        const contenedorServicio = document.createElement("DIV");
        contenedorServicio.classList.add("contenedor-servicio");

        const textoServicio = document.createElement("P");
        textoServicio.textContent = nombre;
        
        const precioServicio = document.createElement("P");
        precioServicio.innerHTML = `<span>Precio: </span> $${precio}`;
        
        contenedorServicio.appendChild(textoServicio);
        contenedorServicio.appendChild(precioServicio);
        
        resumen.appendChild(contenedorServicio);
    });
    
    const headingCita = document.createElement("H3");
    headingCita.textContent = "Resumen Cita";
    resumen.appendChild(headingCita);
    
    const nombreCliente = document.createElement("P");
    nombreCliente.innerHTML = `<span>Nombre: </span> ${nombre}`;

    // Formatear Fecha
    const fechaObj =  new Date(fecha);
    const mes = fechaObj.getMonth();
    const dia = fechaObj.getDate()+2;
    const year = fechaObj.getFullYear();

    const fechaUTC = new Date(Date.UTC(year, mes, dia));

    const opciones = {
        weekday: "long",
        year: "numeric",
        month: "long",
        day: "numeric"
    }
    
    const fechaFormateada = fechaUTC.toLocaleDateString("es-MX", opciones);

    const fechaCita = document.createElement("P");
    fechaCita.innerHTML = `<span>Fecha: </span> ${fechaFormateada}`;

    const horaCita = document.createElement("P");
    horaCita.innerHTML = `<span>Hora: </span> ${hora} Horas`;

    // Boton para Crear una Cita
    const botonReservar = document.createElement("BUTTON");
    botonReservar.classList.add("boton");
    botonReservar.textContent = "Reservar Cita";
    botonReservar.onclick = reservarCita;

    resumen.appendChild(nombreCliente);
    resumen.appendChild(fechaCita);
    resumen.appendChild(horaCita);
    resumen.appendChild(botonReservar);
}

async function reservarCita(){
    const {id, fecha, hora, servicios} = cita;
    const idServicios = servicios.map(servicio => servicio.id);
    const datos = new FormData();

    datos.append("fecha", fecha);
    datos.append("hora", hora);
    datos.append("usuarioId", id);
    datos.append("servicios", idServicios);

    try {
        // Peticion Hacia la URL
        const url = `/api/citas`;
    
        const respuesta = await fetch(url, {
            method: "POST", 
            body: datos
        });
        const resultado = await respuesta.json();

        if(resultado.resultado){
            Swal.fire({
                icon: 'success',
                title: 'Cita Creada',
                text: 'Tu Cita fue Creada Correctamente',
                button: "Ok"
            }).then(() => {
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            });
        }
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'Error al Crear la Cita',
            button: "Ok"
        })
        console.log(error)
    }

}

