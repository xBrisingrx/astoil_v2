<?php

class Output_model extends CI_Model {

  public $table = 'outputs';

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
                                ->order_by('number', 'asc')
                                  ->get();
      return $query->result();
    } else {
        $query = $this->db->select('outputs.id, outputs.number, cost_center.id as cost_center_id,cost_center.name as cost_center, outputs.comment, outputs.pdf_path')
                            ->from($this->table)
                              ->join('cost_center', $this->table.'.cost_center_id = cost_center.id')
                                ->where($this->table.'.active', true)
                                  ->order_by($this->table.'.number', 'asc')
                                    ->get();
        return $query->result();
      }
  }

  function get_last_number()
  {
    $query = $this->db->select('*')
                        ->from($this->table)
                          ->where('active', true)
                            ->limit(1)
                              ->order_by('id', 'DESC')
                                ->get()->row();
    return $query->number;
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
  }

  // function existe_codigo( $codigo )
  // {
  //   $query = $this->db->get_where($this->table, array('code' => $codigo));
  //   return ( $query->num_rows() != 0 );
  // }

  function get_last_id()
  {
    $query = $this->db->select('*')
                        ->from($this->table)
                          ->where('active', true)
                            ->limit(1)
                              ->order_by('id', 'DESC')
                                ->get()->row();
    return $query->id;
  }

  function validate_number( $number )
  {
    $query = $this->db->get_where($this->table, array('number' => $number));
    return ( $query->num_rows() );
  }

}
