<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rubros extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('Rubro_model');
    if ( empty( $this->session->username ) ) {
      redirect('Login');
    }
  }

  function index()
  {
    $title['title'] = 'Rubros';
    $this->load->view('includes/header', $title);
    $this->load->view('includes/nav');
    $this->load->view('system/rubros/index');
    $this->load->view('includes/footer');
  }

  function create()
  {
    $rubro = array(
      'name' => $_POST['name'],
      'description' => $_POST['description'],
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
      'user_created_id' => $this->session->userdata('id'),
      'user_last_updated_id' => $this->session->userdata('id'),
      'active' => true
    );

    if ($this->Rubro_model->insert_entry($rubro)) {
      echo 'ok';
    } else {
      echo 'error';
    }
  }

  function get_for_id($id)
  {
    echo json_encode( $this->Rubro_model->get('id', $id) );
  }

  function update()
  {
    $id = $_POST['id'];

    $rubro = array(
      'name' => $_POST['name'],
      'description' => $_POST['description'],
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
      'user_last_updated_id' => $this->session->userdata('id'),
      'active' => true
    );

    if ($this->Rubro_model->update_entry( $id, $rubro )) {
      echo 'ok';
    } else {
      echo 'error';
    }
  }

  function destroy( $id )
  {
    if ( $this->Rubro_model->destroy( $id ) ) {
      echo 'ok';
    } else {
      echo 'Error';
    }
  }

  function ajax_list()
  {
    $products = $this->Rubro_model->get();
    $data = array();

    foreach ($products as $p) {

      $row = array();
      $row[] = $p->name;
      $row[] = $p->description;
       if ( $this->session->userdata('rol') == 1 ) {
        $row[] = '<button class="btn u-btn-primary g-mr-10 g-mb-15" title="Editar" onclick="edit_rubro('."'".$p->id."'".')" ><i class="fa fa-edit"></i></button> <button class="btn u-btn-red g-mr-10 g-mb-15" title="Eliminar" onclick="delete_rubro('."'".$p->id."'".')" ><i class="fa fa-trash-o"></i></button>';
      } else {
        $row[] = '<button class="btn u-btn-primary g-mr-10 g-mb-15" title="Editar" disabled><i class="fa fa-edit"></i></button> <button class="btn u-btn-red g-mr-10 g-mb-15" title="Eliminar" disabled><i class="fa fa-trash-o"></i></button>';
      };
      $data[] = $row;
    }

    $output = array("data" => $data);
    echo json_encode($output);
  }

}
