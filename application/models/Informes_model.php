<?php

class Informes_model extends CI_Model {

  function __construct()
  {
    parent::__construct();
  }

  function get_outputs_por_fecha($desde, $hasta, $cost_center_id)
  {
    $query = $this->db->select('outputs.id,outputs.created_at as fecha, outputs.number as output')
                          ->from('outputs')
                            ->where('outputs.created_at >=', $desde)
                            ->where('outputs.created_at <=', $hasta)
                            ->where('outputs.cost_center_id', $cost_center_id)
                              ->order_by('outputs.created_at', 'asc')
                                ->get();
    return $query->result();
  }

  function get_products_por_fecha($desde, $hasta, $cost_center_id)
  {
    $query = $this->db->select('outputs.id,products.name , sum(output_products.quantity) as cantidad')
                          ->from('output_products')
                            ->join('outputs', 'output_products.output_id = outputs.id')
                            ->join('products', 'output_products.product_id = products.id')
                              ->where('outputs.created_at >=', $desde)
                              ->where('outputs.created_at <=', $hasta)
                              ->where('outputs.cost_center_id', $cost_center_id)
                                ->group_by('output_products.product_id')
                                  ->order_by('products.name', 'asc')
                                    ->get();
    return $query->result();
  }

  function sumar_productos_salida($output_id)
  {
    $query = $this->db->select('price, quantity')
                        ->from('output_products')
                          ->where('output_products.output_id', $output_id)
                            ->get();
    return $query->result();
  }



}
