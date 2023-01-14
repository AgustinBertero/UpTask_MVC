
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

        modal.addEventListener('click',function(e){
            e.preventDefault(); //No permite que se ejecute la funcion por default

            if (e.target.classList.contains('cerrar-modal')) { //Click boton cancel .cerrar-modal
                const formulario =  document.querySelector('.formulario');
                formulario.classList.add('cerrar'); //Class para animar con css
                setTimeout(() => { //Animacion
                    modal.remove(); //Elimino la ventana modal
                }, 500);
            }
            if (e.target.classList.contains('submit-nueva-tarea')) {
                submitFormularioNuevaTarea();
            }
        })

        document.querySelector('.dashboard').appendChild(modal); //Agrego el div(modal) al body
    }

    function submitFormularioNuevaTarea() {
        const tarea = document.querySelector('#tarea').value.trim(); // El nombre que el usuario le de a la nueva tarea

        if (tarea === '') {
            //Mostrar alerta de error 
            mostrarAlerta('The name of task is required', 'error', document.querySelector('.formulario legend'));
            return;
        }

        agregarTarea(tarea);
    }

    //Muestra mensaje en la interfaz
    function mostrarAlerta(mensaje, tipo, referencia){
        //Prevenir la creacion de multiples alertas 
        const alertaPrevia = document.querySelector('.alerta');
        if (alertaPrevia) {
            alertaPrevia.remove();
        }


        const alerta =  document.createElement('DIV');  
        alerta.classList.add('alerta', tipo);
        alerta.textContent = mensaje;
        referencia.appendChild(alerta);

        //Inserta la alerta antes del legend
        referencia.parentElement.insertBefore(alerta, referencia.nextElementSibling);

        //Eliminar la alerta despues de 5 segundos 
        setTimeout(() => {
            alerta.remove();
        }, 5000);
    }

    //Consultar el servidor para añadir una nueva tarea al proyecto actual 
    async function agregarTarea(tarea) {
        //Construir la peticion
        const datos = new FormData();
        datos.append('nombre', tarea);
        datos.append('proyectoId', obtenerProyecto()); //Leemos la url y la agregamos al FormData 

    

        try {
            const url = 'http://localhost:3000/api/tarea';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
           
            const resultado = await respuesta.json();
            console.log(resultado);

            mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'));

        } catch (error) {
            console.log(error);
        }
    }

    function obtenerProyecto(){ //Lee la url y retorna el ID del proyecto
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;
    }
})();

