<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cost_center extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->model('Cost_center_model');
    if ( empty( $this->session->username ) ) {
      redirect('Login');
    }
  }

  function index()
  {
    $title['title'] = 'Centro de costos';
    $this->load->view('includes/header', $title);
    $this->load->view('includes/nav');
    $this->load->view('system/cost_center/index');
    $this->load->view('includes/footer');
  }

  function create()
  {
    $cost_center = array(
      'name' => $_POST['name'],
      'description' => $_POST['description'],
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
      'user_created_id' => $this->session->userdata('id'),
      'user_last_updated_id' => $this->session->userdata('id'),
      'active' => true
    );

    if ($this->Cost_center_model->insert_entry($cost_center)) {
      echo 'ok';
    } else {
      echo 'error';
    }
  }

  function get_for_id($id)
  {
    echo json_encode( $this->Cost_center_model->get('id', $id) );
  }

  function update()
  {
    $id = $_POST['id'];

    $cost_center = array(
      'name' => $_POST['name'],
      'description' => $_POST['description'],
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
      'user_last_updated_id' => $this->session->userdata('id'),
      'active' => true
    );

    if ($this->Cost_center_model->update_entry( $id, $cost_center )) {
      echo 'ok';
    } else {
      echo 'error';
    }
  }

  function destroy( $id )
  {
    if ( $this->Cost_center_model->destroy( $id ) ) {
      echo 'ok';
    } else {
      echo 'Error';
    }
  }

  function ajax_list()
  {
    $cost_center = $this->Cost_center_model->get();
    $data = array();

    foreach ($cost_center as $c) {

      $row = array();
      $row[] = $c->name;
      $row[] = $c->description;
      if ( $this->session->userdata('rol') == 1 ) {
        $row[] = '<button class="btn u-btn-primary g-mr-10 g-mb-15" title="Editar" onclick="edit_cost_center('."'".$c->id."'".')" ><i class="fa fa-edit"></i></button> <button class="btn u-btn-red g-mr-10 g-mb-15" title="Eliminar" onclick="delete_cost_center('."'".$c->id."'".')" ><i class="fa fa-trash-o"></i></button>';
      } else {
        $row[] = '<button class="btn u-btn-primary g-mr-10 g-mb-15" title="Editar" disabled ><i class="fa fa-edit"></i></button> <button class="btn u-btn-red g-mr-10 g-mb-15" title="Eliminar" disabled ><i class="fa fa-trash-o"></i></button>';
      }

      $data[] = $row;
    }

    $output = array("data" => $data);
    echo json_encode($output);
  }
}
