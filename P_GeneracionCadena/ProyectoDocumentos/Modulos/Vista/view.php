<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Participantes</title>
</head>
<body>
    <h1>Participantes</h1>
    <div class="card mt-3">
    <div class="card-body">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Apellido Paterno</th>
            <th scope="col">Apellido Materno</th>
            <th scope="col">Nombre</th>
            <th scope="col">Evento</th>
            <th scope="col">Tipo Participante</th>
            <th scope="col">Fecha Inicio</th>
            <th scope="col">FechaTermino</th>
            <th scope="col">Instituto</th>
          </tr>
        </thead>
        <tbody>
          <?php $participantes = new DocumentoController(); ?>
          <?php foreach ($participantes->index() as $participante) : ?>
            <tr>
              <td><?php echo $participante['id']; ?></td>
              <td><?php echo $participante['Apellido_Paterno']; ?></td>
              <td><?php echo $participante['Apellido_Materno']; ?></td>
              <td><?php echo $participante['Nombres']; ?></td>
              <td><?php echo $participante['Evento']; ?></td>
              <td><?php echo $participante['Tipo_Participante']; ?></td>
              <td><?php echo $participante['fechaInicio']; ?></td>
              <td><?php echo $participante['fechaTermino']; ?></td>
              <td><?php echo $participante['Instituto']; ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>


 
  <div><?php $participantes->generar_pdf( $participantes->generar_qrcode($participantes->cifrar_datos($participantes->index()))); ?></div>
     
</body>
</html>