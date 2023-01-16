(function(){ //IIFE = PARA ENCERRAR VARIABLES EN ESTE ARCHIVO Y NO PUEDA LEERSE EN OTROS

    obtenerTareas();
    let tareas = [];
    
    
    //Boton para mostrar el modal de Agregar Tarea
    const nuevaTareaBtn = document.querySelector('#agregar-tarea'); //Selecciono el boton
    nuevaTareaBtn.addEventListener('click', function(){
        mostrarFormulario();
    });


    async function obtenerTareas(){
        try {
            const id = obtenerProyecto();
            const url = `/api/tareas?id=${id}`;
            const respuesta = await fetch(url);
            const resultado = await respuesta.json();
            
            tareas = resultado.tareas;
            mostrarTareas();
        } catch (error) {
            console.log(error);
        }
    }

    function mostrarTareas() {
        limpiarTareas();
        if (tareas.length === 0) { //Si no hay tareas 
            const contenedorTareas = document.querySelector('#listado-tareas');
            const textoNoTareas = document.createElement('LI');
            textoNoTareas.textContent = 'No tasks';
            textoNoTareas.classList.add('no-tareas');
            contenedorTareas.appendChild(textoNoTareas);
            return;
        }

        const estados = {
            0: 'Pending',
            1: 'Complete'
        }

        tareas.forEach(tarea => { //Si hay tareas itero sobre ellas y las muestro
            const contenedorTarea = document.createElement('LI');
            contenedorTarea.dataset.tareaId = tarea.id;
            contenedorTarea.classList.add('tarea');

            const nombreTarea = document.createElement('P');
            nombreTarea.textContent = tarea.nombre;
            nombreTarea.ondblclick = function() { //Para cambiar el nombre de la tarea
                mostrarFormulario(editar = true, {...tarea});
            }

            const opcionesDiv = document.createElement('DIV');
            opcionesDiv.classList.add('opciones');

            //Botones 
            const btnEstadoTarea = document.createElement('BUTTON');
            btnEstadoTarea.classList.add('estado-tarea');
            btnEstadoTarea.classList.add(`${estados[tarea.estado].toLowerCase()}`)
            btnEstadoTarea.textContent = estados[tarea.estado];
            btnEstadoTarea.dataset.estadoTarea = tarea.estado;
            btnEstadoTarea.ondblclick = function() {
                cambiarEstadoTarea({...tarea});
            }

            const btnEliminarTarea = document.createElement('BUTTON');
            btnEliminarTarea.classList.add('eliminar-tarea');
            btnEliminarTarea.dataset.idTarea = tarea.id;
            btnEliminarTarea.textContent = 'Delete';
            btnEliminarTarea.ondblclick =  function(){
                cofirmarEliminarTarea({...tarea});
            }

            opcionesDiv.appendChild(btnEstadoTarea); // Agrego el boton
            opcionesDiv.appendChild(btnEliminarTarea); 

            contenedorTarea.appendChild(nombreTarea);
            contenedorTarea.appendChild(opcionesDiv);

            const listadoTareas = document.querySelector('#listado-tareas');
            listadoTareas.appendChild(contenedorTarea);
        });
    }




    function mostrarFormulario(editar = false, tarea = {}) {
        const modal = document.createElement('DIV'); //Creo un div cuando apretan Nueva Tarea = modal
        modal.classList.add('modal');
        //Agrego contenido al DIV creado de Nueva Tarea, con template string
        modal.innerHTML = `   
        <form class="formulario nueva-tarea">
            <legend>${editar ? 'Edit task' : 'Add a new task'} </legend>
                <div class="campo">
                    <label>Task</label>
                    <input
                    type="text"
                    name="tarea"
                    placeholder= "${tarea.nombre ? 'Edit the task' : 'Add a new task to project' } "
                    id="tarea"
                    value= "${tarea.nombre ? tarea.nombre : '' }"
                    />
                </div>
                <div class="opciones">
                    <input 
                    type="submit" 
                    class="submit-nueva-tarea" 
                    value="${tarea.nombre ? 'Save changes' : 'Add a new task'}"/>
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
                }, 100);
            }
            if (e.target.classList.contains('submit-nueva-tarea')) {
                const nombreTarea = document.querySelector('#tarea').value.trim(); // El nombre que el usuario le de a la nueva tarea

                if (nombreTarea === '') {
                    //Mostrar alerta de error 
                    mostrarAlerta('The name of task is required', 'error', document.querySelector('.formulario legend'));
                    return;
                }

                if (editar) { //Si editar = true 
                    tarea.nombre = nombreTarea;
                    actualizarTarea(tarea);
                } else { //Si editar = false, significa que estoy agregando tarea
                    agregarTarea(nombreTarea);
                }

            }
        })

        document.querySelector('.dashboard').appendChild(modal); //Agrego el div(modal) al body
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

            mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector('.formulario legend'));

            if (resultado.tipo === 'exito') {
                const modal = document.querySelector('.modal');
                setTimeout(() => {
                    modal.remove();
                }, 1000);   

                //Agregar el objeto de tarea al global de tareas
                const tareaObj = {
                    id: String(resultado.id),
                    nombre: tarea,
                    estado: "0",
                    proyectoId: resultado.proyectoId
                } 

                tareas = [...tareas, tareaObj];
                mostrarTareas();
            }
        } catch (error) {
            console.log(error);
        }
    }

    function cambiarEstadoTarea(tarea){
        const nuevoEstado = tarea.estado === "1" ? "0" : "1"; //Cambia el estado cuando se ejectua la funcion
        tarea.estado = nuevoEstado;
        actualizarTarea(tarea);
    }

    async function actualizarTarea(tarea){
        const {estado, id, nombre, proyectoId} = tarea;
        
        const datos = new FormData();
        datos.append('id',id);
        datos.append('nombre',nombre);
        datos.append('estado',estado);
        datos.append('proyectoId',obtenerProyecto());

        try {
            const url = 'http://localhost:3000/api/tarea/actualizar';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });
            const resultado = await respuesta.json();

            if (resultado.respuesta.tipo === 'exito'){
                mostrarAlerta(resultado.respuesta.mensaje,resultado.respuesta.tipo,document.querySelector('.contenedor-nueva-tarea'));
            };
            
            tareas = tareas.map(tareaMemoria => { //Cambiando el Estado de la tarea en el VirtualDOM
                if (tareaMemoria.id === id) {
                    tareaMemoria.estado = estado;
                }

                return tareaMemoria;
            });

            mostrarTareas();
        
        } catch (error) {
            console.log(error);
        }

    }

    function cofirmarEliminarTarea(tarea) { 
        Swal.fire({
            title: 'Delete task ?',
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: `No`,
          }).then((result) => {
            if (result.isConfirmed) {
               eliminarTarea(tarea);
            }
        })
    }


    async function eliminarTarea(tarea) {

        const {estado, id, nombre} = tarea;
        
        const datos = new FormData();
        datos.append('id',id);
        datos.append('nombre',nombre);
        datos.append('estado',estado);
        datos.append('proyectoId',obtenerProyecto());

        try {

            const url = 'http://localhost:3000/api/tarea/eliminar';
            const respuesta = await fetch(url, {
                method: 'POST',
                body: datos
            });

            const resultado = await respuesta.json();

            if (resultado.resultado) {
            //     mostrarAlerta(resultado.mensaje, 
            //         resultado.tipo,
            //         document.querySelector('.contenedor-nueva-tarea'));

            Swal.fire('Removed!', resultado.mensaje, 'success');



            tareas = tareas.filter(tareaMemoria => tareaMemoria.id !== tarea.id); //Elimina las tareas en el DOM, porque trae todas los que no elimine

            mostrarTareas(); //Muestro para actualizar el DOM con las tareas eliminadas
            }
         } catch (error) {
            
        }
    }

    function obtenerProyecto(){ //Lee la url y retorna el ID del proyecto
        const proyectoParams = new URLSearchParams(window.location.search);
        const proyecto = Object.fromEntries(proyectoParams.entries());
        return proyecto.id;
    }

    function limpiarTareas(){
        const listadoTareas = document.querySelector('#listado-tareas');
        
        while (listadoTareas.firstChild) {
            listadoTareas.removeChild(listadoTareas.firstChild);
        }
    }
})();

