<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title> Astoil SRL - Comprobante salida </title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
</head>
<body>
  <div class="container-fluid">
    <!--header para cada pagina-->
    <div class="row">
      <small>Original</small> <br>
    </div>
    <div class="row">
      <h2> <?php echo $title ?> </h2>
    </div>
    <div class="row">
      <p><b>Fecha:</b> <?php echo date('d-m-Y');?></p>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                  <th>Centro de costos</th>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>KM/HS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                  <?php if ($p->cargar): ?>
                    <tr>
                        <td> <?php echo utf8_encode($p->cost_center_name) ?> </td>
                        <td> <?php echo utf8_encode($p->product_name) ?> </td>
                        <td> <?php echo $p->quantity ?> </td>
                        <td> <?php echo $p->km_hs ?> </td>
                    </tr>
                  <?php endif ?>
                <?php endforeach ?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td>En stock: </td>
                      <td><?php echo $stock_combustible ?></td>
                    </tr>
            </tbody>
        </table>

    </div>
    <br><br><br>
    <p> <strong>Observaciones: </strong> <?php echo utf8_encode( $output['comment'] ) ?> </p>
    <br> <br> <br>
    <table border="0" width="100%" >
      <tr width="50%">
        <td> ________________ </td>
      </tr>
      <tr width="50%">
        <td> Responsable </td>
      </tr>
    </table>
    </div>
  </div>
</body>


<body>
  <div class="container-fluid">
    <!--header para cada pagina-->
    <div class="row">
      <small>Duplicado</small> <br>
    </div>
    <div class="row">
      <h2> <?php echo $title ?> </h2>
    </div>
    <div class="row">
      <p><b>Fecha:</b> <?php echo date('d-m-Y');?></p>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                  <th>Centro de costos</th>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>KM/HS</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                  <?php if ($p->cargar): ?>
                    <tr>
                        <td> <?php echo utf8_encode($p->cost_center_name) ?> </td>
                        <td> <?php echo utf8_encode($p->product_name) ?> </td>
                        <td> <?php echo $p->quantity ?> </td>
                        <td> <?php echo $p->km_hs ?> </td>
                    </tr>
                  <?php endif ?>
                <?php endforeach ?>
                    <tr>
                      <td></td>
                      <td></td>
                      <td>En stock: </td>
                      <td><?php echo $stock_combustible ?></td>
                    </tr>
            </tbody>
        </table>
    </div>
    <br><br><br>
    <p> <strong>Observaciones: </strong> <?php echo utf8_encode( $output['comment'] ) ?> </p>
    <br> <br> <br>
    <table border="0" width="100%" >
      <tr width="50%">
        <td> ________________ </td>
      </tr>
      <tr width="50%">
        <td> Responsable </td>
      </tr>
    </table>
    </div>
  </div>
</body>


</html>
