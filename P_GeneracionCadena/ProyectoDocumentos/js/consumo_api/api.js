

//recursos

let participantes = "ParticipantController.php";


//elementos HTML
let paterno = document.querySelector("#inputApellidoPaterno");
let materno = document.querySelector("#inputApellidoMaterno");
let nombres_persona = document.querySelector("#inputNombres");
let genero_persona = document.querySelector("#inputGenero");
let telefono_persona = document.querySelector("#inputTelefono");
let correo_persona = document.querySelector("#inputCorreo");
let btn = document.querySelector("#btn");

//Función para consumir la api en el recurso institutos
async function consume_api() {
    try{
        const response = await fetch(`http://eventos.itchetumal.edu.mx:8080/instituciones`);
        const data = await response.json();
        get_instituciones(data);
    }catch(error){
        console.error("error" + error);
    }  
}



//consume endpoint participants
async function ingresa_registro(opciones){
    try{
        const response = await fetch(`http://eventos.itchetumal.edu.mx:8080/participantes`, opciones);
        const data = await response.json();
        console.log(data);
        alert("Te has registrado");
    }catch(error){
        console.error("error" + error);
    }  
}

//Función que trae todos los institutos para mostrarlos y luego extraer el id del instituto elegido.
function get_instituciones(instituciones){
    let select = document.getElementById('inputInstitucion');
    let opcionSeleccionada;
    instituciones.forEach(instituto => {
        const opcion = document.createElement('option');
        //valor de cada opcion
        opcion.value = instituto.id; 
        //lo que se le mostrará al usuario
        opcion.textContent = instituto.nombreCorto + " - " + instituto.nombreLargo;
        select.appendChild(opcion);
        //console.log(instituto);
    
    });

    select.addEventListener('change', function() {
        //se busca el instituto que el usuario eligió mediante la comparacion de los IDs.
        opcionSeleccionada = instituciones.find(instituto => instituto.id === parseInt(this.value));
        post(opcionSeleccionada.id);
    });  
} 


    
//Función para realizar la petición
function post(id_institucion){
    //console.log("el numero es: " + id_institucion);
    let registro;
    btn.addEventListener("click", function(){
        registro = {
            apellidoPaterno:paterno.value,
            apellidoMaterno:materno.value,
            nombres:nombres_persona.value,
            genero:genero_persona.value,
            telefono:telefono_persona.value,
            correo:correo_persona.value,
            institucion:id_institucion,
        };
        
        const opciones = {
            method: 'POST',
            
            body: JSON.stringify(registro)
        };
        ingresa_registro(opciones);
    });
}





consume_api();



