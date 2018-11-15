<?php

class Entry_Products_model extends CI_Model {

  public $table = 'entry_products';

  function __construct()
  {
    parent::__construct();
  }

  function get($attr = null, $valor = null)
  {
    if($attr != null and $valor != null)
    {
      // Generalmente se usa para buscar por id
      $query = $this->db->select('products.name, entry_products.quantity, entry_products.price')
                          ->from($this->table)
                            ->join('products', $this->table.'.product_id = products.id')
                            ->join('entries', $this->table.'.entry_id = entries.id')
                              ->where('entries.id', $valor)
                              ->where($this->table.'.active', true)
                                  ->get();
      return $query->result();
    } else {
        $query = $this->db->select('entries.id, entries.number, types_entries.name as type, providers.name as provider')
                            ->from($this->table)
                              ->join('types_entries', $this->table.'.type_id = types_entries.id')
                              ->join('providers', $this->table.'.provider_id = providers.id')
                                ->where($this->table.'.active', true)
                                  ->order_by($this->table.'.number', 'asc')
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

  function existe_codigo( $codigo )
  {
    $query = $this->db->get_where($this->table, array('code' => $codigo));
    return ( $query->num_rows() != 0 );
  }

}
