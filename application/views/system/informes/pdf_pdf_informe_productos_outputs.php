<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset=utf-8">
    <title> Astoil SRL - Informe</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
</head>
<body>
  <div class="container-fluid">
    <div class="row text-center">
      <img src="assets/img/logo.png" width="150" alt="Logo">
    </div>


    <div class="row text-center">
        <p>Informe de gastos del centro de costos <b><?php echo $cost_center ?></b> en el periodo de <?php echo $desde ?> hasta <?php echo $hasta ?></p>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto </th>
                    <th>Cantidad</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                    <tr>
                        <td> <?php echo utf8_encode( $p->name ) ?> </td>
                        <td> <?php echo $p->cantidad ?> </td>
                    </tr>
                <?php endforeach ?>
                    <tr bgcolor="#d8cbcb">
                      <td> <b>Costo acumulado:</b> </td>
                      <td> $ <?php echo $total ?> </td>
                    </tr>
            </tbody>
        </table>

        <br><br><br>

    </div>
  </div>



</body>


</html>
