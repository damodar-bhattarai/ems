<?php 
/*
*To make the user logged in 0 in database when the user logs off 
*/
class Logout_user_model extends CI_Model
{
	public function logout()
	{
		$id= $_SESSION['user_id'];
		$data = [ 'is_logged_in' => '0'];

		$this->db->where('user_id', $id);
        $this->db->update('users', $data);
	}
}
?>