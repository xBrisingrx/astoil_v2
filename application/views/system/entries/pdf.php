<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset=utf-8">
    <title> Astoil SRL - Comprobante ingreso</title>
    <link rel="stylesheet" href="assets/vendor/bootstrap/bootstrap.min.css">
</head>
<body>
  <div class="container-fluid">
    <!--header para cada pagina-->
    <div class="row">
        <h2> <?php echo $title ?> </h2>
    </div>
    <?php if (isset($entry['factura_number']) && $entry['factura_number'] != ''): ?>
        <div class="row">
          <p>N&deg; <?php echo $type_entry[0]->name ?> : <?php echo utf8_encode( $entry['factura_number'] ) ?></p>
        </div>
    <?php endif ?>

    <div class="row">
            <p>Fecha: <?php echo date('d-m-Y');?></p>
    </div>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $p): ?>
                  <?php if ($p->cargar): ?>
                    <tr>
                        <td> <?php echo utf8_encode( $p->product_name ) ?> </td>
                        <td> <?php echo $p->quantity ?> </td>
                        <td> $ <?php echo $p->price ?> </td>
                    </tr>
                  <?php endif ?>
                <?php endforeach ?>
            </tbody>
            <tr>
              <td></td>
              <td></td>
              <td>
                Total : $ <?php echo $total; ?>
              </td>
            </tr>
        </table>

        <br><br><br>

    </div>
  </div>



</body>


</html>
