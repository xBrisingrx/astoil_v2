<section class="container-fluid g-py-10">
  <h1>Centros de costos</h1>

    <?php if ( $this->session->userdata('rol') == 1 ): ?>
      <button class="btn btn-primary justify-content-end margin_bottom g-mb-10" onclick="create_cost_center()"> <i class="fa fa-plus"></i> Nuevo</button>
    <?php endif ?>

  <!-- Hover Rows -->
  <div class="card g-brd-teal rounded-0 g-mb-30">
    <h3 class="card-header g-bg-teal g-brd-transparent g-color-white g-font-size-16 rounded-0 mb-0">
      <i class="fa fa-gear g-mr-5"></i>
      Listado de centros de costos registrados
    </h3>

    <div class="table-responsive">
      <table id="cost_center_table" class="table table-striped table-hover u-table--v1 margin-tables">
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
<div class="modal fade" id="modal_cost_center" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_cost_center" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">

          <!-- ID product -->
            <input type="hidden" name="cost_center_id" id="cost_center_id" value="">

          <!-- Input nombre -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="name">Nombre </label>
            <div class="col-sm-9">
              <input id="name" name="name" class="form-control form-control-md rounded-0" placeholder="Ingrese nombre de centro de costos" type="text" required>
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- End input nombre -->

          <!-- Textarea Expandable -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="description">Descripción(*)</label>
            <div class="col-sm-9">
              <textarea id="description" name="description" class="form-control form-control-md u-textarea-expandable rounded-0" rows="3" placeholder="Ingrese descripción del centro de costos"></textarea>
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
<div class="modal fade" id="modal_delete_cost_center" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿ Esta seguro de eliminar este perfil ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_cost_center_delete" name="id_cost_center_delete" value="">
        <p id="name_cost_center_delete"><strong>Nombre: </strong> </p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-md u-btn-red g-mr-10" onclick="destroy_cost_center()">Eliminar</button>
        <button type="button" data-dismiss="modal" class="btn btn-md u-btn-indigo g-mr-10"> Cerrar </button>
      </div>
    </div>
  </div>
</div>
<!-- Fin modal eliminar tipo productos -->


<script type="text/javascript">

  var save_method
  var cost_center_table
  function create_cost_center()
  {
    save_method = 'create'
    $('#form_cost_center')[0].reset()
    $('#modal_cost_center .modal-title').text('Alta de centro de costos')
    $('#modal_cost_center #btnSave').text('Grabar')
    $('.form-control').removeClass('error')
    $('.error').empty()
    $('#modal_cost_center').modal('show')
  }

  function edit_cost_center(id)
  {
    save_method = 'update'
    $('#form_cost_center')[0].reset()
    $('.form-control').removeClass('error')
    $('.error').empty()

    $.ajax({
      url: "<?php echo base_url('Cost_center/get_for_id/');?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(resp)
        {
          let data = resp[0]

          $('#cost_center_id').val(data.id)
          $('[name=name]').val(data.name)
          $('[name=description]').val(data.description)

          $('#modal_cost_center .modal-title').text('Modificar centro de costo');
          $('#modal_cost_center #btnSave').text('Actualizar');
          $('#modal_cost_center').modal('show');
        },
      error: function(jqXHR, textStatus, errorThrown)
        {
          alert('Error obteniendo datos: '+ textStatus);
        }
    });

  }

// Llamo al modal de advertencia para eliminar el centro de costo
  function delete_cost_center( id )
  {
    $.ajax({
      url: "<?php echo base_url('Cost_center/get_for_id/');?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        let resp = data[0]
        $('#modal_delete_cost_center #id_cost_center_delete').val(resp.id)
        $('#modal_delete_cost_center #name_cost_center_delete').append(resp.name)
        $('#modal_delete_cost_center').modal('show')
      },
      error: function()
      {
        alert('Error al obtener los datos');
      }
    })
  }

  // Elimino el centro de costos
  function destroy_cost_center()
  {
    var id_cost_center = $('#id_cost_center_delete').val()
    $.ajax({
      url: "<?php echo base_url('Cost_center/destroy/');?>" + id_cost_center,
      type: "POST",
      success: function(msg)
      {
        if (msg === 'ok') {
          cost_center_table.ajax.reload(null,false)
          $('#modal_delete_cost_center').modal('hide')
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

    var form_cost_center = $('#form_cost_center').validate({
                                rules: {
                                  'name': { minlength: 3, required: true },
                                  'description': { minlength: 5 }
                                }
                              });



    function save()
    {
      var url;
      $('#btnSave').text('guardando...'); //change button text
      $('#btnSave').attr('disabled',true); //set button disable

       url = "<?php echo base_url('Cost_center/');?>" + save_method;

      $.ajax({
        url: url,
        type: "POST",
        data: agrupar_datos(),
        success: function(msg)
        {
          if (msg === 'ok') {
            cost_center_table.ajax.reload(null,false);
            $('#modal_cost_center').modal('hide');
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

    $('#form_cost_center').submit(function(e){
      e.preventDefault();
      if (form_cost_center.valid()) {
        save()
      }
    })




    function agrupar_datos()
    {
      datos = {
        'id': $('#form_cost_center #cost_center_id').val(),
        'name': $('#form_cost_center #name').val(),
        'description': $('#form_cost_center #description').val()
      }

      return datos
    }
  cost_center_table = $('#cost_center_table').DataTable( {
                          lengthChange: true,
                          ajax : '<?php echo base_url('Cost_center/ajax_list/');?>',
                          language:{ url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>" }
                        })
  })
</script>
