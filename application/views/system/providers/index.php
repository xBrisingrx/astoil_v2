<section class="container-fluid">
  <h1>Proveedores</h1>

  <?php if ( $this->session->userdata('rol') == 1 ): ?>
    <button class="btn btn-primary justify-content-end margin_bottom g-mb-10" onclick="create_product()"> <i class="fa fa-plus"></i> Nuevo </button>
  <?php endif ?>

  <!-- Hover Rows -->
  <div class="card g-brd-teal rounded-0 g-mb-30">
    <h3 class="card-header g-bg-teal g-brd-transparent g-color-white g-font-size-16 rounded-0 mb-0">
      <i class="fa fa-gear g-mr-5"></i>
      Listado de proveedores registrados
    </h3>

    <div class="table-responsive">
      <table id="providers_table" class="table table-striped table-hover margin-tables">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>CUIT</th>
            <th>Descripcion</th>
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


<!-- Modal con form para crear/editar proveedores -->
<div class="modal fade" id="modal_providers" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_providers" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">

          <!-- ID provider -->
            <input type="hidden" name="provider_id" id="provider_id" value="">

          <!-- Input nombre -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="name">Nombre </label>
            <div class="col-sm-9">
              <input id="name" name="name" class="form-control form-control-md rounded-0" placeholder="Ingrese nombre de proveedor" type="text" >
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- End input nombre -->

          <!-- Input cuit -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="cuit">CUIT </label>
            <div class="col-sm-9">
              <input id="cuit" name="cuit" class="form-control form-control-md rounded-0" placeholder="Ingrese código de proveedor" type="text" >
              <small class="form-control-feedback error-cuit"></small>
            </div>
          </div>
          <!-- End Input cuit -->

          <!-- Textarea Expandable -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="description">Descripción(*)</label>
            <div class="col-sm-9">
              <textarea id="description" name="description" class="form-control form-control-md u-textarea-expandable rounded-0" rows="3" placeholder="Ingrese descripción del proveedor"></textarea>
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
<!-- Fin modal crear/editar proveedores  -->

<!-- Modal para eliminar product -->
<div class="modal fade" id="modal_delete_product" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿ Esta seguro de eliminar este proveedor ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="provider_delete_id" name="provider_delete_id" value="">
        <p id="name_provider_delete"><strong>Proveedor: </strong> </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-md u-btn-red g-mr-10" onclick="destroy_provider()">Eliminar</button>
        <button type="button" data-dismiss="modal" class="btn btn-md u-btn-indigo g-mr-10"> Cerrar </button>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal eliminar product -->


<script type="text/javascript">

  var save_method
  var providers_table
  var product_type_selected // lo uso para identificar cual esta seleccionado en el select y resetearlo
  var cost_center_selectd // lo uso para identificar cual esta seleccionado en el select y resetearlo

  function create_product()
  {
    save_method = 'create';
    $('#form_providers')[0].reset()
    $('#modal_providers .modal-title').text('Alta de proveedor');
    $('#modal_providers #btnSave').text('Grabar proveedor');
    $('.form-control').removeClass('error');
    $('.error').empty();
    $('#modal_providers').modal('show');
  }

  function edit_product(id)
  {
    save_method = 'update';
    $('#form_providers')[0].reset()
    $('#check_permite_edit_prox_venc').hide()
    $('.form-control').removeClass('error')
    $('.error').empty()

    $.ajax({
      url: "<?php echo base_url('Providers/get_for_id/');?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(resp)
        {
          let data = resp[0]

          $('#provider_id').val(data.id)
          $('[name=cuit]').val(data.cuit)
          $('[name=name]').val(data.name)
          $('[name=description]').val(data.description)

          $('#modal_providers .modal-title').text('Modificar proveedor')
          $('#modal_providers #btnSave').text('Actualizar proveedor')
          $('#modal_providers').modal('show')
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
  })

  // Llamo al modal de advertencia para eliminar el proveedor
    function delete_product(id)
    {
      $.ajax({
        url: "<?php echo base_url('Providers/get_for_id/');?>" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
          let resp = data[0]
          $('#modal_delete_product #provider_delete_id').val(resp.id)
          $('#modal_delete_product #name_provider_delete').append(resp.name)
          $('#modal_delete_product').modal('show')
        },
        error: function()
        {
          alert('Error al obtener los datos');
        }
      });
    }
    // Elimino el proveedor
    function destroy_provider()
    {
      var id_provider = $('#provider_delete_id').val();
      $.ajax({
        url: "<?php echo base_url('Providers/destroy/');?>" + id_provider,
        type: "POST",
        success: function(msg)
        {
          if (msg === 'ok') {
            providers_table.ajax.reload(null,false);
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


    function existe_codigo(cuit)
    {
      let codigo_repetido
      $.ajax({
        url: '<?php echo base_url('Providers/existe_codigo/') ?>' + cuit,
        success: function( msg ) {
          console.log(msg)
          if (msg === 'true') {
            $('.error-cuit').text('El codigo debe ser unico')
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

    var form_providers = $('#form_providers').validate({
                                rules: {
                                  'nombre': {
                                              minlength: 3 },
                                  'descripcion': { minlength: 10 },
                                  'periodo_vencimiento': {
                                    required: function(){
                                      return ( $('#tipo_vencimiento').val() == 1 )
                                    }
                                  }
                                }
                              })

    function save()
    {
      var url
      $('#btnSave').text('guardando...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable

       url = "<?php echo base_url('Providers/');?>" + save_method;
      // ajax adding data to database

      $.ajax({
        url: url,
        type: "POST",
        data: agrupar_datos(),
        success: function(msg)
        {
          if (msg === 'ok') {
            providers_table.ajax.reload(null,false);
            $('#modal_providers').modal('hide');
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

    $('#form_providers').submit(function(e){
      e.preventDefault()

      save()
    })



  function agrupar_datos()
  {
    datos = {
      'id': $('#form_providers #provider_id').val(),
      'cuit': $('#form_providers #cuit').val(),
      'name': $('#form_providers #name').val(),
      'description': $('#form_providers #description').val(),
    }

    return datos
  }
  providers_table = $('#providers_table').DataTable( {
                          lengthChange: true,
                          ajax : '<?php echo base_url('Providers/ajax_list_providers/');?>',
                          language:{ url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>" }
                        })
  })
</script>
