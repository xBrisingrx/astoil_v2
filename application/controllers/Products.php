<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

  function __construct()
  {
    parent::__construct();
    $this->load->library('form_validation');
    $this->load->model('Product_model');
    $this->load->model('Rubro_model');
    $this->load->model('Cost_center_model');
    if ( empty( $this->session->username ) ) {
      redirect('Login');
    }
  }

  function index()
  {
    $title['title'] = 'Productos';
    $data['rubros'] = $this->Rubro_model->get();
    $this->load->view('includes/header', $title);
    $this->load->view('includes/nav');
    $this->load->view('system/products/index', $data);
    $this->load->view('includes/footer');
  }

  function create()
  {
    $this->form_validation->set_rules('code', 'Codigo', 'required|is_unique[products.code]');
    if ( $this->form_validation->run() == TRUE ) {
        $product = array(
        'code' => $_POST['code'],
        'name' => $_POST['name'],
        'rubro_id' => $_POST['rubro_id'],
        'suggested_price' => $_POST['suggested_price'],
        'stock_min' => $_POST['stock_min'],
        'description' => $_POST['description'],
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
        'user_created_id' => $this->session->userdata('id'),
        'user_last_updated_id' => $this->session->userdata('id'),
        'active' => true
      );

      if ($this->Product_model->insert_entry($product)) {
        echo 'ok';
      } else {
        echo 'error';
      }
    } else {
      echo 'bug';
    }
  }

  function get_for_id($id)
  {
    echo json_encode( $this->Product_model->get('id', $id) );
  }

  function update()
  {
    $id = $_POST['id'];
    $product = array(
      'code' => $_POST['code'],
      'name' => $_POST['name'],
      'rubro_id' => $_POST['rubro_id'],
      'suggested_price' => $_POST['suggested_price'],
      'stock_min' => $_POST['stock_min'],
      'description' => $_POST['description'],
      'created_at' => date('Y-m-d H:i:s'),
      'updated_at' => date('Y-m-d H:i:s'),
      'user_last_updated_id' => $this->session->userdata('id'),
    );

    if ($this->Product_model->update_entry($id, $product)) {
      echo 'ok';
    } else {
      echo 'error';
    }
  }

  function destroy( $id )
  {
    if ( $this->Product_model->destroy( $id ) ) {
      echo 'ok';
    } else {
      echo 'Error';
    }
  }

  function ajax_list_products()
  {
    $products = $this->Product_model->get();
    $data = array();

    foreach ($products as $p) {

      $row = array();
      $row[] = $p->code;
      $row[] = $p->name;
      $row[] = $p->rubro_name;
      $row[] = $p->description;
      $row[] = '$ '.$p->suggested_price;
      $row[] = $p->stock;
      $row[] = $p->stock_min;
       if ( $this->session->userdata('rol') == 1 ) {
        $row[] = '<button class="btn btn-sm u-btn-primary g-mr-10 g-mb-15" title="Editar" onclick="edit_product('."'".$p->id."'".')" ><i class="fa fa-edit"></i></button> <button class="btn btn-sm u-btn-red g-mr-10 g-mb-15" title="Eliminar" onclick="delete_product('."'".$p->id."'".')" ><i class="fa fa-trash-o"></i></button>';
      } else {
        $row[] = '<button class="btn btn-sm u-btn-primary g-mr-10 g-mb-15" title="Editar" disabled ><i class="fa fa-edit"></i></button> <button class="btn btn-sm u-btn-red g-mr-10 g-mb-15" title="Eliminar" disabled ><i class="fa fa-trash-o"></i></button>';
      }
      $data[] = $row;
    }

    $output = array("data" => $data);
    echo json_encode($output);
  }

  function get_last_code($rubro_id)
  {
    echo json_encode( $this->Product_model->get_last_code($rubro_id) );
  }

  function existe_codigo(  )
  {
    $code = $this->input->post('code');
    $product_id = $this->input->post('product_id');
    if ( $this->Product_model->existe_codigo( $code, $product_id ) != 0 ) {
      echo 'false';
    } else {
      echo 'true';
    }
  }

  function Informes()
  {
    $title['title'] = 'Informes de productos';
    $data['rubros'] = $this->Rubro_model->get();
    $this->load->view('includes/header', $title);
    $this->load->view('includes/nav');
    $this->load->view('system/products/informes', $data);
    $this->load->view('includes/footer');
  }

  function excel_productos()
  {
    $rubro = $this->input->post('rubro_id');
    $this->load->library('Excel');
    // Informe matriz del personal
    if ($rubro != 0) {
      $rubro_name = $this->Rubro_model->get('id', $rubro);
      $name = $rubro_name[0]->name;
      $data = $this->Product_model->get('rubro_id', $rubro);
    } else {
      $name = 'Todos';
      $data = $this->Product_model->get();
    }


    $styleArray = array(
        'borders' => array(
            'allborders' => array(
                'style' => PHPExcel_Style_Border::BORDER_THIN
            )
        )
    );

    if ($data > 0) {
      $this->excel->setActiveSheetIndex(0);
      // $this->excel->getDefaultStyle()->applyFromArray($styleArray);
      $this->excel->getActiveSheet()->setTitle('Productos cargados');
      // Contador de filas en 2 porque la 1 se usa para el titulo
      $contador = 2;
      // Titulo en el excel
      $this->excel->getActiveSheet()->setCellValue('A1', 'Productos cargados - Rubro '.$name);
      $this->excel->getActiveSheet()->mergeCells('A1:E1');
      $this->excel->getActiveSheet()->getStyle('A1:E1')->applyFromArray($styleArray);
      $this->excel->getActiveSheet()->getStyle("A1")->getFont()->setBold(true);


      // Aplicamos el ancho a las columnas
      $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
      $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
      $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
      $this->excel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
      $this->excel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
      //Le aplicamos negrita a los títulos de la cabecera.
      $this->excel->getActiveSheet()->getStyle("A{$contador}")->getFont()->setBold(true);
      $this->excel->getActiveSheet()->getStyle("B{$contador}")->getFont()->setBold(true);
      $this->excel->getActiveSheet()->getStyle("C{$contador}")->getFont()->setBold(true);
      $this->excel->getActiveSheet()->getStyle("D{$contador}")->getFont()->setBold(true);
      $this->excel->getActiveSheet()->getStyle("E{$contador}")->getFont()->setBold(true);
      //Definimos los títulos de la cabecera.
      $this->excel->getActiveSheet()->setCellValue("A{$contador}", 'Codigo');
      $this->excel->getActiveSheet()->setCellValue("B{$contador}", 'Producto');
      $this->excel->getActiveSheet()->setCellValue("C{$contador}", 'Descripcion');
      $this->excel->getActiveSheet()->setCellValue("D{$contador}", 'Stock en sistema');
      $this->excel->getActiveSheet()->setCellValue("E{$contador}", 'Stock real');
      $this->excel->getActiveSheet()->getStyle("A2:E2")->applyFromArray($styleArray);
      //Definimos la data del cuerpo.
      foreach($data as $d){
         //Incrementamos una fila más, para ir a la siguiente.
         $contador++;
         //Informacion de las filas de la consulta.
         $this->excel->getActiveSheet()->setCellValue("A{$contador}", $d->code);
         $this->excel->getActiveSheet()->setCellValue("B{$contador}", $d->name);
         $this->excel->getActiveSheet()->setCellValue("C{$contador}", $d->description);
         $this->excel->getActiveSheet()->setCellValue("D{$contador}", $d->stock);
         $this->excel->getActiveSheet()->setCellValue("E{$contador}", '    ');

         $this->excel->getActiveSheet()->getStyle("A{$contador}:E{$contador}")->applyFromArray($styleArray);
      }
      //Le ponemos un nombre al archivo que se va a generar.
      $archivo = "Lista_productos_cargados.xls";
      header('Content-Type: application/vnd.ms-excel');
      header('Content-Disposition: attachment;filename="'.$archivo.'"');
      header('Cache-Control: max-age=0');
      $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
      //Hacemos una salida al navegador con el archivo Excel.
      $objWriter->save('php://output');
    } else{
      echo "No se han encontrado resultados";
      exit;
    }
  }

}
