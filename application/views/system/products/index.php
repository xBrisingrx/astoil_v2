<section class="container-fluid g-py-10">
  <h1>Productos</h1>

<?php if ($this->session->userdata('rol') == 1 ): ?>
  <button class="btn btn-primary justify-content-end margin_bottom g-mb-10 g-mr-20" onclick="create_product()"> <i class="fa fa-plus"></i> Nuevo </button>
<?php endif ?>

  <button type="button" class="btn btn-info margin_bottom g-mb-10 g-mr-20" data-toggle="modal" data-target="#modal_descargar_excel">
  Descargar Excel
  </button>

  <!-- Hover Rows -->
  <div class="card g-brd-teal rounded-0 g-mb-30" >
    <h3 class="card-header g-bg-teal g-brd-transparent g-color-white g-font-size-16 rounded-0 mb-0">
      <i class="fa fa-gear g-mr-5"></i>
      Listado de productos registrados
    </h3>

    <div class="table-responsive">
      <table id="products_table" class="table table-striped table-hover u-table--v1 margin-tables">
        <thead>
          <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Rubro</th>
            <th>Descripción</th>
            <th>Precio</th>
            <th>En stock</th>
            <th>Stock mín</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
          <!-- Completo con ajax -->
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <!-- End Hover Rows -->
</section>


<!-- Modal con form para crear/editar productos -->
<div class="modal fade" id="modal_products" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_products" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">

          <!-- ID product -->
            <input type="hidden" name="product_id" id="product_id" value="">

          <!-- Select rubro -->
          <div class="form-group row g-mb-5">
            <label class="mr-sm-3 mb-3 mb-lg-0 col-sm-2" for="rubro_id">Rubro </label>
            <select class="custom-select mb-3 col-sm-4" id="rubro_id" >
              <option value="0" disabled selected>Seleccione rubro</option>
              <?php foreach ($rubros as $rubro): ?>
                <option value="<?php echo $rubro->id ?>"> <?php echo $rubro->name; ?> </option>
              <?php endforeach ?>
            </select>
          </div>
          <!-- End select rubro -->

          <!-- Input codigo -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="code">Código </label>
            <div class="col-sm-9">
              <input id="code" name="code" class="form-control form-control-md rounded-0" placeholder="Ingrese código de producto" type="text" required>

            </div>
          </div>
          <!-- End Input codigo -->

          <!-- Input nombre -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="name">Nombre </label>
            <div class="col-sm-9">
              <input id="name" name="name" class="form-control form-control-md rounded-0" placeholder="Ingrese nombre de producto" type="text" required>
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- End input nombre -->


          <!-- Input precio sugerido -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="suggested_price">Precio sugerido </label>
            <div class="col-sm-9">
              <input id="suggested_price" name="suggested_price" class="form-control form-control-md rounded-0" placeholder="Ingrese precio sugerido" type="text" >
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- End input precio sugerido -->

          <!-- Input precio sugerido -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="stock_min">Stock mínimo </label>
            <div class="col-sm-9">
              <input id="stock_min" name="stock_min" class="form-control form-control-md rounded-0" placeholder="Ingrese stock minimo" type="number">
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- End input precio sugerido -->

          <!-- Textarea Expandable -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="description">Descripción(*)</label>
            <div class="col-sm-9">
              <textarea id="description" name="description" class="form-control form-control-md u-textarea-expandable rounded-0" rows="3" placeholder="Ingrese descripción del producto"></textarea>
            </div>
          </div>
          <!-- End Textarea Expandable -->

        <button id="btnSave" type="submit" class="btn btn-primary" ></button>
        <button type="button" data-dismiss="modal" class="btn u-btn-red closeModal"> Cerrar </button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal crear/editar productos  -->

<!-- Modal para eliminar product -->
<div class="modal fade" id="modal_delete_product" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿ Esta seguro de eliminar este perfil ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_product_delete" name="id_product_delete" value="">
        <p id="name_product_delete"><strong>Nombre: </strong> </p>
        <br>
        <p id="description_product_delete"><strong>Detalle: </strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-md u-btn-red g-mr-10" onclick="destroy_product()">Eliminar</button>
        <button type="button" data-dismiss="modal" class="btn btn-md u-btn-indigo g-mr-10"> Cerrar </button>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal eliminar product -->

<!-- Modal descargar Excel -->
<div class="modal fade" id="modal_descargar_excel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"> Descargar excel </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          <form id="form_excel" method="POST" action="<?php echo base_url('Products/excel_productos') ?>" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">
            <!-- Select rubro -->
            <div class="form-group row g-mb-5">
              <label class="mr-sm-6 mb-6 mb-lg-0 col-sm-6" for="rubro_id">Seleccione rubro </label>
              <select class="custom-select mb-6 col-sm-6" id="rubro_id" name="rubro_id" >
                <option value="0" selected>Todos</option>
                <?php foreach ($rubros as $rubro): ?>
                  <option value="<?php echo $rubro->id ?>"> <?php echo $rubro->name; ?> </option>
                <?php endforeach ?>
              </select>
            </div>
            <!-- End select rubro -->
            <button id="btnDownload" type="submit" class="btn btn-primary" > Descargar </button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          </form>
      </div>
    </div>
  </div>
</div>
<!-- fin modal descargar excel -->
<script type="text/javascript">

  var save_method
  var products_table
  var product_type_selected // lo uso para identificar cual esta seleccionado en el select y resetearlo
  var cost_center_selectd // lo uso para identificar cual esta seleccionado en el select y resetearlo

  function create_product()
  {
    save_method = 'create';
    $('#form_products')[0].reset()
    $('#modal_products .modal-title').text('Alta de producto');
    $('#modal_products #btnSave').text('Grabar producto');
    $('.form-control').removeClass('error');
    $('.error').empty();
    $('#modal_products').modal('show');
  }

  function edit_product(id)
  {
    save_method = 'update';
    $('#form_products')[0].reset()
    $('#check_permite_edit_prox_venc').hide()
    $('.form-control').removeClass('error')
    $('.error').empty()

    $.ajax({
      url: "<?php echo base_url('Products/get_for_id/');?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(resp)
        {
          let data = resp[0]

          $('#product_id').val(data.id)
          $('[name=code]').val(data.code)
          $('[name=name]').val(data.name)
          product_type_selected = resp[0].rubro_id
          $('#rubro_id option[value="0"]').attr('selected', false)
          $('#rubro_id option[value="'+ resp[0].rubro_id +'"]').attr('selected', 'selected')
          cost_center_selectd = resp[0].cost_center_id
          $('#cost_center_id option[value="0"]').attr('selected', false)
          $('#cost_center_id option[value="'+ resp[0].cost_center_id +'"]').attr('selected', 'selected')
          $('[name=suggested_price]').val(data.suggested_price)
          $('[name=stock_min]').val(data.stock_min)
          $('[name=description]').val(data.description)

          $('#modal_products .modal-title').text('Modificar perfil')
          $('#modal_products #btnSave').text('Actualizar perfil')
          $('#modal_products').modal('show')
        },
      error: function(jqXHR, textStatus, errorThrown)
        {
          alert('Error obteniendo datos')
        }
    });
  }

  $('.closeModal').on('click', function(event) {
    // Dejo seleccionado por defecto
    $('#rubro_id option[value="'+ product_type_selected +'"]').attr('selected', false)
    $('#rubro_id option[value="0"]').attr('selected', 'selected')
    $('#cost_center_id option[value="'+ cost_center_selectd +'"]').attr('selected', false)
    $('#cost_center_id option[value="0"]').attr('selected', 'selected')
    $('.error-code').text('')
    $('#product_id').val('')
  })

  // Llamo al modal de advertencia para eliminar el producto
    function delete_product(id)
    {
      $.ajax({
        url: "<?php echo base_url('Products/get_for_id/');?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          let resp = data[0]
          $('#modal_delete_product #id_product_delete').val(resp.id)
          $('#modal_delete_product #name_product_delete').append(resp.name)
          $('#modal_delete_product #description_product_delete').append(resp.description)
          $('#modal_delete_product').modal('show')
        },
        error: function()
        {
          alert('Error al obtener los datos');
        }
      });
    }
    // Elimino el producto
    function destroy_product()
    {
      var id_product = $('#id_product_delete').val();
      $.ajax({
        url: "<?php echo base_url('Products/destroy/');?>" + id_product,
        type: "POST",
        success: function(msg)
        {
          if (msg === 'ok') {
            products_table.ajax.reload(null,false);
            $('#modal_delete_product').modal('hide');
          } else {
            alert('Error al intentar eliminar el product');
          }
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          alert('Fallo el eliminar product')
        }
      });
    }

    function sugerir_codigo(rubro_id)
    {
      // Obtengo el codigo del ultimo producto agregado de un rubro y lo imprimo en el campo codigo
      $.ajax({
        url: '<?php echo base_url('Products/get_last_code/');?>' + rubro_id,
        dataType: "JSON",
        success: function(msg){
          let letra_codigo = msg.substr(0,1)
          let numero_codigo = msg.substr(1)
          numero_codigo = letra_codigo + generate_code_product( numero_codigo )
          console.log( 'dato: ' + msg )
          $('#code').val( numero_codigo )
        },
        error: function(msg){

        }
      })
    }

    function generate_code_product( number ) {
      let numberOutput = Math.abs(number); /* Valor absoluto del número */
      numberOutput++
      let length = number.toString().length; /* Largo del número original */
      let width = numberOutput.toString().length; /* Largo del número sin ceros */
      let zero = "0"; /* String de cero */

      if (length <= width) {
          if (number < 0) {
               // Si se tratara de un numero negativo le agregamos el -
               return ("-" + numberOutput.toString());
          } else {
               return numberOutput.toString();
          }
      } else {
          if (number < 0) {
              return ("-" + (zero.repeat(length - width)) + numberOutput.toString());
          } else {
              return ((zero.repeat(length - width)) + numberOutput.toString());
          }
      }
    }


    $('#rubro_id').on('change', function(){
      sugerir_codigo(  $(this).val() )
    })

    function existe_codigo(code)
    {
      let codigo_repetido
      $.ajax({
        url: '<?php echo base_url('Products/existe_codigo/') ?>' + code,
        success: function( msg ) {
          console.log(msg)
          if (msg === 'true') {
            $('.error-code').text('El codigo debe ser unico')
            codigo_repetido = true
          } else {
            codigo_repetido =  false
          }
        }, error: function( msg ) {

        }
      })
      return codigo_repetido
    }

  $(document).on('ready', function () {


    $.validator.addMethod("alfanumOespacio", function(value, element) {
            return /^[ a-záéíóúüñ]*$/i.test(value);
        }, "Ingrese sólo letras.")

    var form_products = $('#form_products').validate({
                                rules: {
                                  'code': {
                                      remote: {
                                        url: "<?php echo base_url('Products/existe_codigo');?>",
                                        type: "POST",
                                        data: {
                                          code: function() {
                                            return $('#code').val()
                                          },
                                          product_id: function() {
                                            return $('#product_id').val()
                                        }
                                      }
                                    }
                                  }
                                },
                                messages: {
                                  'code' : {
                                    remote: 'El codigo debe ser unico'
                                  }
                                }
                              })

    function save()
    {
      var url
      $('#btnSave').text('guardando...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable

       url = "<?php echo base_url('Products/');?>" + save_method;
      // ajax adding data to database

      $.ajax({
        url: url,
        type: "POST",
        data: agrupar_datos(),
        success: function(msg)
        {
          if (msg === 'ok') {
            products_table.ajax.reload(null,false);
            $('#modal_products').modal('hide');
            $('.error-code').text('')
          } else if ( msg === 'bug' ) {
          console.log('Bug')
          } else {
            alert('error al guardar datos '+ msg)
          }
          $('#btnSave').attr('disabled', false);
          },
        error: function(jqXHR, textStatus, errorThrown){
          alert('Error al guardar datos metodo: ' + save_method);
          $('#btnSave').attr('disabled', false);
          }
        })
      }

    $('#form_products').submit(function(e){
      e.preventDefault()
      if ( form_products.valid()  ) {
        save()
      } else {
        console.log(' form invalido ')
      }
    })



    function agrupar_datos()
    {
      datos = {
        'id': $('#form_products #product_id').val(),
        'code': $('#form_products #code').val(),
        'name': $('#form_products #name').val(),
        'rubro_id': $('#form_products #rubro_id').val(),
        'cost_center_id': $('#form_products #cost_center_id').val(),
        'suggested_price': parseFloat( $('#form_products #suggested_price').val() ),
        'stock_min': $('#form_products #stock_min').val(),
        'description': $('#form_products #description').val(),
      }

      return datos
    }
  products_table = $('#products_table').DataTable( {
                          lengthChange: true,
                          ajax : '<?php echo base_url('Products/ajax_list_products/');?>',
                          language:{ url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>" },
                          createdRow: function( row, data, dataIndex ){
                            // data[5] stock data[6] stock min
                            if ( data[5] < data[6] ) {
                              $('td', row).addClass('table-danger')
                            }
                          }
                        })
  })
</script>
