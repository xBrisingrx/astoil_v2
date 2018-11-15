<section class="container-fluid g-py-10">
  <h1>Ingresos</h1>

    <?php if ( $this->session->userdata('rol') == 1 ): ?>
      <button class="btn btn-primary justify-content-end margin_bottom g-mb-10" onclick="create_entry()"> <i class="fa fa-plus"></i> Nuevo </button>
    <?php endif ?>

  <!-- Hover Rows -->
  <div class="card g-brd-teal rounded-0 g-mb-30">
    <h3 class="card-header g-bg-teal g-brd-transparent g-color-white g-font-size-16 rounded-0 mb-0">
      <i class="fa fa-gear g-mr-5"></i>
      Listado de ingresos registrados
    </h3>

    <div class="table-responsive">
      <table id="entries_table" class="table table-striped table-hover u-table--v1 margin-tables">
        <thead>
          <tr>
            <th>Número interno</th>
            <th>Proveedor</th>
            <th>Tipo</th>
            <th>PDF</th>
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
<div class="modal fade" id="modal_entries" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_entries" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">

          <!-- ID product -->
            <input type="hidden" name="entry_id" id="entry_id" value="">

          <!-- Input numero -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="number">Número interno </label>
            <div class="col-sm-9">
              <input id="number" name="number" class="form-control form-control-md rounded-0" placeholder="Ingrese número" type="text" required>
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- End input numero -->

          <!-- Input numero -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="factura_number">Número factura/remito </label>
            <div class="col-sm-9">
              <input id="factura_number" name="factura_number" class="form-control form-control-md rounded-0" placeholder="Ingrese número" type="text">
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- End input numero -->

          <!-- Select type -->
          <div class="form-group row g-mb-5">
            <label class="mr-sm-3 mb-3 mb-lg-0 col-sm-2" for="type_id">Tipo </label>
            <select class="custom-select mb-3 col-sm-4" id="type_id" required>
              <option value="0" disabled selected>Seleccione tipo</option>
              <?php foreach ($entry_types as $types): ?>
                <option value="<?php echo $types->id ?>"> <?php echo $types->name; ?> </option>
              <?php endforeach ?>
            </select>
          </div>
          <!-- End select type -->

          <!-- Select providers -->
          <div class="form-group row g-mb-5">
            <label class="mr-sm-3 mb-3 mb-lg-0 col-sm-2" for="provider_id">Proveedor </label>
            <select class="custom-select mb-3 col-sm-6 providers-select" id="provider_id" required>
              <option value="0" disabled selected >Seleccione proveedor</option>
              <?php foreach ($proveedores as $proveedor): ?>
                <option value="<?php echo $proveedor->id ?>"> <?php echo $proveedor->name; ?> </option>
              <?php endforeach ?>
            </select>
          </div>
          <!-- End select providers -->

          <!-- Select products -->
          <div class="form-group row">
            <div class="col-5">
              <label for="product_id">Productos </label>
              <select class="custom-select products-select" id="product_id" data-live-search="true">
                <option value="0" disabled selected >Seleccione productos </option>
                <?php foreach ($productos as $p): ?>
                  <?php if ($p->rubro_id == 6): ?>
                    <option value="<?php echo $p->id ?>"> <?php echo $p->code; ?> </option>
                  <?php else: ?>
                    <option value="<?php echo $p->id ?>"> <?php echo $p->name; ?> </option>
                  <?php endif ?>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-2">
              <label for="cantidad">Cantidad </label>
              <input id="cantidad" name="cantidad" class="form-control rounded-0" placeholder="0" type="text">
            </div>
            <div class="col-2">
              <label for="precio">Precio </label>
              <input id="precio" name="precio" class="form-control rounded-0" placeholder="0.0" type="text">
            </div>
            <div class="col-2">
              <label for="add_product">Agregar</label> <br>
              <button class="btn btn-sm u-btn-primary g-mr-10 g-mb-15" type="button" id="add_product" title="Agregar producto"> <i class="fa fa-plus"></i> </button>
            </div>
          </div>
          <!-- End select products -->
          <hr>
          <div class="row">
            <div class="col-6"><label> <b>Producto</b> </label></div>
            <div class="col-2"><label> <b>Cantidad</b> </label></div>
            <div class="col-2"><label> <b>Precio</b> </label></div>
          </div>
          <div id="product_list"></div>
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
        <h5 class="modal-title">¿ Esta seguro de eliminar este ingreso ?</h5>
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


<!-- Modal para ver detalle ingreso -->
<div class="modal fade" id="modal_entry_details" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Detalles del ingreso </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="number_entry_detail"></p>
        <br>
        <p id="provider_entry_detail"></p>
        <br>
        <table id="entry_details_table" class="table table-striped table-hover u-table--v1 mb-0" width="100%">
          <thead>
            <tr>
              <th>Producto</th>
              <th>cantidad</th>
              <th>precio</th>
            </tr>
          </thead>

          <tbody>
            <!-- Completo con ajax -->
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-md u-btn-indigo g-mr-10"> Cerrar </button>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal ver detalle ingreso -->


<script type="text/javascript">

  var save_method
  var entries_table
  var entry_details_table
  var product_type_selected // lo uso para identificar cual esta seleccionado en el select y resetearlo
  var cost_center_selectd // lo uso para identificar cual esta seleccionado en el select y resetearlo
  var suma_id_productos = 0 // sumatoria para distinguir los productos q se agregan a una entrada
  var select_products
  var entry_detail_id
  var array_productos = [] // aca guardo los productos


  function create_entry()
  {
    save_method = 'create';
    $('#form_entries')[0].reset()
    $('#modal_entries .modal-title').text('Alta de entrada')
    $('#modal_entries #btnSave').text('Grabar entrada')
    clean_form()
    get_entry_number( )
    $('#modal_entries').modal('show');
  }


  $('.closeModal').on('click', function(event) {
    // Dejo seleccionado por defecto
    $('#provider_id option[value="'+ product_type_selected +'"]').attr('selected', false)
    $('#provider_id option[value="0"]').attr('selected', 'selected')
    $('#type_id option[value="'+ cost_center_selectd +'"]').attr('selected', false)
    $('#type_id option[value="0"]').attr('selected', 'selected')
    clean_form()
  })

  $('#add_product').on('click', function(event) {
    if ($('#product_id').val() != null ) {
      suma_id_productos++
      let label_name =  $('#product_id option:selected').text()
      let precio_ingresado = $('#form_entries #precio').val() * 1.21
      let label_price  = parseFloat(precio_ingresado).toFixed(2)
      let label_cant =  $('#form_entries #cantidad').val()
      let label_id =  $('#form_entries #product_id').val()

      array_productos.push( { index: suma_id_productos,
                              product_id : $('#form_entries #product_id').val(),
                              product_name : $('#product_id option:selected').text(),
                              quantity: $('#form_entries #cantidad').val(),
                              price: parseFloat( label_price ),
                              cargar: true } )

      $('#product_list').append(''+
        '<div class="row g-mb-10" id="div_'+ suma_id_productos +'">'+
          '<input id="product_id_'+suma_id_productos+'" name="product_id_" type="hidden" disabled value="'+ label_id +'">'+
          '<div class="col-6">'+
            '<input id="name_'+suma_id_productos+'" name="name" class="form-control rounded-0 form-control-md" type="text" readonly value="'+ label_name +'">' +
          '</div>'+
          '<div class="col-2">'+
            '<input id="cantidad_'+suma_id_productos+'" name="cantidad" class="form-control rounded-0 form-control-md" type="text" readonly  value="'+ label_cant +'">' +
          '</div>'+
          '<div class="col-2">'+
            '<input id="precio_'+suma_id_productos+'" name="precio" class="form-control rounded-0 form-control-md" placeholder="precio" type="text"  value="'+ label_price +'" readonly> '+
          '</div>'+
          '<div class="col-2">'+
            '<button class="btn u-btn-red g-mr-10 g-mb-15" type="button" id="del_product_'+suma_id_productos+'" title="Quitar" onclick=quitar_producto('+ suma_id_productos +')> <i class="fa fa-trash"></i> </button>'+
          '</div>'+
        '</div>')
      select_products.val(0).trigger('change')
      $('#cantidad').val('0')
      $('#precio').val('0.0')
    } else {
        // if ($('#product_id').val() == null) {
        //   alert('Debe seleccionar un producto')
        // }
        // if ($('#cantidad').val() == 0) {
        //   alert('Debes colocar la cantidad')
        // }
        // if ($('#precio').val() == 0.0) {
        //   alert('Debes colocar el precio')
        // }
    }

  })

  function quitar_producto( div_id )
  {
    $('#div_'+ div_id ).remove()
    for (var i = array_productos.length - 1; i >= 0; i--) {
      if (array_productos[i].index === div_id) {
        array_productos[i].cargar = false
      }
    }
  }

  function extraerDatos(miForm)
  {
    let componentes = $(miForm).find(':input[type=checkbox],input,textarea,option');
    let rta = [];
    $.each(componentes, function(index,componente){
      if ($(componente).prop("type")  == "checkbox") {
        rta.push($(componente).is(':checked'));
      }  else if ($(componente).prop('type') == "") {
        rta.push('selected');
      } else {
        rta.push($(componente).val());
      }
    });
    return rta;
  }

  function extrarProductos( )
  {
    let array_productos = []
    let i
    for ( i = 1; i <= suma_id_productos; i++ )
    {
      array_productos.push( { product_id : $('#form_entries #product_id_' + i).val(),
                              product_name : $('#form_entries #name_' + i).val(),
                              quantity: $('#form_entries #cantidad_'+ i).val(),
                              price: parseFloat( $('#form_entries #precio_'+ i).val() ) } )
    }
    return array_productos
  }

  function clean_form()
  {
    $('#product_list').empty()
    $('#type_id').removeClass('error')
    $('#provider_id').removeClass('error')
    $('.error').empty()
    $('#btnSave').attr('disabled',false)
    suma_id_productos = 0
    select_products.val(0).trigger('change')
    $('#cantidad').val('0')
    $('#precio').val('0.0')
    // Limpio el array
    array_productos.length = 0
  }

  function entry_details( entry_detail_id )
  {
    let entry_detail_data
    get_entry( entry_detail_id )
    // console.log('ingreso ' + entry_detail_data[number])

    entry_details_table.ajax.url('<?php echo base_url('Entries/ajax_list_products_entry/');?>' + entry_detail_id )
    entry_details_table.ajax.reload(null,false)
    // $('#number_entry_detail').text( entry_detail_data.number )
    $('#modal_entry_details').modal('show')
  }

  function get_entry( entry_id )
  {
    $.ajax({
      url: '<?php echo base_url('Entries/get_for_id/') ?>' + entry_id,
      success: function( resp ) {
        var entry = JSON.parse( resp )
        console.log( entry[0].id )
        $('#number_entry_detail').text('Número interno: ' + entry[0].number )
        $('#provider_entry_detail').text('Proveedor: ' + entry[0].provider )
        return entry[0]
      }
    })
  }

  function get_entry_number( )
  {
    let entry_number
    // Obtengo el numero de la ultima entrada
    $.ajax({
      url: '<?php echo base_url('Entries/get_last_number');?>',
      success: function( resp )
      {
        console.log( 'ajax ' +  resp)
        entry_number = generate_entry_number( resp )
        console.log(entry_number)
        $('#form_entries #number').val( entry_number )
      }
    })
    .fail(function() {
      alert('Ocurrio un error al calcular el numero de entrada.')
    })
  }

  function generate_entry_number( number ) {
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


  $(document).on('ready', function () {


    $.validator.addMethod("alfanumOespacio", function(value, element) {
            return /^[ a-záéíóúüñ]*$/i.test(value);
        }, "Ingrese sólo letras.")

    var form_entries = $('#form_entries').validate({
                      rules: {
                        'number': {
                          required: true,
                          remote: {
                            url: "<?php echo base_url('Entries/validar_numero_entrada');?>",
                            type: "POST",
                            data: {
                              number: function() {
                                return $('#number').val()
                              }
                            }
                          }
                        }
                      },
                      messages: {
                        'number' : {
                          remote: 'El numero debe ser unico'
                        }
                      }
                    })

  function save()
  {
    var url
    var url_pdf = '<?php echo base_url('assets/uploads/comprobantes/ingresos/ingreso_');?>' + $('#form_entries #number').val() + '.pdf'
    let lista_productos = extrarProductos()
    $('#btnSave').text('guardando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable

     url = "<?php echo base_url('Entries/');?>" + save_method
     // console.log(lista_productos)
    $.ajax({
      url: url,
      type: "POST",
      data: agrupar_datos(),
      success: function(msg)
      {
        if ( msg === 'ok' ) {
          entries_table.ajax.reload(null,false)
          $('#modal_entries').modal('hide')
          clean_form()
          window.open( url_pdf , '_blank' )
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

    $('#form_entries').submit(function(e){
      e.preventDefault()
      if (array_productos.length > 0) {
        if ( form_entries.valid() )
          {
            save()
          }
      } else {
        alert('Debes ingresar algun producto')
      }
    })



    function agrupar_datos()
    {
      datos = {
        'id': $('#form_entries #entry_id').val(),
        'number': $('#form_entries #number').val(),
        'factura_number': $('#form_entries #factura_number').val(),
        'type_id': $('#form_entries #type_id').val(),
        'provider_id': $('#form_entries #provider_id').val(),
        'list_products': JSON.stringify( array_productos ),
      }

      return datos
    }

  var providers_select = $('.providers-select').selectpicker({
    liveSearch: true,
    maxOptions: 1
  })

  var products_select = $('.products-select').selectpicker({
    liveSearch: true,
    maxOptions: 1
  })


  select_products =  $('.select-2-products').select2()

  entries_table = $('#entries_table').DataTable( {
                          lengthChange: true,
                          ajax : '<?php echo base_url('Entries/ajax_list_entries/');?>',
                          language:{ url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>" }
                        })
  entry_details_table = $('#entry_details_table').DataTable( {
                          lengthChange: true,
                          ajax : '<?php echo base_url('Entries/ajax_list_products_entry/');?>' + entry_detail_id,
                          language:{ url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>" }
                        })
  })
</script>