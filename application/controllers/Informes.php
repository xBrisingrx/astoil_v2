<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Informes extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->library('Pdf');
    $this->load->model('Informes_model');
    $this->load->model('Cost_center_model');
    $this->load->model('Output_Products_model');
    if ( empty( $this->session->username ) ) {
      redirect('Login');
    }
  }

  function index()
  {
    $title['title'] = 'Informes';
    $data['cost_center'] = $this->Cost_center_model->get();
    $this->load->view('includes/header', $title);
    $this->load->view('includes/nav');
    $this->load->view('system/informes/index',$data);
    $this->load->view('includes/footer');
  }

  function por_fecha($desde = null, $hasta = null, $cost_center_id)
  {
    $informe = $this->Informes_model->get_products_por_fecha($desde, $hasta, $cost_center_id);
    $data = array();
    $total = 0.0;
    foreach ($informe as $i) {

      $row = array();
      // $row[] = $i->id;
      // $row[] = date('d-m-Y', strtotime($i->fecha));
      // $row[] = $i->output;
      // $row[] = '$ '.$this->sumar_productos_salida($i->id);
      // $row[] = '<button class="btn u-btn-orange g-mr-10 g-mb-15" title="Detalle" onclick="show_detail('."'".$i->id."'".')" ><i class="fa fa-eye"></i></button>';
      // $row[] = $this->sumar_productos_salida($i->id);
      $row[] = $i->id;
      $row[] = $i->name;
      $row[] = $i->cantidad;
      $data[] = $row;
    }

    $output = array("data" => $data);
    echo json_encode($output);
  }

  function sumar_productos_salida($output_id)
  {
    // Sumo el precio de los productos de una salida
    $data = $this->Informes_model->sumar_productos_salida($output_id);
    $price = 0.0 ;
    foreach ($data as $d) {
      $price += $d->price * $d->quantity;
    }
    return $price;
  }

  function calcular_total_salida($desde = null, $hasta = null, $cost_center_id, $pdf = null)
  {
    /*
    Sumo el precio total de todas las salidas de un centro de costos en el intervalo de tiempo seleccionado
    La variable PDF es para diferenciar si la funcion la llamo para la vista o para generar el PDF de informe
    */
    $total = 0.0;
    $data = $this->Informes_model->get_outputs_por_fecha($desde, $hasta, $cost_center_id);
    if (count( $data ) > 0) {
      foreach ($data as $d) {
        $total +=$this->sumar_productos_salida($d->id);
      }
    } else {
      $total = 'sin_resultado';
    }
    if ($pdf) {
      return $total;
    } else {
      echo $total;
    }
  }

  function get_products_output( $output_id )
  {
    $products = $this->Output_Products_model->get('output_id', $output_id);
    echo json_encode($products);
  }

  function create_pdf_informe_productos_outputs( $desde, $hasta, $cost_center_id )
  {
    /* Generamos un pdf con la cantidad de productos y el precio de X cantidad de salidas */
    $products = $this->Informes_model->get_products_por_fecha($desde, $hasta, $cost_center_id);

    $total = $this->calcular_total_salida($desde, $hasta, $cost_center_id, true );
    $cost_center_name = $this->Cost_center_model->get('id', $cost_center_id);
    $this->pdf->folder( FCPATH . 'assets/uploads/informes/');

    //establecemos el nombre del archivo
    $this->pdf->filename('informe.pdf');

    //establecemos el tipo de papel
    $this->pdf->paper('a4', 'portrait');

    $data = array(
        'title' => 'Informe',
        'cost_center' => $cost_center_name[0]->name,
        'desde' => date('d-m-Y', strtotime($desde)),
        'hasta' => date('d-m-Y', strtotime($hasta)),
        'products' => $products,
        'total' => $total
    );
    $this->pdf->html(utf8_decode($this->load->view('system/informes/pdf_pdf_informe_productos_outputs', $data, true)));
    $this->pdf->create('save');
  }
}
