<section class="container-fluid g-py-10">
  <h1> Salida de agua </h1>
    <form id="form_water" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">
      <!-- Input numero -->
      <div class="form-group row g-mb-5">
        <label class="col-sm-2 col-form-label g-mb-5" for="number_output_water">Número </label>
        <div class="col-sm-9">
          <input id="number_output_water" name="number_output_water" class="form-control form-control-md rounded-0" placeholder="Ingrese número" type="text" required value="<?php echo $number_output ?>">
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
          <label for="cost_center_water">Centro de costos</label>
          <select class="custom-select cost-select w-100" id="cost_center_water" data-live-search="true">
            <option value="0">Seleccione</option>
            <?php foreach ($cost_center as $c): ?>
              <option value="<?php echo $c->id ?>"> <?php echo $c->name; ?> </option>
            <?php endforeach ?>
          </select>
        </div>
        <div class="col-4">
          <label for="water_id">Producto</label>
          <select class="custom-select" id="water_id">
            <option value="0" disabled selected>Seleccione</option>
            <?php foreach ($water as $water): ?>
              <option value="<?php echo $water->id ?>"> <?php echo $water->name; ?> </option>
            <?php endforeach ?>
          </select>
        </div>
        <input type="hidden" id="price_water" value="">

        <div class="col-2">
          <label for="cant_water">Cantidad</label>
          <input type="text" class="form-control rounded-0" id="cant_water" name="cant_water" value='0'>
        </div>
        <div class="col-2">
          <label for="add_water">Agregar</label> <br>
          <button class="btn btn-sm u-btn-primary g-mr-10 g-mb-15" type="button" id="add_water" title="Agregar"> <i class="fa fa-plus"></i> </button>
        </div>
      </div>
      <hr>
      <div class="row">
        <div class="col-4"><label> <b>Centro de costos</b> </label></div>
        <div class="col-4"><label> <b>Producto</b> </label></div>
        <div class="col-2"><label> <b>Cantidad</b> </label></div>
        <div class="col-2"><label> <b>Quitar</b> </label></div>
      </div>
      <div id="water_list"></div>
      <br>
    <button id="btnSave" type="submit" class="btn btn-primary" > Guardar </button>
    <a href="<?php echo base_url('Outputs');?>" type="button" class="btn u-btn-red closeModal"> Cerrar </a>
    </form>
</section>

<script type="text/javascript">

  var product_type_selected // lo uso para identificar cual esta seleccionado en el select y resetearlo
  var cost_center_select
  var suma_id_productos = 0 // sumatoria para distinguir los productos q se agregan a una entrada
  var array_productos = []
  var stock_max = 0

  $('#water_id').on('change', function(event) {
    if ( $('#water_id').val() != null) {
      $.ajax({
        url: "<?php echo base_url('Products/get_for_id/') ?>" + $('#water_id').val(),
        type: "GET",
        dataType: "JSON",
        success: function(resp){
          if (resp[0] != "undefined") {
            $('#cant_water').val(resp[0]['stock'])
            $('#price_water').val(resp[0]['suggested_price'])
            stock_max = parseInt( resp[0]['stock'] )
          }
        }
      })
    }
  })

  $('#add_water').on('click', function(event) {
    // Dejo seleccionado por defecto
    let cantidad_ingresada = parseInt( $('#cant_water').val() )
    let cost_center_id =  $('#form_water #cost_center_water').val()
    if ($('#water_id').val() != null &&  cantidad_ingresada <= stock_max  && cost_center_id != 0)
    {
      suma_id_productos++
      let label_name =  $('#water_id option:selected').text()
      let label_cant =  $('#form_water #cant_water').val()
      let label_id =  $('#form_water #water_id').val()
      let cost_center_name =  $('#cost_center_water option:selected').text()

      array_productos.push( { index: suma_id_productos,
                              cost_center_id : cost_center_id,
                              product_id : label_id,
                              product_name : label_name,
                              cost_center_name : cost_center_name,
                              quantity: label_cant,
                              price: parseFloat( $('#form_water #price_water').val() ),
                              cargar: true } )

      $('#water_list').append('<div class="row g-mb-10" id="div_'+ suma_id_productos +'">'+
                                      '<div class="col-4">'+
                                        '<input type="text" value="'+ cost_center_name +'" readonly class="form-control rounded-0 form-control-md">'+
                                      '</div>'+
                                      '<div class="col-4">'+
                                        '<input type="text" value="'+ label_name +'" readonly class="form-control rounded-0 form-control-md">'+
                                      '</div>'+
                                      '<div class="col-2">'+
                                        '<input type="text" value="'+ label_cant +'" readonly class="form-control rounded-0 form-control-md">'+
                                      '</div>'+
                                      '<div class="col-2">'+
                                        '<button class="btn u-btn-red g-mr-1 g-mb-1" type="button" title="Quitar" onclick=quitar_producto('+ suma_id_productos +')> <i class="fa fa-trash"></i> </button>'+
                                      '</div>'+
                                    '</div>')
      cost_center_select.val(0).trigger('change')
    } else {
      if ($('#water_id').val() == null) {
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


  $(document).on('ready', function () {


   cost_center_select = $('.cost-select').select2()


    $.validator.addMethod("alfanumOespacio", function(value, element) {
            return /^[ a-záéíóúüñ]*$/i.test(value);
        }, "Ingrese sólo letras.")


    var form_output_water = $('#form_water').validate({
                      rules: {
                        'number_output_water': {
                          required: true,
                          remote: {
                            url: "<?php echo base_url('Outputs/validar_numero_entrada');?>",
                            type: "POST",
                            data: {
                              number: function() {
                                return $('#number_output_water').val()
                              }
                            }
                          }
                        }
                      },
                      messages: {
                        'number_output_water' : {
                          remote: 'El numero debe ser unico'
                        }
                      }
                    })





  function save_water()
  {
    var url = "<?php echo base_url('Outputs/create_water_output');?>"
    var url_pdf = '<?php echo base_url('assets/uploads/comprobantes/salidas/salida_');?>' +
                   $('#form_water #number_output_water').val() + '.pdf'

    $('#btnSave').text('guardando...'); //change button text
    $('#btnSave').attr('disabled',true); //set button disable

    $.ajax({
      url: url,
      type: "POST",
      data: agrupar_datos_water(),
      success: function(msg)
      {
        if (msg === 'ok') {
          window.open( url_pdf , '_blank' )
          window.location.replace("<?php echo base_url('Outputs') ?>")
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


    $('#form_water').submit(function(e){
      e.preventDefault()
      if (array_productos.length > 0) {
        if ( form_output_water.valid() )
          {
            save_water()
          }
      } else {
        alert('Debes ingresar algun producto')
      }
    })



    function agrupar_datos_water()
    {
      datos = {
        'number': $('#form_water #number_output_water').val(),
        'comment': $('#form_water #comment').val(),
        'list_products': JSON.stringify( array_productos ),
      }

      return datos
    }

  // select_products =  $('.select-2-products').select2()

  })
</script>