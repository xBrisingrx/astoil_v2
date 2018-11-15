<section class="container-fluid g-py-10">
  <h1>Usuarios registrados en el sistema</h1>

    <button class="btn btn-primary justify-content-end margin_bottom" onclick="new_user()"> Nuevo usuario </button>


  <!-- Hover Rows -->
  <div class="card g-brd-darkpurple rounded-0 g-mb-30">
    <h3 class="card-header g-bg-darkpurple g-brd-transparent g-color-white g-font-size-16 rounded-0 mb-0">
      <i class="fa fa-gear g-mr-5"></i>
      Listado de usuarios registrados
    </h3>

    <div class="table-responsive">
      <table id="tabla_users" class="table table-hover u-table--v1 margin-tables">
        <thead>
          <tr>
            <th>Usuario</th>
            <th>Email</th>
            <th>Tipo</th>
            <th>Acciones</th>
          </tr>
        </thead>

        <tbody>
          <!-- Completo con ajax -->

        </tbody>
      </table>
    </div>
  </div>
  <!-- End Hover Rows -->
  <br><br>
</section>

<div class="modal fade" id="modal_new_user" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Alta de usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="form_user" class="g-brd-around g-brd-gray-light-v4 g-pa-30 g-mb-30">
          <input type="hidden" id="user_id" value="">
            <!-- Select rol -->
            <div class="form-group row g-mb-5">
              <label class="col-sm-2 col-form-label g-mb-5" for="rol">Tipo: </label>
              <select class="custom-select mb-6 col-sm-6" id="rol" name="rol" >
                <option value="2" selected>Normal</option>
                <option value="1">Administrador</option>
              </select>
            </div>
            <!-- End select rol -->
          <!--Input Apellido usuario -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="username">Nombre de usuario(*)</label>
            <div class="col-sm-9">
              <input id="username" name="username" class="form-control rounded-0" placeholder="Ingrese nombre de usuario" type="text" required>
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- Input Apellido usuario -->

          <!--Input email usuario -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="email">Correo electrónico(*)</label>
            <div class="col-sm-9">
              <input id="email" name="email" class="form-control form-control-md rounded-0" placeholder="Ingrese correo de usuario" type="email" required>
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- Input email usuario -->

          <!--Input contrasenia usuario -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="password">Contraseña(*)</label>
            <div class="col-sm-9">
              <input id="password" name="password" class="form-control form-control-md rounded-0" placeholder="Ingrese contraseña de usuario" type="password" required>
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- Input contrasenia usuario -->

          <!--Input repetir contrasenia usuario -->
          <div class="form-group row g-mb-5">
            <label class="col-sm-2 col-form-label g-mb-5" for="passconf">Repetir Contraseña(*)</label>
            <div class="col-sm-9">
              <input id="passconf" name="passconf" class="form-control form-control-md rounded-0" placeholder="Repita la contraseña" type="password" required>
              <small class="form-control-feedback"></small>
            </div>
          </div>
          <!-- Input repetir contrasenia usuario -->

          <button type="submit" class="btn btn-primary">Generar usuario</button>
          <button type="button" class="btn u-btn-red" data-dismiss="modal">Cerrar</button>
        </form>
      </div>
    </div>
  </div>
</div>




<div class="modal fade" id="modal_destroy_user" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">¿ Esta seguro de eliminar este usuario ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="id_user_delete" name="id_user_delete" value="">
        <p id="name_user_delete"><strong>Nombre: </strong> </p>
        <br>
        <p id="email_user_delete"><strong>Correo: </strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn u-btn-red" onclick="destroy_user()">Eliminar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<script type="text/javascript">
  var save_method
  let table_users
  var url
  var form_user = $('#form_user')

  $('#form_user').submit(function(e){
    e.preventDefault()
    if ( form_user.valid() ) {
      save()
    }
  })

  function new_user()
  {
    save_method = 'create'
    $('#form_user')[0].reset()
    $('.form-control').removeClass('error');
    $('.error').empty();
    $('#modal_new_user').modal('show')
  }

  function edit_user( id )
  {
    save_method = 'update';
    $('#form_user')[0].reset()
    $('.form-control').removeClass('error')
    $('.error').empty()

    $.ajax({
      url: "<?php echo base_url('Users/edit/');?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
        {
          $('#id_user').val(data.id)
          $('[name=apellido]').val(data.apellido)
          $('[name=nombre]').val(data.nombre)
          $('#email').val(data.email)
          $('#dni').val(data.dni)
          $('#cuil').val(data.cuil)
          $('#fecha_nacimiento').val(data.fecha_nacimiento)
          $('#nacionalidad').val(data.nacionalidad)
          $('#telefono').val(data.telefono)
          $('#nombre_usuario').val(data.nombre_usuario)
          $('#password').val(data.password)
          $('#passconf').val(data.passconf)
          // $('#modal_new_user .modal-title').text('Modificar perfil');
          // $('#modal_new_user #btnSave').text('Actualizar perfil');
          $('#modal_new_user').modal('show');
        },
      error: function(jqXHR, textStatus, errorThrown)
        {
          alert('Error obteniendo datos');
        }
    });

  }

  function save()
  {
    $.ajax({
      url: '<?php echo base_url("Users/")?>' + save_method,
      type: 'POST',
      data: agrupar_datos(),
    })
    .done(function(resp) {
      if (resp === 'ok') {
        table_users.ajax.reload(null,false)
        $('#modal_new_user').modal('hide')
        noty_alert( 'success' , 'Carga exitosa' )
      };
    })
    .fail(function() {
      console.log("error");
    })
    .always(function() {
      console.log("complete");
    });

  }



  function agrupar_datos()
  {
    datos = {
      'id' : $('#user_id').val(),
      'rol' : $('#rol').val(),
      'username' : $('#username').val(),
      'email' : $('#email').val(),
      'password' : $('#password').val()
    }
    return datos
  }


// Llamo al modal de advertencia para eliminar el usuario
  function delete_user( id )
  {
    $.ajax({
      url: "<?php echo base_url('Users/edit/');?>" + id,
      type: "GET",
      dataType: "JSON",
      success: function(data)
      {
        let resp = data
        $('#modal_destroy_user #id_user_delete').val(resp.id)
        $('#modal_destroy_user #name_user_delete').append(resp.nombre_usuario)
        $('#modal_destroy_user #email_user_delete').append(resp.email)
        $('#modal_destroy_user').modal('show')
      },
      error: function()
      {
        alert('Error al obtener los datos');
      }
    });
  }
  // Elimino el usuario
  function destroy_user()
  {
    var id_user = $('#id_user_delete').val();
    $.ajax({
      url: "<?php echo base_url('Users/destroy/');?>" + id_user,
      type: "POST",
      success: function(msg)
      {
        if (msg === 'ok') {
          table_users.ajax.reload(null,false);
          $('#modal_destroy_user').modal('hide');
        } else {
          alert('Error al intentar eliminar el usuario');
        }
      },
      error: function(jqXHR, textStatus, errorThrown)
      {
        alert('Fallo el eliminar usuario');
      }
    });
  }

  $(document).on('ready', function () {

    $.validator.addMethod("alfanumOespacio", function(value, element) {
            return /^[ a-záéíóúüñ]*$/i.test(value)
        }, "Ingrese sólo letras.")


    form_user.validate({
                  rules: {
                    username: { required: true, alfanumOespacio: true,
                                minlength: 3 },
                    email: {
                            email: true,
                            remote: {
                              url: "<?php echo base_url('Users/existe_email');?>",
                              type: "POST",
                              data: {
                                code: function() {
                                  return $('#email').val()
                                }
                            }
                          }
                        },
                    password: {minlength: 3},
                    passconf: {equalTo: "#password"}
                    },
                  messages: {
                    passconf: {
                      equalTo: 'Las contraseñas deben ser iguales.'
                    },
                    email: {
                      remote: 'Este email ya esta registrado.'
                    }
                  }
                  })

    table_users = $('#tabla_users').DataTable({
                                  lengthChange: false,
                                  ajax: '<?php echo base_url("Users/ajax_list");?>',
                                  language: {
                                        url: "<?php echo base_url(); ?>assets/vendor/DataTables/Spanish.json"
                                      }
    })
  })
</script>
