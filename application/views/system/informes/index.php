<section class="container-fluid g-py-10">
  <h1>Informes</h1>


  <form id="form_por_fecha" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30" >
    <!-- Select type -->
    <div class="form-group g-mb-5 col-12 row">
      <div class="col-4">
        <label class="" for="cost_center_id">Centro de costo </label>
        <select class="custom-select select-cost-center" id="cost_center_id" required>
          <option value="0" disabled selected>Seleccione</option>
          <?php foreach ($cost_center as $c): ?>
            <option value="<?php echo $c->id ?>"> <?php echo $c->name; ?> </option>
          <?php endforeach ?>
        </select>
      </div>
      <div class="col-2">
        <label for="desde">Desde</label>
        <input id="desde" class="form-control form-control-md rounded-0" type="date" requierd>
      </div>
      <div class="col-2">
        <label for="hasta">Hasta</label>
        <input id="hasta" class="form-control form-control-md rounded-0" type="date" requierd>
      </div>
    </div>
    <button id="btnSave" type="submit" class="btn btn-sm btn-primary" > Consultar </button>
  </form>

  <!-- Hover Rows -->
  <div class="card g-brd-teal rounded-0 g-mb-30">
    <h3 class="card-header g-bg-teal g-brd-transparent g-color-white g-font-size-16 rounded-0 mb-0">
      <i class="fa fa-gear g-mr-5"></i>
      Listado de datos consultados
    </h3>

    <div class="table-responsive">
      <table id="informes_table" class="table table-striped table-hover margin-tables">
        <thead>
          <tr>
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
  </div>
  <!-- End Hover Rows -->
</section>

<!-- Modal para ver detalle salida -->
<div class="modal fade" id="modal_output_details" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"> Detalle </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table id="output_details_table" class="table table-striped table-hover u-table--v1 mb-0" width="100%">
          <thead>
            <tr>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio</th>
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



<script type="text/javascript">
  var informes_table
  var select_cost_center

  function get_pdf( desde, hasta, cost_center_id )
  {
    let url_pdf = '<?php echo base_url('assets/uploads/informes/informe.pdf');?>'
    console.log('desde: ' + desde + ' hasta: ' + hasta + 'centro ' + cost_center_id)
    $.ajax({
      url: '<?php echo base_url('Informes/create_pdf_informe_productos_outputs/') ?>'+desde+'/'+hasta+'/'+cost_center_id,
      success: function( msg )
      {
        window.open( url_pdf, '_blank' )
      }
    })
    .fail(function() {
      alert('No se pudo generar el PDF')
    })
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

    $('#form_por_fecha').submit(function(e){
      e.preventDefault();
      let desde = $('#desde').val()
      let hasta = $('#hasta').val()
      let cost_center_id = $('#cost_center_id').val()
      informes_table.ajax.url('Informes/por_fecha/'+desde+'/'+hasta+'/'+cost_center_id)
      calcular_total_salida(desde, hasta, cost_center_id)
      informes_table.ajax.reload(null,false)
      select_cost_center.val(0).trigger('change')
      $('#form_por_fecha')[0].reset()

    })

    function calcular_total_salida(desde, hasta, cost_center_id)
    {
      // let url = 'Informes/por_fecha/'+desde+'/'+hasta+'/'+cost_center_id
      $.ajax({
        url: "<?php echo base_url('Informes/calcular_total_salida/');?>"+desde+'/'+hasta+'/'+cost_center_id,
        success: function( msg )
        {
          console.log('desde: ' + desde + ' hasta: ' + hasta + 'centro ' + cost_center_id)
          $("div.toolbar").html('<b> Total de costo: $ </b>' + msg + '   ' +
                                '<button type="button" '+
                                ' class="btn btn-sm u-btn-darkgray g-mr-10" '+
                                ' onclick=get_pdf("'+desde+'","'+hasta+'","'+cost_center_id+'") > PDF </button>' +
                                '<button type="button" '+
                                ' class="btn btn-sm u-btn-darkgray g-mr-10" disabled '+
                                ' onclick=get_excel('+desde+','+hasta+','+cost_center_id+') > Excel </button>'
            )
        }
      })
    }

  informes_table = $('#informes_table').DataTable( {
                          "dom": '<"toolbar">frtip',
                          ajax : '<?php echo base_url('Informes/por_fecha/null/null/null');?>',
                          language:{
                                    url: "<?php echo base_url('assets/vendor/DataTables/Spanish.json');?>"
                                   },
                          columns: [ { data: 1 }, { data: 2 } ]
                        })

  select_cost_center = $('#cost_center_id').select2()

  })
</script>
