
//botonPDF
let btnPdf = document.querySelector("#btnPDF");


//Función para consumir la api en el recurso eventos participantes
async function consume_participantes_evento() {
    try{
        const response = await fetch(`http://eventos.itchetumal.edu.mx:8080/participante-evento`);
        const data = await response.json();
        for(let i = 0; i<data.length; i++){
            get_participantes_evento(data[i]);
        }
    }catch(error){
        console.error("error aqui" + error);
    }  
}

//Función que consume el recurso de la api documento participacion
async function genera_documento_participacion(opciones) {
    try{
        const response = await fetch(`http://eventos.itchetumal.edu.mx:8080/documentos`, opciones);
        const data = await response.json();
        console.log(data);
    }catch(error){
        console.error("error: " + error);
    }  
}





//Función que mete los registros en la tabla
function get_participantes_evento(participantes){
    let etiqueta_tbody = document.querySelector("tbody");
    
    let fila = document.createElement('tr');
    
    //celda ID
    let celdaID = document.createElement('td');
    celdaID.textContent = participantes.id;
    fila.appendChild(celdaID);

    //celda apellido paterno
    let celdaPaterno = document.createElement('td');
    celdaPaterno.textContent = participantes.apellidoPaterno;
    fila.appendChild(celdaPaterno);
         
    //celda apellido materno
    let celdaMaterno = document.createElement('td');
    celdaMaterno.textContent = participantes.apellidoMaterno;
    fila.appendChild(celdaMaterno);

    //celda nombres
    let celdaNombres = document.createElement('td');
    celdaNombres.textContent = participantes.nombres;
    fila.appendChild(celdaNombres);

    //celda eventos
    let celdaEvento = document.createElement('td');
    celdaEvento.textContent = participantes.Evento;
    fila.appendChild(celdaEvento);

    //celda descripcion del evento
    let celdaDescripcionEvento = document.createElement('td');
    celdaDescripcionEvento.textContent = participantes.descripcion;
    fila.appendChild(celdaDescripcionEvento);
        

    //celda tipo participante
    let celdaTipoParticipante = document.createElement('td');
    celdaTipoParticipante.textContent = participantes.tipo;
    fila.appendChild(celdaTipoParticipante);

    //celda fecha término evento
    let celdaFechaTermino = document.createElement('td');
    celdaFechaTermino.textContent = participantes.fechaTermino;
    fila.appendChild(celdaFechaTermino);


    


    //evento que hara hara la generación del documento
    btnPdf.addEventListener('click', function() {

        let apellidoPat = celdaPaterno.innerHTML;
        let apellidoMat = celdaMaterno.innerHTML;
        let nombres = celdaNombres.innerHTML;
        let evento = celdaEvento.innerHTML;
        let descripcionEvento = celdaDescripcionEvento.innerHTML;
        let tipoParticipante = celdaTipoParticipante.innerHTML;
        let fechaTermino = celdaFechaTermino.innerHTML;

        const registro_participante = {
            ApellidoPaterno:apellidoPat,
            ApellidoMaterno:apellidoMat,
            Nombres:nombres,
            Evento:evento,
            Descripcion:descripcionEvento,
            TipoParticipante:tipoParticipante,
            FechaTermino:fechaTermino
        };

        const opciones = {
            method: 'POST',
            headers: {
                'Authorization':'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpZCI6MjMsIm5vbWJyZXMiOiJCZW5qYW1pbiIsInRlbGVmb25vIjoiOTgzMDAxOTA4MiIsImNvcnJlbyI6ImJlbjEwQGdtYWlsLmNvbSJ9.FMtm_O3EKkQkylL7Pc2INOHc7Tq_sA6Kq4Hv03mDFDM'
            },
            body: JSON.stringify(registro_participante)
        };
            genera_documento_participacion(opciones);

        Swal.fire({
            title: 'Generados!',
            text: 'Los documentos de participación han sido generados',
            icon: 'success',
            confirmButtonText: 'Ok'
        })

    });

        etiqueta_tbody.appendChild(fila);

       
}


consume_participantes_evento();