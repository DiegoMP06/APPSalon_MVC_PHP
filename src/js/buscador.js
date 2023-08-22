document.addEventListener("DOMContentLoaded", () => {
    iniciarApp();
});

function iniciarApp(){
    buscarPorFecha();
}

function buscarPorFecha(){
    const fechaInput = document.querySelector("#fecha");
    const buscarInput = document.querySelector("#buscar");

    buscarInput.addEventListener("click", e => {
        const fechaSeleccionada = fechaInput.value;
        window.location = `?fecha=${fechaSeleccionada}`;
    });
}
