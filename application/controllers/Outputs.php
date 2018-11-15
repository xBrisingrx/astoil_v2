<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Outputs extends CI_Controller {
// Salidas de los productos
  function __construct()
  {
    parent::__construct();
    $this->load->library('Pdf');
    $this->load->library('form_validation');
    $this->load->model('Output_model');
    $this->load->model('Cost_center_model');
    $this->load->model('Output_Products_model');
    $this->load->model('Product_model');
    $this->load->model('Output_Multiple_Cost_Center_model');
    $this->load->model('Output_water_model');
    if ( empty( $this->session->username ) ) {
      redirect('Login');
    }
  }

  function index()
  {
    $combustible_id = 13; // ID del rubro combustibles
    $title['title'] = 'Salidas';
    $data = array( 'outputs'      => $this->Output_model->get(),
                   'cost_center'  => $this->Cost_center_model->get(),
                   'productos'    => $this->Product_model->get(),
                   'combustibles' => $this->Product_model->get('rubro_id', $combustible_id));
    $this->load->view('includes/header', $title);
    $this->load->view('includes/nav');
    $this->load->view('system/outputs/index', $data);
    $this->load->view('includes/footer');
  }

  function create()
  {
    $this->form_validation->set_rules('number', 'Numero', 'required|is_unique[outputs.number]');
    if ( $this->form_validation->run() == TRUE ) {
      $output = array(
        'number' => $_POST['number'],
        'cost_center_id' => $_POST['cost_center_id'],
        'pdf_path' => 'salida_'.$_POST['number'].'.pdf',
        'comment' => $_POST['comment'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'user_created_id' => $this->session->userdata('id'),
        'user_last_updated_id' => $this->session->userdata('id'),
        'active' => true
      );

      if ($this->Output_model->insert_entry($output)) {
        $productos_cargados = true;
        $ultima_salida_id = $this->Output_model->get_last_id();
        $productos_json = json_decode( $_POST['list_products'] );
        foreach ( $productos_json as $p ) {
          if ($p->cargar) {
            $product = array(
                'output_id' => $ultima_salida_id,
                'product_id' => $p->product_id,
                'quantity' => $p->quantity,
                'price' => $p->price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'user_created_id' => $this->session->userdata('id'),
                'user_last_updated_id' => $this->session->userdata('id'),
                'active' => true
            );
            if (!$this->Output_Products_model->insert_entry( $product )) {
              $productos_cargados = false;
            } else {
              $product_update = $this->Product_model->get('id', $p->product_id);
              $product_update[0]->suggested_price = $p->price;
              $product_update[0]->stock-=$p->quantity;

              $this->Product_model->update_entry($p->product_id, $product_update[0] );
            }
          }
        }
        if ( $productos_cargados ) {
          $cost_center = $this->Cost_center_model->get('id', $_POST['cost_center_id']);
          $this->create_pdf( $output , $productos_json , $cost_center[0]->name, false );
          echo 'ok';
        } else {
          echo 'Error al cargar productos';
        }
      } else {
        echo 'error al cargar ingreso';
      }
    } else {
      echo 'bug'; /* Error que dupolica el create */
    }
  }

  function create_combustible_output()
  {
    $this->form_validation->set_rules('number', 'Numero', 'required|is_unique[outputs.number]');
    if ( $this->form_validation->run() == TRUE ) {
      $output = array(
        'number' => $_POST['number'],
        'cost_center_id' => 1,
        'pdf_path' => 'salida_'.$_POST['number'].'.pdf',
        'comment' => $_POST['comment'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'user_created_id' => $this->session->userdata('id'),
        'user_last_updated_id' => $this->session->userdata('id'),
        'active' => true
      );

      if ($this->Output_model->insert_entry($output)) {
        $combustible_cargado = true;
        $ultima_salida_id = $this->Output_model->get_last_id();
        $combustible_json = json_decode( $_POST['list_products'] );
        foreach ( $combustible_json as $p ) {
          if ($p->cargar) {
            $combustible = array(
                'output_id' => $ultima_salida_id,
                'cost_center_id' => $p->cost_center_id,
                'product_id' => $p->product_id,
                'km_hs' => $p->km_hs,
                'quantity' => $p->quantity,
                'price' => $p->price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'user_created_id' => $this->session->userdata('id'),
                'user_last_updated_id' => $this->session->userdata('id'),
                'active' => true
            );
            if (!$this->Output_Multiple_Cost_Center_model->insert_entry( $combustible )) {
              $combustible_cargado = false;
            } else {
              $product_update = $this->Product_model->get('id', $p->product_id);
              $product_update[0]->stock-=$p->quantity;

              $this->Product_model->update_entry($p->product_id, $product_update[0] );
            }
          }
        }
        if ( $combustible_cargado ) {
          $this->create_pdf( $output , $combustible_json , 'sin cost center', true );
          echo 'ok';
        } else {
          echo 'Error al cargar productos';
        }
      } else {
        echo 'error al cargar ingreso';
      }
     } else {
      echo "bug";
     }
  }

  function new_output_water()
  {
    $title['title'] = 'Salida de agua';
    $data = array( 'cost_center'  => $this->Cost_center_model->get(),
                   'water' => $this->Product_model->get_water(),
                   'number_output' => $this->get_ouput_number());
    $this->load->view('includes/header', $title);
    $this->load->view('includes/nav');
    $this->load->view('system/outputs/output_water', $data);
    $this->load->view('includes/footer');
  }

  function create_water_output()
  {
    $this->form_validation->set_rules('number', 'Numero', 'required|is_unique[outputs.number]');
    if ( $this->form_validation->run() == TRUE ) {
      $output = array(
        'number' => $_POST['number'],
        'cost_center_id' => 1,
        'pdf_path' => 'salida_'.$_POST['number'].'.pdf',
        'comment' => $_POST['comment'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'user_created_id' => $this->session->userdata('id'),
        'user_last_updated_id' => $this->session->userdata('id'),
        'active' => true
      );

      if ($this->Output_model->insert_entry($output)) {
        $water_cargado = true;
        $ultima_salida_id = $this->Output_model->get_last_id();
        $water_json = json_decode( $_POST['list_products'] );
        foreach ( $water_json as $p ) {
          if ($p->cargar) {
            $water = array(
                'output_id' => $ultima_salida_id,
                'cost_center_id' => $p->cost_center_id,
                'product_id' => $p->product_id,
                'quantity' => $p->quantity,
                'price' => $p->price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'user_created_id' => $this->session->userdata('id'),
                'user_last_updated_id' => $this->session->userdata('id'),
                'active' => true
            );
            if (!$this->Output_water_model->insert_entry( $water )) {
              $water_cargado = false;
            } else {
              $product_update = $this->Product_model->get('id', $p->product_id);
              $product_update[0]->stock-=$p->quantity;

              $this->Product_model->update_entry($p->product_id, $product_update[0] );
            }
          }
        }
        if ( $water_cargado ) {
          $this->create_pdf_water( $output , $water_json);
          echo 'ok';
        } else {
          echo 'Error al cargar productos';
        }
      } else {
        echo 'error al cargar ingreso';
      }
    } else {
      echo "bug";
    }

  }


  function get_for_id($id)
  {
    echo json_encode( $this->Output_model->get('id', $id) );
  }


  function ajax_list_outputs()
  {
    $outputs = $this->Output_model->get();
    $data = array();

    foreach ($outputs as $o) {
      $url_pdf = base_url('assets/uploads/comprobantes/salidas/').$o->pdf_path;
      $row = array();
      $row[] = $o->number;
      $row[] = $o->cost_center;
      $row[] = $o->comment;
      $row[] = "<a href=". $url_pdf ." target='_blank' class='text-center'><i class='fa fa-file-pdf-o fa-2x'></i></a>";
      // Verifico si es una salida de combustible
      if ($o->cost_center_id != 1) {
        $row[] = '<button class="btn u-btn-orange" title="Ver" onclick="output_details('."'".$o->id."'".')" ><i class="fa fa-eye"></i></button>';
      } else {
        $row[] = '<button class="btn u-btn-orange" title="Ver" onclick="output_combustible_details('."'".$o->id."'".')" ><i class="fa fa-eye"></i></button>';
      }

      $data[] = $row;
    }

    $output = array("data" => $data);
    echo json_encode($output);
  }

  function ajax_list_products_output( $id )
  {
    $products = $this->Output_Products_model->get('output_id', $id);
    $data = array();
    foreach ($products as $p) {
      $row = array();
      $row[] = $p->name;
      $row[] = $p->quantity;
      $row[] = '$ '.$p->price;
      $data[] = $row;
    }
    $output = array("data" => $data);
    echo json_encode($output);
  }

  function ajax_list_combustible_output( $id )
  {
    $products = $this->Output_Multiple_Cost_Center_model->get('output_id', $id);
    $data = array();
    foreach ($products as $p) {
      $row = array();
      $row[] = $p->cost_center_name;
      $row[] = $p->product_name;
      $row[] = $p->quantity;
      $row[] = $p->km_hs;
      $data[] = $row;
    }
    $output = array("data" => $data);
    echo json_encode($output);
  }

  function ajax_list_water_output( $id )
  {
    $products = $this->Output_water_model->get('output_id', $id);
    $data = array();
    foreach ($products as $p) {
      $row = array();
      $row[] = $p->cost_center_name;
      $row[] = $p->product_name;
      $row[] = $p->quantity;
      $data[] = $row;
    }
    $output = array("data" => $data);
    echo json_encode($output);
  }

  function get_last_code($rubro_id)
  {
    echo json_encode( $this->Output_model->get_last_code($rubro_id) );
  }

  function existe_codigo( $codigo )
  {
    if ( $this->Output_model->existe_codigo($codigo) ) {
      echo 'true';
    } else {
      echo 'false';
    }
  }

  function validar_numero_entrada()
  {
    $number = $_POST['number'];
    if ( $this->Output_model->validate_number( $number ) != 0 ) {
      echo 'false';
    } else {
      echo 'true';
    }
  }

  function get_last_number($no_ajax = null)
  {
    if ( $no_ajax ) {
      return $this->Output_model->get_last_number();
    } else {
      echo $this->Output_model->get_last_number();
    }
  }

  function get_ouput_number($ajax = false)
  {
    $number = $this->Output_model->get_last_number();
    $numberOutput = intval( $number );
    $numberOutput++;
    $length = strlen($number);
    $width = strlen($numberOutput);
    $zero = '0';

    if ( $length <= $width ) {
      if ($ajax) {
        echo $numberOutput;
      } else {
        return $numberOutput;
      }
    } else {
      if ($ajax) {
        echo ((str_repeat($zero, $length - $width)).$numberOutput);
      } else {
        return ((str_repeat($zero, $length - $width)).$numberOutput);
      }
    }
  }

  function create_pdf( $output , $products, $cost_center, $pdf_combustible )
  {
      //establecemos la carpeta en la que queremos guardar los pdfs,
      //si no existen las creamos y damos permisos
      // $this->createFolder();

      //importante el slash del final o no funcionará correctamente
      $this->pdf->folder( FCPATH . 'assets/uploads/comprobantes/salidas/');

      //establecemos el nombre del archivo
      $this->pdf->filename('salida_'. $output['number'] . '.pdf');

      //establecemos el tipo de papel
      $this->pdf->paper('a4', 'portrait');



      //hacemos que coja la vista como datos a imprimir
      //importante utf8_decode para mostrar bien las tildes
      if ($pdf_combustible) {
        $stock_combustible = $this->Product_model->get('id', 411);
        $data = array(
            'title' => 'Comprobante de salida N&deg;: '.$output['number'],
            'output' => $output,
            'products' => $products,
            'stock_combustible' => $stock_combustible[0]->stock,
            'cost_center' => $cost_center
        );
        $this->pdf->html(utf8_decode($this->load->view('system/outputs/pdf_combustible', $data, true)));
      } else {
        $data = array(
            'title' => 'Comprobante de salida N&deg;: '.$output['number'],
            'output' => $output,
            'products' => $products,
            'cost_center' => $cost_center
        );
        $this->pdf->html(utf8_decode($this->load->view('system/outputs/pdf', $data, true)));
      }
      // $this->pdf->html(utf8_encode($this->load->view('system/outputs/pdf', $data, true)));

      // Lo generamos , no imprimimos nada por la rta de ajax
      $this->pdf->create('save');
      //si el pdf se guarda correctamente lo mostramos en pantalla
      // if($this->pdf->create('save'))
      // {
      //     $this->show();
      // }
  }

  function create_pdf_water( $output , $products )
  {
    $this->pdf->folder( FCPATH . 'assets/uploads/comprobantes/salidas/');

    //establecemos el nombre del archivo
    $this->pdf->filename('salida_'. $output['number'] . '.pdf');

    //establecemos el tipo de papel
    $this->pdf->paper('a4', 'portrait');

    $data = array(
        'title' => 'Comprobante de salida N&deg;: '.$output['number'],
        'output' => $output,
        'products' => $products
    );
    $this->pdf->html(utf8_decode($this->load->view('system/outputs/pdf_water', $data, true)));
    $this->pdf->create('save');
  }

}
