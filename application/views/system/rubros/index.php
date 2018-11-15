<section class="container-fluid g-py-10">
  <h1>Rubros</h1>

    <?php if ($this->session->userdata('rol') == 1): ?>
      <button class="btn btn-primary justify-content-end margin_bottom g-mb-10" onclick="create_product_type()"> <i class="fa fa-plus"></i> Nuevo </button>
    <?php endif ?>

  <!-- Hover Rows -->
  <div class="card g-brd-teal rounded-0 g-mb-30">
    <h3 class="card-header g-bg-teal g-brd-transparent g-color-white g-font-size-16 rounded-0 mb-0">
      <i class="fa fa-gear g-mr-5"></i>
      Listado de rubros
    </h3>

    <div class="table-responsive">
      <table id="products_type_table" class="table table-striped table-hover u-table--v1 margin-tables">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Descripción</th>
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


<!-- Modal con form para crear/editar tipo productos -->
<div class="modal fade" id="modal_products_type" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_product_type" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">

          <!-- ID product -->
            <input type="hidden" name="product_type_id" id="product_type_id" value="">

          <!-- Input nombre -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="name">Nombre </label>
            <div class="col-sm-9">
              <input id="name" name="name" class="form-control form-control-md rounded-0" placeholder="Ingrese nombre de tipo producto" type="text" required>
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- End input nombre -->

          <!-- Textarea Expandable -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="description">Descripción(*)</label>
            <div class="col-sm-9">
              <textarea id="description" name="description" class="form-control form-control-md u-textarea-expandable rounded-0" rows="3" placeholder="Ingrese descripción del tipo producto"></textarea>
            </div>
          </div>
          <!-- End Textarea Expandable -->
        <br>
        <button id="btnSave" type="submit" class="btn btn-primary" ></button>
        <button type="button" data-dismiss="modal" class="btn u-btn-red"> Cerrar </button>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal crear/editar productos  -->

<!-- Modal para eliminar atributo -->
<div class="modal fade" id="modal_delete_product_type" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿ Esta seguro de eliminar este perfil ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_product_type_delete" name="id_product_type_delete" value="">
        <p id="name_product_type_delete"><strong>Nombre: </strong> </p>
        <br>
        <p id="description_product_type_delete"><strong>Detalle: </strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-md u-btn-red g-mr-10" onclick="destroy_product_type()">Eliminar</button>
        <button type="button" data-dismiss="modal" class="btn btn-md u-btn-indigo g-mr-10"> Cerrar </button>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal eliminar tipo productos -->


<script type="text/javascript">

  var save_method
  var products_type_table
  function create_product_type()
  {
    save_method = 'create';
    $('#form_product_type')[0].reset()
    $('#modal_products_type .modal-title').text('Alta de tipo producto');
    $('#modal_products_type #btnSave').text('Grabar producto');
    $('.form-control').removeClass('error');
    $('.error').empty();
    $('#modal_products_type').modal('show');
  }

  function edit_product_type(id)
  {
    save_method = 'update';
    $('#form_product_type')[0].reset()
    $('.form-control').removeClass('error')
    $('.error').empty()

    $.ajax({
      url: "<?php echo base_url('Rubros/get_for_id/');?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(resp)
        {
          let data = resp[0]

          $('#product_type_id').val(data.id)
          $('[name=name]').val(data.name)
          $('[name=description]').val(data.description)

          $('#modal_products_type .modal-title').text('Modificar tipo de producto');
          $('#modal_products_type #btnSave').text('Actualizar');
          $('#modal_products_type').modal('show');
        },
      error: function(jqXHR, textStatus, errorThrown)
        {
          alert('Error obteniendo datos: '+ textStatus);
        }
    });

  }

// Llamo al modal de advertencia para eliminar el centro de costo
  function delete_product_type(id)
  {
    $.ajax({
      url: "<?php echo base_url('Rubros/get_for_id/');?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        let resp = data[0]
        $('#modal_delete_product_type #id_product_type_delete').val(resp.id)
        $('#modal_delete_product_type #name_product_type_delete').append(resp.name)
        $('#modal_delete_product_type #description_product_type_delete').append(resp.description)
        $('#modal_delete_product_type').modal('show')
      },
      error: function()
      {
        alert('Error al obtener los datos');
      }
    })
  }

  // Elimino el centro de costos
  function destroy_product_type()
  {
    var id_product_type = $('#id_product_type_delete').val();
    $.ajax({
      url: "<?php echo base_url('Rubros/destroy/');?>" + id_product_type,
      type: "POST",
      success: function(msg)
      {
        if (msg === 'ok') {
          products_type_table.ajax.reload(null,false);
          $('#modal_delete_product_type').modal('hide');
        } else {
          alert('Error al intentar eliminar el atributo');
        }
      },
      error: function(jqXHR, textStatus, errorThrown)
      {
        alert('Fallo el eliminar atributo');
      }
    });
  }

  $(document).on('ready', function () {


    $.validator.addMethod("alfanumOespacio", function(value, element) {
            return /^[ a-záéíóúüñ]*$/i.test(value);
        }, "Ingrese sólo letras.");

    var form_product_type = $('#form_product_type').validate({
                                rules: {
                                  'nombre': {
                                              minlength: 3 },
                                  'descripcion': { minlength: 10 },
                                  'tipo_vencimiento': {
                                    required: function(){
                                      return $('#tiene_vencimiento').is(':checked')
                                    }
                                  },
                                  'periodo_vencimiento': {
                                    required: function(){
                                      return ( $('#tipo_vencimiento').val() == 1 )
                                    }
                                  }
                                }
                              });


    function save()
    {
      var url;
      $('#btnSave').text('guardando...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable

       url = "<?php echo base_url();?>Rubros/" + save_method;

      $.ajax({
        url: url,
        type: "POST",
        data: agrupar_datos(),
        success: function(msg)
        {
          if (msg === 'ok') {
            products_type_table.ajax.reload(null,false);
            $('#modal_products_type').modal('hide');
          } else {
            alert('error al guardar datos '+ msg)
            console.log(msg)
          }
          $('#btnSave').attr('disabled', false);
          },
        error: function(jqXHR, textStatus, errorThrown){
          alert('Error al guardar datos metodo: ' + save_method);
          $('#btnSave').attr('disabled', false);
          }
        })
      }

    $('#form_product_type').submit(function(e){
      e.preventDefault();
      if (form_product_type.valid()) {
        save()
      }
    })

    function agrupar_datos()
    {
      datos = {
        'id': $('#form_product_type #product_type_id').val(),
        'name': $('#form_product_type #name').val(),
        'description': $('#form_product_type #description').val(),
      }

      return datos
    }
  products_type_table = $('#products_type_table').DataTable( {
                          lengthChange: true,
                          ajax : '<?php echo base_url('Rubros/ajax_list/');?>',
                          language:{ url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>" }
                        })
  })
</script>
