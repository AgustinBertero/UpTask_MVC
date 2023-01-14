
(function(){ //IIFE = PARA ENCERRAR VARIABLES EN ESTE ARCHIVO Y NO PUEDA LEERSE EN OTROS
    //Boton para mostrar el modal de Agregar Tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea'); //Selecciono el boton
    nuevaTareaBtn.addEventListener('click', mostrarFormulario);

    function mostrarFormulario() {
        const modal = document.createElement('DIV'); //Creo un div cuando apretan Nueva Tarea = modal
        modal.classList.add('modal');
        //Agrego contenido al DIV creado de Nueva Tarea, con template string
        modal.innerHTML = `   
        <form class="formulario nueva-tarea">
            <legend> Add a new task </legend>
                <div class="campo">
                    <label>Task</label>
                    <input
                    type="text"
                    name="tarea"
                    placeholder="Add a new task to project"
                    id="tarea"
                    />
                </div>
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="Add Task"/>
                    <button type="button" class="cerrar-modal">Cancel</button>
                </div>
        </form> 
        `;

        setTimeout(() => { //Animacion al modal
            const formulario =  document.querySelector('.formulario');
            formulario.classList.add('animar');
        }, 0);

        document.querySelector('body').appendChild(modal); //Agrego el div(modal) al body
    }


})();

