<?php

class Output_Products_model extends CI_Model {

  public $table = 'output_products';

  function __construct()
  {
    parent::__construct();
  }

  function get($attr = null, $valor = null)
  {
    if($attr != null and $valor != null)
    {
      // Generalmente se usa para buscar por id
      $query = $this->db->select('products.name, output_products.quantity, output_products.price')
                          ->from($this->table)
                            ->join('products', $this->table.'.product_id = products.id')
                            ->join('outputs', $this->table.'.output_id = outputs.id')
                              ->where('outputs.id', $valor)
                              ->where($this->table.'.active', true)
                                  ->get();
      return $query->result();
    } else {
        $query = $this->db->select('outputs.id, outputs.number, products.name as product_name')
                            ->from($this->table)
                              ->join('outputs', $this->table.'.output_id = outputs.id')
                              ->join('products', $this->table.'.product_id = products.id')
                                ->where($this->table.'.active', true)
                                  ->order_by($this->table.'.id', 'asc')
                                    ->get();
        return $query->result();
      }
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

  function destroy($id)
  {
    $entry = $this->db->get_where($this->table, array('id' => $id))->row();
    $entry->active = false;
    $entry->updated_at = date('Y-m-d H:i:s');

    $this->db->where('id', $id);
    return $this->db->update($this->table, $entry);
  }


}
