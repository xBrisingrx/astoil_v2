<?php

class Product_model extends CI_Model {

  public $table = 'products';

  function __construct()
  {
    parent::__construct();
  }

  function get($attr = null, $valor = null)
  {
    if($attr != null and $valor != null)
    {
      // Generalmente se usa para buscar por id
      $query = $this->db->select('*')
                          ->from($this->table)
                            ->where($this->table.'.'.$attr, $valor)
                              ->where($this->table.'.active', true)
                                ->order_by('name', 'asc')
                                  ->get();
      return $query->result();
    } else {
        $query = $this->db->select('products.id, products.code, products.name, products.suggested_price, products.description,
                                    products.stock, products.stock_min, products.stock, products.active, products.rubro_id,
                                    rubros.name as rubro_name')
                            ->from($this->table)
                              ->join('rubros', $this->table.'.rubro_id = rubros.id')
                                ->where($this->table.'.active', true)
                                  ->order_by($this->table.'.name', 'asc')
                                    ->get();
        return $query->result();
      }
  }

  function get_masivos()
  {
    // Retorno los productos que desean agregarlos de forma masiva a distintos centros de costo
    $query = $this->db->select('*')
                        ->from($this->table)
                          ->join('rubros', $this->table.'.rubro_id = rubros.id')
                            ->where('rubros.id', 13)
                            ->like('products.name', 'BIDON')
                              ->order_by($this->table.'.name', 'asc')
                                ->get();
    return $query->result();
  }

  function get_water()
  {
    // genero esta funcion xq debo buscar con like en nombre del producto, ya que el agua no tiene un rubro
    $query = $this->db->select('*')
                        ->from($this->table)
                            ->like('products.name', 'BIDON')
                              ->order_by($this->table.'.name', 'asc')
                                ->get();
    return $query->result();
  }


  function insert_entry($entry)
  {
    return $this->db->insert($this->table, $entry);
  }

  function update_entry($id, $entry)
  {
    $this->db->where('id', $id);
    return $this->db->update($this->table, $entry);
  }

  function update_stock_price( $id , $stock, $price )
  {

  }

  function destroy($id)
  {
      $entry = $this->db->get_where($this->table, array('id' => $id))->row();
      $entry->active = false;
      $entry->updated_at = date('Y-m-d H:i:s');

      $this->db->where('id', $id);
      return $this->db->update($this->table, $entry);
  }

  function get_last_code($rubro_id)
  {
    $query = $this->db->select('*')
                        ->from($this->table)
                          ->where('rubro_id', $rubro_id)
                          ->where('active', true)
                            ->limit(1)
                              ->order_by('id', 'DESC')
                                ->get()->row();
    return $query->code;

    // $query = $this->db->select('*')
    //                     ->from($this->table)
    //                       ->where('rubro_id', $rubro_id)
    //                       ->where('active', true)
    //                           ->order_by('id', 'DESC')
    //                             ->get();
    // return $query->result();
  }

  function existe_codigo( $code, $product_id )
  {
    if ($product_id != '') {
      $query = $this->db->select('*')
                        ->from($this->table)
                          ->where('code', $code)
                          ->where('id !=', $product_id)
                            ->get();
    } else {
      $query = $this->db->get_where($this->table, array('code' => $code));
    }
    return ( $query->num_rows() );
  }

  // function validate_number( $number )
  // {
  //   $query = $this->db->get_where($this->table, array('number' => $number));
  //   return ( $query->num_rows() );
  // }

}
