<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once( dirname(__FILE__) . "/dompdf/autoload.inc.php");

use Dompdf\Dompdf;


class Pdf {

    var $html;
    var $path;
    var $filename;
    var $paper_size;
    var $orientation;

  function __construct( $params = array() )
  {
    // parent::__construct();

    $this->CI =& get_instance();

    if (count($params) > 0)
    {
        $this->initialize($params);
    }

    log_message('debug', 'PDF Class Initialized');
  }

  public function generate($html, $filename='', $stream=TRUE, $paper = 'A4', $orientation = "portrait")
  {
    $dompdf = new DOMPDF();
    $dompdf->loadHtml($html);
    $dompdf->setPaper($paper, $orientation);
    $dompdf->render();
    if ($stream) {
        $dompdf->stream($filename.".pdf", array("Attachment" => 0));
    } else {
        return $dompdf->output();
    }
  }

  // agregado

  function html($html = NULL)
  {
        $this->html = $html;
  }

  function folder($path)
  {
        $this->path = $path;
  }

  function filename($filename)
  {
        $this->filename = $filename;
  }

  function paper($paper_size = NULL, $orientation = NULL)
  {
        $this->paper_size = $paper_size;
        $this->orientation = $orientation;
  }


  function create($mode = 'download')
  {
      if (is_null($this->html)) {
      show_error("HTML is not set");
    }

      if (is_null($this->path)) {
      show_error("Path is not set");
    }

      if (is_null($this->paper_size)) {
      show_error("Paper size not set");
    }

    if (is_null($this->orientation)) {
      show_error("Orientation not set");
    }

      //Load the DOMPDF libary
      // require_once("dompdf/dompdf_config.inc.php");

      $dompdf = new DOMPDF();
      $dompdf->load_html($this->html);
      $dompdf->set_paper($this->paper_size, $this->orientation);
      $dompdf->render();

      if($mode == 'save') {
          $this->CI->load->helper('file');
        if(write_file($this->path.$this->filename, $dompdf->output())) {
          return $this->path.$this->filename;
        } else {
        show_error("PDF could not be written to the path ". $this->path);
        }
    } else {

      if($dompdf->stream($this->filename)) {
        return TRUE;
      } else {
        show_error("PDF could not be streamed");
      }
      }
  }
}