<?php
	class Admin_model extends CI_Model {
		
		public function assign($data,$id){
			$this->db->where('emp_id',$id);	
			$list=$this->db->get('employee_approvers');

			$getList= $list->row_array();
			if(count($getList)==0)
			return $this->db->insert('employee_approvers',$data);
			else{
			$this->db->where('emp_id',$id);	
			return $this->db->update('employee_approvers',$data);
			}
		}
		public function insert_leave_balance($data){			
			$this->db->insert('employee_leave_balance',$data);
		}

		public function delete_leave_balance($id){
			$this->db->where('emp_id',$id);
			$this->db->delete('employee_leave_balance');
		}
	
		public function assignList(){
			$result=$this->db->get('employee_approvers');
			return $result->result_array();
		}
		public function getAssign($id){
			$this->db->where('emp_id',$id);
			$list=$this->db->get('employee_approvers');
			return $list->row_array();
		}
		public function update_employee($data,$userid='')
		{
			if(!isset($_SESSION['user_id'])) $this->load->view('login/login');
			if($userid==''){
				$userid=$_SESSION['user_id'];
			}
			$this->db->where('emp_id',$userid);	
			return $this->db->update('employees',$data);
		}

		public function employeeList() {
			$this->db->join('departments', 'departments.id=employees.department_id');
			$this->db->where('is_active', '1');
			// $this->db->limit($limit, $offset); 
			$query = $this->db->get('employees');
			// echo count($query->result_array()); die();
			// echo '<pre>' . var_dump($query->result_array()) . '</pre>'; die();
			return $query->result_array();
		}

		// list of managers
		public function getManagerList(){
			$this->db->join('managers','managers.emp_id=employees.emp_id');
			$res=$this->db->get('employees');	
			return $res->result_array();
		}


		public function validEmployee() {
			$this->db->select('employees.emp_id,employees.first_name,employees.middle_name,employees.last_name');
			$this->db->join('departments', 'departments.id=employees.department_id');
			$this->db->where('is_active', '1');
			// $this->db->limit($limit, $offset); 
			$query = $this->db->get('employees');
			// echo count($query->result_array()); die();
			// echo '<pre>' . var_dump($query->result_array()) . '</pre>'; die();
			return $query->result_array();
		}
		public function invalidEmployee() {
			$this->db->select('employees.emp_id,employees.first_name,employees.middle_name,employees.last_name');
			$this->db->join('departments', 'departments.id=employees.department_id');
			$this->db->join('employee_leaves','employees.emp_id=employee_leaves.emp_id');
			$this->db->where('is_active', '1');
			$query = $this->db->get('employees');
	
			return $query->result_array();
		}

		public function archivedEmployeeList() {
			$this->db->where('is_active', '0');
			$this->db->join('departments', 'departments.id=employees.department_id');
			$query = $this->db->get('employees');

			return $query->result_array();
		}
		// leave page
		public function leaveManage() 
		{
			$query = $this->db->get('leaves');
			return $query->result_array();
		}

		//leave assigned in package
		public function assignedLeave(){
			$query = $this->db->get('leave_packages');
			return $query->result_array();
		}
		// update
		public function getLeaveDetails($id)
		{
			$this->db->where('leave_id',$id);
			$query = $this->db->get('leaves');
			return $query->row_array();
		}

		// update
		public function getPackageName($id)
		{
			$this->db->where('package_id',$id);
			$query = $this->db->get('packages');
			return $query->row_array();
		}
		public function getPackageId($id){
			$this->db->where('emp_id',$id);
			$query = $this->db->get('employees');
			$data= $query->row_array();
			return $data['package_id'];
		}

		//package assigned to person
		public function assignedPackage(){
			$query = $this->db->get('employees');
			return $query->result_array();
		}

		public function getPackageDetails($id)
		{
			$this->db->where('package_id',$id);
			$query=$this->db->get('leave_packages');
			return $query->result_array();
		}


		// package lists
		public function packageManage() {
			$query = $this->db->get('packages'); 
			return $query->result_array();
 			}
  
		public function add_employee($data,$password)
		{
			// save('employees',$data, $pk = '',$id='')
			$this->db->insert('employees',$data);
			$user_id = $this->db->insert_id();
			// this helps to set session id for admin to add more info
			//sets the curent new staff's id in session
			$_SESSION['current_employee_id']=$this->db->insert_id();
			$userData=array(
					'user_id'=>$user_id,
					'user_pass'=>password_hash($password, PASSWORD_DEFAULT),
			);
			$this->db->insert('users',$userData);
			$user_num=$this->db->insert_id();

			$this->db->where('role_name','employee');
			$roleid= $this->db->get('roles');
			$rid= $roleid->row_array();
			$userRoleData=array(
				'user_id'=>$user_num,
				'role_id'=>$rid['role_id']
			);
			 $this->db->insert('user_roles',$userRoleData);
			 return $user_id;
		}

		public function user_detail($tablename,$userid){
			$user=$this->db->get_where($tablename,$userid);	
			return $user->row_array();
		}

		// For Address
		public function getAddress($data) {
			$query = $this->db->get_where('address', $data);
			return $query;
		}

		public function update_address($data,$userid=''){
			if($userid==''){
				$userid=$_SESSION['user_id'];
			}
			$this->db->insert('addresses',$data);
			$insertedId=$this->db->insert_id();
			return $insertedId;
		}

		public function update_employee_address($primary,$secondary,$userid=''){
			if($userid==''){
				$userid=$_SESSION['user_id'];
			}
			$data=array(
				'primary_addressId'=>$primary,
				'secondary_addressId'=>$secondary,
				'emp_id'=>$userid
			);


			// first checking whether the emp_id exists or not
			// If emp_id exists then updating table
			// else inserting row

			$this->db->where('emp_id',$userid);
			$check = $this->db->get('employee_addresses');

			if ( $check->num_rows() > 0 ) 
			{
			$this->db->where('emp_id',$userid);
			$this->db->update('employee_addresses',$data);
			} else {
			$this->db->set('emp_id', $userid);
			$this->db->insert('employee_addresses',$data);
			}

		}

			// for contact form
		public function update_contact($data,$userid='')
		{
			if($userid==''){
				$userid=$_SESSION['user_id'];
		}
			$this->db->insert('contacts',$data);
			$insertedId=$this->db->insert_id();
			return $insertedId;
		}

		public function update_employee_contact($contact,$userid='')
		{
			if($userid==''){
				$userid=$_SESSION['user_id'];
			}
			$data=array(
				'contact_id'=>$contact,
				'emp_id'=>$userid
			);	

			// first checking whether the emp_id exists or not
			// If emp_id exists then updating table
			// else inserting row

			$this->db->where('emp_id',$userid);
			$check = $this->db->get('employee_contacts');

			if ( $check->num_rows() > 0 ) 
			{
			$this->db->where('emp_id',$userid);
			$this->db->update('employee_contacts',$data);
			} else {
			$this->db->set('emp_id', $userid);
			$this->db->insert('employee_contacts',$data);
			}
		}


		// documents
		public function add_documents($data) {
			return	$this->db->insert('employee_documents',$data);
		}

		//contact 
		public function add_contact($data) {
			return	$this->db->insert('contacts',$data);
		}

		//work experience
		public function add_work_experience($value){
			return $this->db->insert('employee_work_experience',$value);
		}
		//work experience
		public function update_work_experience($value,$id){
			$this->db->where('id',$id);
		return $this->db->update('employee_work_experience',$value);
		}
			



	
	// update function
		public function update($tablename,$data,$pk,$id)
		{
			$this->db->where($pk, $id);
			$this->db->update($tablename, $data);
			return true;
		}

		// insert function
		 public function insert($tablename,$data)
		 {
			$this->db->insert($tablename,$data);
			return true;
		}


		// public save function\
		public function save($tablename,$data, $pk = '',$id='')
		{
			try{ insert_table($tablename,$data); }
	       
	   		catch(Exception $e){  update_table($tablename,$data, $pk);  }
		}
		
		// querying all data related to employee
		public function getEmployeeDetails($id = FALSE) {

			$project = "SELECT *, e.email as email,
				               a.street as p_street, a.municipality as p_municipality, a.district as p_district, a.state as p_state, a.country as p_country, 
				               asec.street as t_street, asec.municipality as t_municipality, asec.district as t_district, asec.state as t_state, asec.country as t_country
					    FROM employees e
					    JOIN departments d ON d.id = e.department_id
					    LEFT JOIN employee_addresses ea ON ea.emp_id = e.emp_id
					    LEFT JOIN addresses a ON a.address_id = ea.primary_addressId
					    LEFT JOIN addresses asec ON asec.address_id = ea.secondary_addressId 
					    LEFT JOIN employee_contacts ec ON ec.emp_id = e.emp_id
					    LEFT JOIN contacts c ON c.contact_id = ec.contact_id";

			if ($id === FALSE) {	
				$project = $project . ' WHERE e.is_active = ' . 1;
				$this->db->order_by('emp_id', 'DESC');
				$query = $this->db->query($project);
				// var_dump($query->result_array()); die();
				return $query->result_array();
			}

			$project = $project . ' WHERE e.emp_id = ' . $id;
			$query = $this->db->query($project);
			
			return $query->row_array();
		}	

		//employee's recommender and approver
		public function getRecommenderApprover($id)
		 {
		 	
			$this->db->join('employees', 'employee_approvers.emp_id = employees.emp_id');
			$query = $this->db->get('employee_approvers');
			return $query->row_array();
		 } 

		public function findAllByCertainMonth($table, $field, $DMY, $date)
		{
			return $this->db->query('SELECT * FROM ' . $table . ' WHERE '. $DMY.'(' . $field . ') = ' . $date . '')->result_array();
			// return $this->db->query('SELECT id FROM ' . $table . ' WHERE MONTH(' . $field . ') = ' . $date . '')->result_array();
		}

		// delete Files from the database
		public function deleteFile($path,$id)
		{
			$this->db->where('doc_id',$id);
			$this->db->delete('employee_documents');
			 unlink($path);

		}

		// to delete work experience record from the database
		public function deleteWorkExperience($id)
		{
			$this->db->where('id',$id);
			if($this->db->delete('employee_work_experience')) return "success"; else return "error";
		}

public function sendEmail($title,$message,$email){


$data=[
		'email'=>$email,
		'title'=>$title,
		'message'=>nl2br($message)
		];
$this->db->insert('email_notifications',$data);

}

public function getEmail($id=''){
	if($id=='') $id=$_SESSION['user_id'];

	$this->db->where('emp_id',$id);
	$query= $this->db->get('employees');
	$detail=$query->row_array();
	return $detail['email'];
}

public function getName($id){
	$this->db->where('emp_id',$id);
	$query= $this->db->get('employees');
	$detail=$query->row_array();
	$name=$detail['first_name'].' '.$detail['middle_name'].' '.$detail['last_name'];
	return $name;
}

public function getNameByLid($id){
	$this->db->where('leave_id',$id);
	$query= $this->db->get('leaves');
	$detail=$query->row_array();
	return $detail['leave_name'];
}

public function getNameById($id){
	$this->db->where('id',$id);
	$query= $this->db->get('employee_leaves');
	$detail=$query->row_array();

	$this->db->where('leave_id',$detail['leave_id']);
	$query= $this->db->get('leaves');
	$detail=$query->row_array();
	return $detail['leave_name'];
}

public function getRecommenderId($id){
	$this->db->where('emp_id',$id);
	$query=$this->db->get('employee_approvers');
	$detail=$query->row_array();
	return $detail['recommender_id'];
}

public function getApproverId($id){
	$this->db->where('emp_id',$id);
	$query=$this->db->get('employee_approvers');
	$detail=$query->row_array();
	return $detail['approver_id'];
}
public function getEmpIdbyLID($id){
	$this->db->where('leave_id',$id);
	$query= $this->db->get('employee_leaves');
	$detail=$query->row_array();
	return $detail['emp_id'];
}

public function leaveDetail(){

}

public function getAllLeaves(){
	$this->db->join('leaves','employee_leaves.leave_id=leaves.leave_id');
	$this->db->join('employees','employees.emp_id=employee_leaves.emp_id');
	$query=$this->db->get('employee_leaves');
	return $query->result_array();
}
public function getTodayLeaves(){
	$this->db->join('leaves','employee_leaves.leave_id=leaves.leave_id');
	$this->db->join('employees','employees.emp_id=employee_leaves.emp_id');
	$this->db->where('employee_leaves.is_approved','approved');
	$this->db->where('employee_leaves.is_recommended','recommended');
	$query=$this->db->get('employee_leaves');
	return $query->result_array();
}




}












