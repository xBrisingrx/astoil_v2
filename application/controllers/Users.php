<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    $this->load->model('User_model');
    date_default_timezone_set('America/Argentina/Buenos_Aires');
    if ( empty( $this->session->username ) ) {
      redirect('Login');
    }
  }

  public function index()
  {
    $title['title'] = 'Usuarios';
    $this->load->view('includes/header',$title);
    $this->load->view('includes/nav');
    $this->load->view('system/users/index');
    $this->load->view('includes/footer');

  }

  public function new( $error = null )
  {
    $title['title'] = 'Alta de usuario';
    $data['empresas'] = $this->Empresa_model->get();
    $data['error'] = $error;
    $this->load->view('includes/header',$title);
    $this->load->view('includes/nav');
    $this->load->view('system/users/new',$data);
    $this->load->view('includes/footer');
  }

  public function create()
  {
    $user = array(
      'username'   => $this->input->post('username'),
      'email'    => $this->input->post('email'),
      'rol'    => $this->input->post('rol'),
      'password'     => $this->encryption->encrypt($this->input->post('password')),
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
      'active' => true
    );

    if ($this->User_model->insert_entry($user)) {
      echo 'ok';
    } else {
      echo 'error';
    }
  }

  public function edit($id)
  {
    $user = $this->User_model->get('id',$id);
    echo json_encode($user);
  }

  public function update()
  {
    $id = $this->input->post('id');
    $user = array(
      'email' => $this->input->post('email'),
      'username'   => $this->input->post('username'),
      'password'     => $this->encryption->encrypt($this->input->post('password')),
      'updated_at' => date('Y-m-d H:i:s')
    );
    if ($this->User_model->update_entry($id, $user)) {
      echo 'ok';
    } else {
      echo 'Error';
    }
  }

  public function destroy($id)
  {
    if ($this->User_model->destroy($id)) {
      echo 'ok';
    } else {
      echo 'Error';
    }
  }


// Obtengo los datos de mi tabla y los devuelvo en formato json para insertar en datatables
  public function ajax_list()
  {
    $users = $this->User_model->get();
    $data = array();

    foreach ($users as $u) {

      $row = array();
      $row[] = $u->username;
      $row[] = $u->email;
      $row[] = ( $u->rol == 1 ) ? 'Administrador' : 'Normal';
      $row[] = '<button class="btn u-btn-primary g-mr-10 g-mb-15" title="Editar" onclick="edit_user('."'".$u->id."'".')" ><i class="fa fa-edit"></i></button> <button class="btn u-btn-red g-mr-10 g-mb-15" title="Eliminar" onclick="delete_user('."'".$u->id."'".')" ><i class="fa fa-trash-o"></i></button>';

      $data[] = $row;
    }

    $output = array("data" => $data);
    echo json_encode($output);
  }

  function existe_email(  )
  {
    $email = $this->input->post('email');
    if ( $this->User_model->existe_email( $email ) != 0 ) {
      echo 'false';
    } else {
      echo 'true';
    }
  }

}