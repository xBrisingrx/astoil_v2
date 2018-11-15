<?php

class Rubro_model extends CI_Model {

  public $table = 'rubros';

  function __construct()
  {
    parent::__construct();
  }

  function get($attr = null, $valor = null)
  {
    if($attr != null and $valor != null)
    {
      $query = $this->db->select('*')
                          ->from($this->table)
                            ->where($this->table.'.'.$attr, $valor)
                              ->where($this->table.'.active', true)
                                ->order_by('name', 'asc')
                                  ->get();
      return $query->result();
    } else {
        return $this->db->get_where($this->table, array('active', true))->result();
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
