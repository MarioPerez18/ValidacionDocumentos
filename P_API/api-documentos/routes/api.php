<?php

use Rutas\Ruta;
use controlador\ParticipantController;
use controlador\InstitutionController;
use controlador\EventParticipantController;
use controlador\DocumentController;




Ruta::get('/participantes', [ParticipantController::class, 'index']);

Ruta::post('/participantes', [ParticipantController::class, 'store']);

Ruta::get('/participante-evento', [EventParticipantController::class, 'index']);

Ruta::get('/instituciones', [InstitutionController::class, 'index']);

Ruta::get('/validacion/:cadena/:iv', [DocumentController::class, 'decifrado']);

Ruta::post('/documentos', [DocumentController::class, 'store']);





Ruta::dispatch(); 


