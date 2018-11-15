<?php

class Output_Multiple_Cost_Center_model extends CI_Model {

  public $table = 'output_multiple_cost_center';

  function __construct()
  {
    parent::__construct();
  }

  function get($attr = null, $valor = null)
  {
    if($attr != null and $valor != null)
    {
      // Generalmente se usa para buscar por id
      $query = $this->db->select('products.name as product_name, output_multiple_cost_center.quantity,
                                  output_multiple_cost_center.price, output_multiple_cost_center.km_hs,
                                  cost_center.name as cost_center_name')
                          ->from($this->table)
                            ->join('products', $this->table.'.product_id = products.id')
                            ->join('outputs', $this->table.'.output_id = outputs.id')
                            ->join('cost_center', $this->table.'.cost_center_id = cost_center.id')
                              ->where('outputs.id', $valor)
                              ->where($this->table.'.active', true)
                                  ->get();
      return $query->result();
    } else {
        $query = $this->db->select('products.name as product_name, output_multiple_cost_center.quantity,
                                    output_multiple_cost_center.price,output_multiple_cost_center.km_hs,
                                    cost_center.name as cost_center_name')
                            ->from($this->table)
                              ->join('outputs', $this->table.'.output_id = outputs.id')
                              ->join('products', $this->table.'.product_id = products.id')
                               ->join('cost_center', $this->table.'.cost_center_id = cost_center.id')
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
