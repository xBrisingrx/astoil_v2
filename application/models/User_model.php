<?php
class User_model extends CI_Model {

// Rol es 1 para admin 2 para que solo ve info
  public $table = 'users';

  public function __construct()
  {
    parent::__construct();
  }

  // ===== Verificar que los datos sean correctos
  public function datosCorrectos($user)
  {
    $correcto = FALSE;
    $query = $this->db->get_where('users', array('email' => $user['email'], 'active' => TRUE));
    $password_correcto = $user['password'] == $this->encryption->decrypt($query->row()->password);
    if ( $password_correcto && ($query->num_rows() == 1) ) {
      $correcto = TRUE;
    }
    return $correcto;
  }

  // ======= Obtener todos los datos del user
  function get($attr = null, $valor = null)
  {
    if($attr != null and $valor != null)
    {
      $query = $this->db->get_where('users', array($attr => $valor, 'active' => true));
      if ($query->num_rows() == 1 ) {
        return $query->row();
      } else {
        return $query->result();
      }
    } else
      {
        return $this->db->get_where('users',array('active' => true))->result();
      }
  }

  // Obtengo los datos necesarios del user para cargar en las coockies
  public function getDataSesion($user)
  {
    $query = $this->db->select("id, username, email, rol")
                         ->from("users")
                           ->where("email", $user['email'])
                            ->get();
    return $query->row_array();
  }
  // ====== ALTA de un user
  public function insert_entry($user)
  {
    return $this->db->insert('users',$user);
  }

  function destroy($id)
  {
      $user = $this->db->get_where('users', array('id' => $id))->row();
      $user->active = false;
      $user->updated_at = date('Y-m-d H:i:s');

      $this->db->where('id', $id);
      return $this->db->update('users', $user);
  }

  function existe_email( $email )
  {
    $query = $this->db->get_where($this->table, array('email' => $email));
    return ( $query->num_rows() );
  }

}