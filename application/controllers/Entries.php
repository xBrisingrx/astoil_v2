<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Entries extends CI_Controller {
// Ingreso de productos por medio de remitos/facturas
  function __construct()
  {
    parent::__construct();
    $this->load->library('Pdf');
    $this->load->library('form_validation');
    $this->load->model('Entry_model');
    $this->load->model('Provider_model');
    $this->load->model('Type_Entry_Model');
    $this->load->model('Entry_Products_model');
    $this->load->model('Product_model');
    if ( empty( $this->session->username ) ) {
      redirect('Login');
    }
  }

  function index()
  {
    $title['title'] = 'Ingresos';
    $data['entry_types'] = $this->Type_Entry_Model->get();
    $data['proveedores'] = $this->Provider_model->get();
    $data['productos'] = $this->Product_model->get();
    $this->load->view('includes/header', $title);
    $this->load->view('includes/nav');
    $this->load->view('system/entries/index', $data);
    $this->load->view('includes/footer');
  }

  function create()
  {
    $this->form_validation->set_rules('number', 'Numero', 'required|is_unique[entries.number]');
    if ( $this->form_validation->run() == TRUE ) {
      $entry = array(
        'number' => $_POST['number'],
        'factura_number' => $_POST['factura_number'],
        'type_id' => $_POST['type_id'],
        'provider_id' => $_POST['provider_id'],
        'pdf_path' => 'ingreso_'.$_POST['number'].'.pdf',
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'user_created_id' => $this->session->userdata('id'),
        'user_last_updated_id' => $this->session->userdata('id'),
        'active' => true
      );

      if ($this->Entry_model->insert_entry($entry)) {
        $productos_cargados = true;
        $ultima_entrada_id = $this->Entry_model->get_last_id();
        $productos_json = json_decode( $_POST['list_products'] );
        $total = 0.0;
        foreach ( $productos_json as $p ) {
          if ($p->cargar) {
            $product = array(
                'entry_id' => $ultima_entrada_id,
                'product_id' => $p->product_id,
                'quantity' => $p->quantity,
                'price' => $p->price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
                'user_created_id' => $this->session->userdata('id'),
                'user_last_updated_id' => $this->session->userdata('id'),
                'active' => true
            );
            $total += ( $p->quantity * $p->price ); // total va al pdf
            if (!$this->Entry_Products_model->insert_entry( $product )) {
              $productos_cargados = false;
            } else {
              $product_update = $this->Product_model->get('id', $p->product_id);
              $product_update[0]->suggested_price = $p->price;
              $product_update[0]->stock+=$p->quantity;

              $this->Product_model->update_entry($p->product_id, $product_update[0] );
            } // End if insert product
          }
        } // End for
        if ( $productos_cargados ) {
          $this->create_pdf( $entry , $productos_json, $total );
          echo 'ok';
        } else {
          echo 'Error al cargar productos';
        }
      } else {
        echo 'error al cargar ingreso';
      }
    } else {
      echo 'bug'; /* error que duplica el create */
    }

  }

  function get_for_id($id)
  {
    echo json_encode( $this->Entry_model->get('id', $id) );
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

    if ($this->Entry_model->update_entry($id, $provider)) {
      $this->create_pdf();
      echo 'ok';
    } else {
      echo 'error';
    }
  }

  function destroy( $id )
  {
    if ( $this->Entry_model->destroy( $id ) ) {
      echo 'ok';
    } else {
      echo 'Error';
    }
  }

  function ajax_list_entries()
  {
    $entries = $this->Entry_model->get();
    $data = array();

    foreach ($entries as $e) {
      $url_pdf = base_url('assets/uploads/comprobantes/ingresos/').$e->pdf_path;
      $row = array();
      $row[] = $e->number;
      // $row[] = $e->factura_number;
      $row[] = $e->provider;
      $row[] = $e->type;
      $row[] = "<a href=". $url_pdf ." target='_blank' class='text-center'><i class='fa fa-file-pdf-o fa-2x'></i></a>";
      $row[] = '<button class="btn u-btn-orange" title="Ver" onclick="entry_details('."'".$e->id."'".')" ><i class="fa fa-eye"></i></button>';
      $data[] = $row;
    }

    $output = array("data" => $data);
    echo json_encode($output);
  }

  function ajax_list_products_entry( $id )
  {
    $products = $this->Entry_Products_model->get('entry_id', $id);
    $data = array();
    foreach ($products as $p) {
      $row = array();
      $row[] = $p->name;
      $row[] = $p->quantity;
      $row[] = $p->price;
      $data[] = $row;
    }
    $output = array("data" => $data);
    echo json_encode($output);
  }

  function get_last_number()
  {
    echo $this->Entry_model->get_last_number();
  }

  function existe_codigo( $codigo )
  {
    if ( $this->Entry_model->existe_codigo($codigo) ) {
      echo 'true';
    } else {
      echo 'false';
    }
  }

  function validar_numero_entrada()
  {
    $number = $_POST['number'];
    if ( $this->Entry_model->validate_number( $number ) != 0 ) {
      echo 'false';
    } else {
      echo 'true';
    }
  }

// Generacion del PDF comprobante
  function createFolder()
  {
      if(!is_dir("./assets/content"))
      {
          mkdir("./assets/content", 0777);
          mkdir("./assets/content/pdfs", 0777);
      }
  }


  function create_pdf( $entry , $products , $total )
  {
      $type_entry  = $this->Type_Entry_Model->get('id', $entry['type_id']);
      //establecemos la carpeta en la que queremos guardar los pdfs,
      //si no existen las creamos y damos permisos
      // $this->createFolder();

      //importante el slash del final o no funcionará correctamente
      $this->pdf->folder( FCPATH . 'assets/uploads/comprobantes/ingresos/');

      //establecemos el nombre del archivo
      $this->pdf->filename('ingreso_'. $entry['number'] . '.pdf');

      //establecemos el tipo de papel
      $this->pdf->paper('a4', 'portrait');

      //datos que queremos enviar a la vista, lo mismo de siempre
      $data = array(
          'title' => 'Comprobante de ingreso N&deg;: '.$entry['number'],
          'entry' => $entry,
          'products' => $products,
          'type_entry' => $type_entry,
          'total' => $total
      );

      //hacemos que coja la vista como datos a imprimir
      //importante utf8_decode para mostrar bien las tildes
      $this->pdf->html(utf8_decode($this->load->view('system/entries/pdf', $data, true)));
      // $this->pdf->html(utf8_encode($this->load->view('system/entries/pdf', $data, true)));
      // Lo generamos , no imprimimos nada por la rta de ajax
      $this->pdf->create('save');
      //si el pdf se guarda correctamente lo mostramos en pantalla
      // if($this->pdf->create('save'))
      // {
      //     $this->show();
      // }
  }

}
