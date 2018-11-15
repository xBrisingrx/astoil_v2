<section class="container-fluid g-py-10">
  <h1>Salidas</h1>

    <?php if ( $this->session->userdata('rol') == 1 ): ?>
      <button class="btn btn-primary justify-content-end margin_bottom g-mb-10" onclick="create_product()"> <i class="fa fa-plus"></i> Nuevo </button>

      <button class="btn btn-info justify-content-end margin_bottom g-mb-10" onclick="new_output_combustible()"> <i class="fa fa-plus"></i> Carga de combustible </button>
      <a href="<?php echo base_url('Outputs/new_output_water') ?>" class="btn u-btn-purple justify-content-end margin_bottom g-mb-10"> <i class="fa fa-plus"></i> Carga de agua </a>
    <?php endif ?>

  <!-- Hover Rows -->
  <div class="card g-brd-teal rounded-0 g-mb-30">
    <h3 class="card-header g-bg-teal g-brd-transparent g-color-white g-font-size-16 rounded-0 mb-0">
      <i class="fa fa-gear g-mr-5"></i>
      Listado de salidas registradas
    </h3>

    <div class="table-responsive">
      <table id="outputs_table" class="table table-striped table-hover u-table--v1 margin-tables">
        <thead>
          <tr>
            <th>Número</th>
            <th>Centro de costo</th>
            <th>Observaciones</th>
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


<!-- Modal con form para crear/editar salidas -->
<div class="modal fade" id="modal_ouputs" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_output" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">

          <!-- ID product -->
            <input type="hidden" name="output_id" id="output_id" value="">

          <!-- Input numero -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="number">Número </label>
            <div class="col-sm-9">
              <input id="number" name="number" class="form-control form-control-md rounded-0" placeholder="Ingrese número" type="text" required>
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- End input numero -->


          <!-- Select type -->
          <div class="form-group row g-mb-5">
            <label class="mr-sm-3 mb-3 mb-lg-0 col-sm-2" for="cost_center_id">Centro de costo </label>
            <select class="custom-select select-cost-center" id="cost_center_id" required>
              <option value="0" disabled selected>Seleccione</option>
              <?php foreach ($cost_center as $c): ?>
                <option value="<?php echo $c->id ?>"> <?php echo $c->name; ?> </option>
              <?php endforeach ?>
            </select>
          </div>
          <!-- End select type -->

          <!-- Textarea Expandable -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="comment">Observaciones </label>
            <div class="col-sm-9">
              <textarea id="comment" name="comment" class="form-control form-control-md u-textarea-expandable rounded-0" rows="3" placeholder="Ingrese una reseña"></textarea>
            </div>
          </div>
          <!-- End Textarea Expandable -->

          <div class="row form-group col-12">
            <div class="col-6">
              <label for="product_id">Productos </label>
              <select class="custom-select select-2-products w-100" id="product_id" data-live-search="true">
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
              <label for="combustible_id">Cantidad</label>
              <input id="cantidad" name="cantidad" class="form-control rounded-0" placeholder="cantidad" type="text">
            </div>
            <input id="precio" name="precio" type="hidden" value="">
            <div class="col-2">
              <label for="add_product">Agregar</label> <br>
              <button class="btn btn-sm u-btn-primary g-mr-10 g-mb-15" type="button" id="add_product" title="Agregar producto"> <i class="fa fa-plus"></i> </button>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-8"><label> <b>Producto</b> </label></div>
            <div class="col-2"><label> <b>Cantidad</b> </label></div>
            <div class="col-2"><label> <b>Quitar</b> </label></div>
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


<!-- Modal con form para crear/editar salidas de combustible -->
<div class="modal fade" id="modal_ouput_multiple" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_combustible" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">
          <!-- Input numero -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="number_output_combustible">Número </label>
            <div class="col-sm-9">
              <input id="number_output_combustible" name="number_output_combustible" class="form-control form-control-md rounded-0" placeholder="Ingrese número" type="text" required>
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- End input numero -->

          <!-- Textarea Expandable -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="comment">Observaciones </label>
            <div class="col-sm-9">
              <textarea id="comment" name="comment" class="form-control form-control-md u-textarea-expandable rounded-0" rows="3" placeholder="Ingrese una reseña"></textarea>
            </div>
          </div>
          <!-- End Textarea Expandable -->

          <div class="row form-group">
            <div class="col-4">
              <label for="cost_center_combustible">Centro de costos</label>
              <select class="custom-select cost-select" id="cost_center_combustible" data-live-search="true">
                <option value="0">Seleccione</option>
                <?php foreach ($cost_center as $c): ?>
                  <option value="<?php echo $c->id ?>"> <?php echo $c->name; ?> </option>
                <?php endforeach ?>
              </select>
            </div>
            <div class="col-2">
              <label for="combustible_id">Producto</label>
              <select class="custom-select" id="combustible_id">
                <option value="0" disabled selected>Seleccione</option>
                <?php foreach ($combustibles as $combustible): ?>
                  <option value="<?php echo $combustible->id ?>"> <?php echo $combustible->name; ?> </option>
                <?php endforeach ?>
              </select>
            </div>
            <input type="hidden" id="price_combustible" value="">
            <div class="col-2">
              <label for="km_hs">KM/HS</label>
              <input type="text" class="form-control rounded-0" id="km_hs" aria-describedby="emailHelp" value='0'>
            </div>
            <div class="col-2">
              <label for="cant_combustible">Cantidad</label>
              <input type="text" class="form-control rounded-0" id="cant_combustible" aria-describedby="emailHelp" value='0'>
            </div>
            <div class="col-2">
              <label for="cant_combustible">Agregar</label> <br>
              <button class="btn btn-sm u-btn-primary g-mr-10 g-mb-15" type="button" id="add_combustible" title="Agregar combustible"> <i class="fa fa-plus"></i> </button>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-4"><label> <b>Centro de costos</b> </label></div>
            <div class="col-2"><label> <b>Producto</b> </label></div>
            <div class="col-2"><label> <b>KM/HS</b> </label></div>
            <div class="col-2"><label> <b>Cantidad</b> </label></div>
          </div>
          <div id="combustible_list"></div>
          <br>
        <button id="btnSave" type="submit" class="btn btn-primary" > Guardar </button>
        <button type="button" data-dismiss="modal" class="btn u-btn-red closeModal"> Cerrar </button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal crear/editar productos  -->

<!-- Modal para ver detalle salida -->
<div class="modal fade" id="modal_entry_details" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Detalle </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="number_output_detail"><strong>Número: </strong> </p>
        <br>
        <p id="cost_center_output_detail"><strong>Centro de costos: </strong></p>
        <br>
        <table id="output_details_table" class="table table-striped table-hover u-table--v1 mb-0" width="100%">
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
<!-- Fin modal ver detalle salida -->

<!-- Modal para ver detalle salida de combustible -->
<div class="modal fade" id="modal_entry_combustible_details" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Detalle </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="number_output_detail"><strong>Número: </strong> </p>
        <br>
        <table id="output_combustible_details_table" class="table table-striped table-hover u-table--v1 mb-0" width="100%">
          <thead>
            <tr>
              <th>Centro de costos</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>KM/HS</th>
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
<!-- Fin modal ver detalle salida de combustible -->

<!-- Modal para ver detalle salida de water -->
<div class="modal fade" id="modal_entry_water_details" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Detalle </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="number_output_detail"><strong>Número: </strong> </p>
        <br>
        <table id="output_water_details_table" class="table table-striped table-hover u-table--v1 mb-0" width="100%">
          <thead>
            <tr>
              <th>Centro de costos</th>
              <th>Producto</th>
              <th>Cantidad</th>
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
<!-- Fin modal ver detalle salida de water -->

<script type="text/javascript">

  var save_method
  var outputs_table
  var output_combustible_details_table
  var product_type_selected // lo uso para identificar cual esta seleccionado en el select y resetearlo
  var cost_center_selectd // lo uso para identificar cual esta seleccionado en el select y resetearlo
  var suma_id_productos = 0 // sumatoria para distinguir los productos q se agregan a una entrada
  var output_detail_id
  var array_productos = []
  var stock_max = 0

  function create_product()
  {
    // save_method = 'create';
    $('#form_output')[0].reset()
    $('#modal_ouputs .modal-title').text('Alta de salida')
    $('#modal_ouputs #btnSave').text('Grabar salida')
    clean_form()
    get_output_number(  $('#form_output #number') )
    // $('#form_output #number').val( numero_salida )
    $('#modal_ouputs').modal('show');
  }


  $('.closeModal').on('click', function(event) {
    // Dejo seleccionado por defecto
    $('#provider_id option[value="'+ product_type_selected +'"]').attr('selected', false)
    $('#provider_id option[value="0"]').attr('selected', 'selected')
    $('#cost_center_id option[value="'+ cost_center_selectd +'"]').attr('selected', false)
    $('#cost_center_id option[value="0"]').attr('selected', 'selected')
    clean_form()
  })

  $('#product_id').on('change', function(event) {
    if ( $('#product_id').val() != null) {
      $.ajax({
        url: "<?php echo base_url('Products/get_for_id/') ?>" + $('#product_id').val(),
        type: "GET",
        dataType: "JSON",
        success: function(resp){
          if (resp[0] != "undefined") {
            $('#cantidad').val(resp[0]['stock'])
            $('#precio').val(resp[0]['suggested_price'])
            stock_max = parseInt( resp[0]['stock'] )
          }
        }
      })
    }
  })

  $('#add_product').on('click', function(event) {
    // Dejo seleccionado por defecto
    let cantidad_ingresada = parseInt( $('#cantidad').val() )
    if ($('#product_id').val() != null &&  cantidad_ingresada <= stock_max)
    {
      suma_id_productos++
      let label_name =  $('#product_id option:selected').text()
      let label_cant =  $('#form_output #cantidad').val()
      let label_id =  $('#form_output #product_id').val()

      array_productos.push( { index: suma_id_productos,
                              product_id : label_id,
                              product_name : label_name,
                              quantity: label_cant,
                              price: parseFloat( $('#form_output #precio').val() ),
                              cargar: true } )

      $('#product_list').append(
        '<div class="row g-mb-10" id="div_'+ suma_id_productos +'">'+
          '<input id="product_id_'+suma_id_productos+'" name="product_id_" type="hidden" value="'+ label_id +'">'+
          '<div class="col-8">'+
            '<input id="name_'+suma_id_productos+'" name="name" type="text" readonly class="form-control rounded-0 form-control-md" value="'+ label_name +'">'+
          '</div>'+
          '<div class="col-2">'+
            '<input id="cantidad_'+suma_id_productos+'" name="cantidad" type="text" readonly class="form-control rounded-0 form-control-md" value="'+ label_cant +'">'+
          '</div>'+
          '<div class="col-2">'+
            '<button class="btn u-btn-red g-mr-10 g-mb-15" type="button" title="Quitar" onclick=quitar_producto('+ suma_id_productos +')> <i class="fa fa-trash"></i> </button>'+
          '</div>'+
        '</div>')
      // select_products.val(0).trigger('change')
      $('#cantidad').val('')
      $('#precio').val('')
    } else {
      if ($('#product_id').val() == null) {
        alert('Debe seleccionar un producto')
      }
      if ( cantidad_ingresada > stock_max ) {
        alert('La cantidad no puede superar el stock actual')
      }
    }

  })

  $('#combustible_id').on('change', function(event) {
    if ( $('#combustible_id').val() != null) {
      $.ajax({
        url: "<?php echo base_url('Products/get_for_id/') ?>" + $('#combustible_id').val(),
        type: "GET",
        dataType: "JSON",
        success: function(resp){
          if (resp[0] != "undefined") {
            $('#cant_combustible').val(resp[0]['stock'])
            $('#price_combustible').val(resp[0]['suggested_price'])
            stock_max = parseInt( resp[0]['stock'] )
          }
        }
      })
    }
  })

  $('#add_combustible').on('click', function(event) {
    // Dejo seleccionado por defecto
    let cantidad_ingresada = parseInt( $('#cant_combustible').val() )
    let cost_center_id =  $('#form_combustible #cost_center_combustible').val()
    if ($('#combustible_id').val() != null &&  cantidad_ingresada <= stock_max  && cost_center_id != 0)
    {
      suma_id_productos++
      let label_name =  $('#combustible_id option:selected').text()
      let label_cant =  $('#form_combustible #cant_combustible').val()
      let label_id =  $('#form_combustible #combustible_id').val()
      let cost_center_name =  $('#cost_center_combustible option:selected').text()
      let km_hs = $('#form_combustible #km_hs').val()

      array_productos.push( { index: suma_id_productos,
                              cost_center_id : cost_center_id,
                              product_id : label_id,
                              product_name : label_name,
                              km_hs : km_hs,
                              cost_center_name : cost_center_name,
                              quantity: label_cant,
                              price: parseFloat( $('#form_combustible #price_combustible').val() ),
                              cargar: true } )

      $('#combustible_list').append('<div class="row g-mb-10" id="div_'+ suma_id_productos +'">'+
                                      '<div class="col-4">'+
                                        '<input type="text" value="'+ cost_center_name +'" readonly class="form-control rounded-0 form-control-md">'+
                                      '</div>'+
                                      '<div class="col-2">'+
                                        '<input type="text" value="'+ label_name +'" readonly class="form-control rounded-0 form-control-md">'+
                                      '</div>'+
                                      '<div class="col-2">'+
                                        '<input type="text" value="'+ km_hs +'" readonly class="form-control rounded-0 form-control-md">'+
                                      '</div>'+
                                      '<div class="col-2">'+
                                        '<input type="text" value="'+ label_cant +'" readonly class="form-control rounded-0 form-control-md">'+
                                      '</div>'+
                                      '<div class="col-2">'+
                                        '<button class="btn u-btn-red g-mr-1 g-mb-1" type="button" title="Quitar" onclick=quitar_producto('+ suma_id_productos +')> <i class="fa fa-trash"></i> </button>'+
                                      '</div>'+
                                    '</div>')
    } else {
      if ($('#combustible_id').val() == null) {
        alert('Debe seleccionar un producto')
      }
      if ( cantidad_ingresada > stock_max ) {
        alert('La cantidad no puede superar el stock actual')
      }
      if (cost_center_id == 0) {
        alert('Debe seleccionar un centro de costo')
      }
    }
  })




  function quitar_producto( div_id )
  // Quitamos productos de la lista
  {
    $('#div_'+ div_id ).remove()
    for (var i = array_productos.length - 1; i >= 0; i--) {
      if (array_productos[i].index === div_id) {
        array_productos[i].cargar = false
      }
    }
  }

  function clean_form()
  {
    $('#product_list').empty()
    $('#combustible_list').empty()
    $('#cost_center_id').removeClass('error')
    $('.error').empty()
    $('#btnSave').attr('disabled',false)
    suma_id_productos = 0
    // select_products.val(0).trigger('change')
    // Limpio el array
    array_productos.length = 0
  }

  function get_output_number( value )
  {
    // let output_number
    // Obtengo el numero de la ultima entrada
    $.ajax({
      url: '<?php echo base_url('Outputs/get_ouput_number/true');?>',
      success: function( resp )
      {
        // output_number = generate_output_number( resp )
        value.val( resp )
        // console.log('resp: ' + resp + ' gen: ' + generate_output_number( resp ) )
        // return generate_output_number( resp )
      }
    })
    .fail(function() {
      alert('Ocurrio un error al calcular el numero de salida.')
    })
  }

  function generate_output_number( number ) {
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

  function output_details( output_detail_id )
  {
    output_details_table.ajax.url('<?php echo base_url('Outputs/ajax_list_products_output/');?>' + output_detail_id )
    output_details_table.ajax.reload(null,false)
    $('#modal_entry_details').modal('show')
  }

  function output_combustible_details( output_detail_id )
  {
    console.log(output_detail_id)
    output_combustible_details_table.ajax.url('<?php echo base_url('Outputs/ajax_list_combustible_output/');?>' + output_detail_id )
    output_combustible_details_table.ajax.reload(null,false)
    $('#modal_entry_combustible_details').modal('show')
  }

  function output_water_details( output_detail_id )
  {
    console.log(output_detail_id)
    output_water_details_table.ajax.url('<?php echo base_url('Outputs/ajax_list_water_output/');?>' + output_detail_id )
    output_water_details_table.ajax.reload(null,false)
    $('#modal_entry_water_details').modal('show')
  }

  function new_output_combustible()
  {
    $('#form_combustible')[0].reset()
    get_output_number( $('#form_combustible #number_output_combustible') )
    $('#modal_ouput_multiple').modal('show')
  }

  $(document).on('ready', function () {

    var my_select = $('.cost-select').selectpicker({
      liveSearch: true,
      maxOptions: 1
    })

    var select_products = $('.select-2-products').selectpicker({
      liveSearch: true,
      maxOptions: 1
    })

    var select_products = $('.select-cost-center').selectpicker({
      liveSearch: true,
      maxOptions: 1
    })

    $.validator.addMethod("alfanumOespacio", function(value, element) {
            return /^[ a-záéíóúüñ]*$/i.test(value);
        }, "Ingrese sólo letras.")

    var form_output = $('#form_output').validate({
                      rules: {
                        'number': {
                          required: true,
                          remote: {
                            url: "<?php echo base_url('Outputs/validar_numero_entrada');?>",
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

    var form_output_combustible = $('#form_combustible').validate({
                      rules: {
                        'number_output_combustible': {
                          required: true,
                          remote: {
                            url: "<?php echo base_url('Outputs/validar_numero_entrada');?>",
                            type: "POST",
                            data: {
                              number: function() {
                                return $('#number_output_combustible').val()
                              }
                            }
                          }
                        }
                      },
                      messages: {
                        'number_output_combustible' : {
                          remote: 'El numero debe ser unico'
                        }
                      }
                    })

  function save()
  {
    var url = "<?php echo base_url('Outputs/create');?>"
    var url_pdf = '<?php echo base_url('assets/uploads/comprobantes/salidas/salida_');?>' +
                   $('#form_output #number').val() + '.pdf'

    $('#btnSave').text('guardando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable

    $.ajax({
      url: url,
      type: "POST",
      data: agrupar_datos(),
      success: function(msg)
      {
        if (msg === 'ok') {
          outputs_table.ajax.reload(null,false)
          $('#modal_ouputs').modal('hide')
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

  function save_combustible()
  {
    var url
    var url_pdf = '<?php echo base_url('assets/uploads/comprobantes/salidas/salida_');?>' + $('#form_combustible #number_output_combustible').val() + '.pdf'

    $('#btnSave').text('guardando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable

     url = "<?php echo base_url('Outputs/create_combustible_output');?>"
    // ajax adding data to database

    $.ajax({
      url: url,
      type: "POST",
      data: agrupar_datos_combustible(),
      success: function(msg)
      {
        if (msg === 'ok') {
          outputs_table.ajax.reload(null,false)
          $('#modal_ouput_multiple').modal('hide')
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

  function save_water()
  {
    var url
    var url_pdf = '<?php echo base_url('assets/uploads/comprobantes/salidas/salida_');?>' + $('#form_water #number_output_water').val() + '.pdf'

    $('#btnSave').text('guardando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable

     url = "<?php echo base_url('Outputs/create_water_output');?>"
    // ajax adding data to database

    $.ajax({
      url: url,
      type: "POST",
      data: agrupar_datos_water(),
      success: function(msg)
      {
        if (msg === 'ok') {
          outputs_table.ajax.reload(null,false)
          $('#modal_ouput_water').modal('hide')
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
        alert('Error al guardar datos');
        $('#btnSave').attr('disabled', false);
        }
      })
  }

    $('#form_output').submit(function(e){
      e.preventDefault()
      if (array_productos.length > 0) {
        if ( form_output.valid() )
          {
            save()
          }
      } else {
        alert('Debes ingresar algun producto')
      }
    })

    $('#form_combustible').submit(function(e){
      e.preventDefault()
      if (array_productos.length > 0) {
        if ( form_output_combustible.valid() )
          {
            save_combustible()
          }
      } else {
        alert('Debes ingresar algun producto')
      }
    })



    function agrupar_datos()
    {
      datos = {
        'id': $('#form_output #output_id').val(),
        'number': $('#form_output #number').val(),
        'cost_center_id': $('#form_output #cost_center_id').val(),
        'comment': $('#form_output #comment').val(),
        'list_products': JSON.stringify( array_productos ),
      }

      return datos
    }


    function agrupar_datos_combustible()
    {
      datos = {
        'number': $('#form_combustible #number_output_combustible').val(),
        'comment': $('#form_combustible #comment').val(),
        'list_products': JSON.stringify( array_productos ),
      }

      return datos
    }

  // select_products =  $('.select-2-products').select2()

  outputs_table = $('#outputs_table').DataTable( {
                          lengthChange: true,
                          ajax : '<?php echo base_url('Outputs/ajax_list_outputs/');?>',
                          language:{ url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>" }
                        })
  output_details_table = $('#output_details_table').DataTable( {
                          lengthChange: true,
                          ajax : '<?php echo base_url('Outputs/ajax_list_products_output/');?>' + output_detail_id,
                          language:{ url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>" }
                        })

  output_combustible_details_table = $('#output_combustible_details_table').DataTable( {
                          lengthChange: true,
                          ajax : '<?php echo base_url('Outputs/ajax_list_combustible_output/');?>' + output_detail_id,
                          language:{ url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>" }
                        })
  output_water_details_table = $('#output_water_details_table').DataTable( {
                          lengthChange: true,
                          ajax : '<?php echo base_url('Outputs/ajax_list_water_output/');?>' + output_detail_id,
                          language:{ url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>" }
                        })
  })
</script>