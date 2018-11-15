<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Providers extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('Provider_model');
    if ( empty( $this->session->username ) ) {
      redirect('Login');
    }
  }

  function index()
  {
    $title['title'] = 'Proveedores';
    $data['rubros'] = $this->Provider_model->get();
    $this->load->view('includes/header', $title);
    $this->load->view('includes/nav');
    $this->load->view('system/providers/index', $data);
    $this->load->view('includes/footer');
  }

  function create()
  {
    $provider = array(
      'name' => $_POST['name'],
      'cuit' => $_POST['cuit'],
      'description' => $_POST['description'],
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
      'user_created_id' => $this->session->userdata('id'),
      'user_last_updated_id' => $this->session->userdata('id'),
      'active' => true
    );

    if ($this->Provider_model->insert_entry($provider)) {
      echo 'ok';
    } else {
      echo 'error';
    }
  }

  function get_for_id($id)
  {
    echo json_encode( $this->Provider_model->get('id', $id) );
  }

  function update()
  {
    $id = $_POST['id'];
    $provider = array(
      'name' => $_POST['name'],
      'cuit' => $_POST['cuit'],
      'description' => $_POST['description'],
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
      'user_last_updated_id' => $this->session->userdata('id')
    );

    if ($this->Provider_model->update_entry($id, $provider)) {
      echo 'ok';
    } else {
      echo 'error';
    }
  }

  function destroy( $id )
  {
    if ( $this->Provider_model->destroy( $id ) ) {
      echo 'ok';
    } else {
      echo 'Error';
    }
  }

  function ajax_list_providers()
  {
    $providers = $this->Provider_model->get();
    $data = array();

    foreach ($providers as $p) {
      $row = array();
      $row[] = $p->name;
      $row[] = $p->cuit;
      $row[] = $p->description;
       if ( $this->session->userdata('rol') == 1 ) {
        $row[] = '<button class="btn u-btn-primary" title="Editar" onclick="edit_product('."'".$p->id."'".')" ><i class="fa fa-edit"></i></button> <button class="btn u-btn-red" title="Eliminar" onclick="delete_product('."'".$p->id."'".')" ><i class="fa fa-trash-o"></i></button>';
      } else {
        $row[] = '<button class="btn u-btn-primary" title="Editar" disabled ><i class="fa fa-edit"></i></button> <button class="btn u-btn-red" title="Eliminar" disabled ><i class="fa fa-trash-o"></i></button>';
      };
      $data[] = $row;
    }

    $output = array("data" => $data);
    echo json_encode($output);
  }

  function get_last_code($rubro_id)
  {
    echo json_encode( $this->Provider_model->get_last_code($rubro_id) );
  }

  function existe_codigo( $codigo )
  {
    if ( $this->Provider_model->existe_codigo($codigo) ) {
      echo 'true';
    } else {
      echo 'false';
    }
  }

}
