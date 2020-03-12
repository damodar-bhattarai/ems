<?php
class Admin_controller extends CI_Controller {

 	public function __construct()
        {
           parent::__construct();
           if (!isset($_SESSION['loggedin'])|| $_SESSION['loggedin']!=true || $_SESSION['type']!='admin') {
				redirect('login');
			}
			if(isset($_SESSION['changed'])&&$_SESSION['changed']!='1'){
                    $_SESSION['changePasswordMsg']="Change Your Password Before Logging In";
                    redirect('changePassword');
             }       
			  date_default_timezone_set('Asia/Kathmandu');

        }
		
	public function view($page, $title = 'EMS', $data = FALSE) {
		if (!file_exists(APPPATH . 'views/admin/pages/' . $page . '.php')) 
			show_404();
		$this->load->view('admin/templates/header', $title);
		$this->load->view('admin/pages/' . $page . '', $data);
		$this->load->view('admin/templates/footer');
	}

	
	

	public function dashboard() 
	{
		$title['title'] = 'Dashboard';
		$data['count'] = count($this->Database_model->findAll('employees'));
		$data['assigned']=count($this->Admin_model->assignList());
		//get leave requested by all employees
		$data['employee_leaves'] = $this->Employee_model->findAllLeaves();
		$data['employee_leaves_all'] = $this->Admin_model->getAllLeaves();		
		$data['managerList']=$this->Admin_model->getManagerList();
		$data['remaining']=$data['count']-$data['assigned'];
		

		$data['emp_added_this_month'] = count($this->Admin_model->findAllByCertainMonth('employees', 'created_date', 'MONTH', date('m')));

		
		$validEmployee=$this->Admin_model->validEmployee();
		$invalid=$this->Admin_model->invalidEmployee();


		foreach ($validEmployee as $index => $value) {
			foreach ($invalid as $row) {
				if($value['emp_id']==$row['emp_id']){
					unset($validEmployee[$index]);
					break;
				}
			}
		}

		$data['empList']=$validEmployee;
		if (isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true) 
			$this->view('dashboard', $title, $data);
		else
			redirect('login');
	}

	// email sending function
	public function email()
	{
		$title['title'] = 'Email';
		$data[]='';
		$this->load->view('email/index');
	}

	//showing mail group
	public function mailgroup(){
		$title['title']="Mail Group";
		$query=$this->db->get('mail_groups');
		// $data['emails']=$this->Admin_model->getEmployeeDetails();
		$data['mails']=$query->result_array();
		$this->load->view('admin/templates/header', $title);
		$this->load->view('admin/pages/mailgroup', $data);
		$this->load->view('admin/templates/footer');
	}

	//adding email to db
	public function addEmail(){
		extract($_POST);
		$email=trim($email);
		if(empty($email)){
			echo "empty";
			return;
		}
		if(!$this->validateEmail($email)){
			echo "invalid";
			return;
		}

		$data=['email_address'=>$email];
		$this->db->insert('mail_groups',$data);

		$_SESSION['mailMsg']="addEmail";
	}
	
		//adding email to db
	public function deleteEmail(){
		extract($_POST);
		$this->db->where('id',$id);
		if($this->db->delete('mail_groups'))
		$_SESSION['mailMsg']="maildelete";
		else $_SESSION['mailMsg']="error";

	}

	public function employeeArchive() 
	{
		$title['title'] = 'Archived Employee\'s';
		$data['posts']=$this->Admin_model->archivedEmployeeList();

		if (isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true) 
			$this->view('employee_archive', $title, $data);
		else
			redirect('login');
	}

	public function employeeAssign() 
	{
		$title['title'] = 'Assign Employee';

		if (isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true) 
			$this->view('employee_assign', $title);
		else
			redirect('login');
	}



		public function assignEmployee(){
				extract($_POST);
				$id=$_SESSION['current_employee_id'];
				
				$data=[
					'approver_id'=>$approver_id,
					'recommender_id'=>$recommender_id,
					'emp_id'=>$id,
					'created_by'=>$_SESSION['user_id']	
				];
				$this->Admin_model->assign($data,$id);

				// adding package to employee table
				$data2=['package_id'=>$package_id];
				$this->Admin_model->update_employee($data2,$id);



				//adding leave id, emp id and remaining days on employee_leave_balance table
				 $this->db->where('package_id',$package_id);
				 $pkgList= $this->db->get('leave_packages');
				 $list=$pkgList->result_array();

				$this->db->where('emp_id',$id);
				$check=$this->db->get('employee_leave_balance');
				if (count($check)== 0) 
				{
				 foreach ($list as $li) {
				 	$data3=['emp_id'=>$id,'leave_id'=>$li['leave_id'],'remain_days'=>$li['duration']];
				 	$this->Admin_model->insert_leave_balance($data3,$id);
				 }
				 // assigning substitute leave to employee start
				 $managerList = $this->Admin_model->getManagerList();
				 $isManager=false;
				 foreach ($managerList as $manager) {
				 	if($manager['emp_id']==$id){
				 		$isManager=true;
				 		break;
				 	}
				 }
				 if(!$isManager){
				 $this->db->where('leave_name','Substitute');
				 $getLeave= $this->db->get('leaves');
				 $getLeave=$getLeave->row_array();
				 $getSubstitueId=$getLeave['leave_id'];
				 $substitute=['emp_id'=>$id,'leave_id'=>$getSubstitueId,'remain_days'=>'0'];
				 $this->Admin_model->insert_leave_balance($substitute,$id);
				}
				// assigning substitute leave to employee start

				}
				else{
					$this->Admin_model->delete_leave_balance($id);
					foreach ($list as $li) {
					 	$data3=['emp_id'=>$id,'leave_id'=>$li['leave_id'],'remain_days'=>$li['duration']];
					 	$this->Admin_model->insert_leave_balance($data3,$id);
				 	}
				 	// assigning substitute leave to employee start
				 $managerList = $this->Admin_model->getManagerList();
				 $isManager=false;
				 foreach ($managerList as $manager) {
				 	if($manager['emp_id']==$id){
				 		$isManager=true;
				 		break;
				 	}
				 }
				 if(!$isManager){
				 $this->db->where('leave_name','Substitute');
				 $getLeave= $this->db->get('leaves');
				 $getLeave=$getLeave->row_array();
				 $getSubstitueId=$getLeave['leave_id'];
				 $substitute=['emp_id'=>$id,'leave_id'=>$getSubstitueId,'remain_days'=>'0'];
				 $this->Admin_model->insert_leave_balance($substitute,$id);
				}
				// assigning substitute leave to employee start

				}

				//is approver or recommender to employee table
				$data3=['is_approver'=>'1'];
				$this->Admin_model->update_employee($data3,$approver_id);

				$data4=['is_recommender'=>'1'];
				$this->Admin_model->update_employee($data4,$recommender_id);
			
		}

	// viewing single registered employees
	public function employeeDetail($id = NULL) 
	{

		$title['title'] = 'Employee Detail';
		$data['post'] = $this->Database_model->getEmployeeDetails($id);
		$data['work_experience'] = $this->Database_model->find('employee_work_experience', 'emp_id', $id);

		$data['documents'] = $this->Database_model->find('employee_documents', 'emp_id', $id);
		$data['recommender_id']=$this->Admin_model->getRecommenderApprover($id);
		$data['recommender_name']=$this->Admin_model->employeeList();
		$data['package_name']=$this->Admin_model->packageManage();
		if (empty($data['post'])) {
			$data['posts']['user_not_found'] = true;
			$this->view('employee_list', $title, $data);
		} else {
			$this->view('employee_detail', $title, $data);			
		}
	}

	public function employeeList() 
	{
		$title['title'] = 'Employee List';
		$data['posts'] = $this->Admin_model->employeeList();
		$this->view('employee_list', $title, $data);
	}

public function employeeManage($id = NULL) 
	{
		$title['title'] = 'Manage Employee';
		$data['empList']=$this->Admin_model->employeeList();
		$data['packagelist']=$this->Admin_model->packageManage();	
		$data['departments']=$this->Database_model->findAll('departments');
		$data['managers']=$this->Database_model->findAll('managers');
		$data['managerList']=$this->Admin_model->getManagerList();

		if($id!=''){
			$words = preg_replace('/[0-9]+/', '', $id);
			$id = preg_replace('/[^0-9]/', '', $id);
			

			$this->db->where('emp_id',$id);
			$emp=$this->db->get('employees');
			$emplist=$emp->row_array();



			if($emplist==NULL || !empty($words)) {
				$_SESSION['empFindError']=true;
				redirect('admin/employee_list');
			}
			

			else{
				$id=$this->uri->segment(3); 
				$data['assigned']=$this->Admin_model->getAssign($id);
			
				$data['post'] = $this->Database_model->getEmployeeDetails($id);
				$data['work_experience'] = $this->Database_model->find('employee_work_experience', 'emp_id', $id);
				$data['documents'] = $this->Database_model->find('employee_documents', 'emp_id', $id);
		
				return $this->view('employee_manage', $title, $data);
			} 
		}

		else return $this->view('employee_manage', $title, $data);
	}

	// leave page

	public function leaveManage() 
	{

		$title['title'] = 'Leaves';
		$data['posts'] = $this->Admin_model->leaveManage();

		$data['assignedLeave']=$this->Admin_model->assignedLeave();

		$data['assignedPackage']=$this->Admin_model->assignedPackage();

		$data['packages']=$this->Admin_model->packageManage();

		if(isset($_POST['id'])){
			extract($_POST);

		$data['detailLeave']=$this->Admin_model->getLeaveDetails($id);
		}

		if(isset($_POST['pkgId'])){
		extract($_POST);
		$data['detailPackage']=$this->Admin_model->getPackageName($pkgId);
		$data['selectedPackages']=$this->Admin_model->getPackageDetails($pkgId);
		}

		$this->view('leave_manage', $title, $data);
	}




	// public function employeeSearch() 
	// { 
	// 	$id = $this->input->post('search_emp');
	// 	$title['title'] = 'Employee Search List';
	// 	$posts = $this->Admin_model->employeeSearchTotal($id);
	// 	$perPage = 4;
	// 	$data['posts'] = $this->Admin_model->employeeSearch($perPage, $this->uri->segment(3), $id);
	// 	$data['showing_entries'] = $this->showingEntries(count($posts), $this->uri->segment(3), count($data['posts']));
	// 	$config = [
	// 		'base_url' => base_url('admin/employee_search'),
	// 		'per_page' => $perPage,
	// 		'total_rows' => $data['showing_entries']['total']
	// 	];
	// 	$this->pagination->initialize($config);
		
	// 	if (empty($data['posts'])) 
	// 		$data['posts']['user_not_found'] = TRUE;
	// 	$this->view('employee_search', $title, $data);
	// }

// to archive staff
	public function archiveEmployee()
	 {
		extract($_POST);
		$data= array('is_active'=>0);
		$this->Admin_model->update('employees',$data,'emp_id',$emp_id);
	}

// unarchive staff
	public function unArchiveEmployee()
	{
		extract($_POST);
		$data= array('is_active'=>1);
		$this->Admin_model->update('employees',$data,'emp_id',$emp_id);
	}



// this fucntion adds general data of add staff form
	public function addGeneral()
	{			
		$_POST = $this->security->xss_clean($_POST);

		$result=array();
		extract($_POST);


		if($title!='Mr'&&$title!='Mrs'&&$title!='Ms'&&$title!='Dr'){
			$msg="error";
			array_push($result, $msg);
			echo json_encode($result);
			return ;
		}
		
		if($gender!='Male' && $gender!='Female' && $gender!='Others'){
			$msg="errorgender";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		

		$this->form_validation->set_rules('title','Title','required',array('required' => 'You must provide a %s.'));
		$this->form_validation->set_rules('first_name','First Name','required|trim');
		$this->form_validation->set_rules('last_name','Last Name','required|trim');
		$this->form_validation->set_rules('middle_name','Middle Name','trim');

		if($this->form_validation->run()===FALSE)
		{
			$result=$this->form_validation->error_array();
			$msg="false";
			array_push($result, $msg);
			echo json_encode($result);
			return ;
		}else
		{
			if(!$this->textOnly($first_name) || !$this->textOnly($last_name))
		{
			$msg="textonly";
			array_push($result, $msg);
			echo json_encode($result);
			return ;
		}

		if(!$this->validateDate($join_date))
		{
			$msg="errorDate";
			array_push($result, $msg);
			echo json_encode($result);
			return ;
		}

		if($middle_name != '')
		{
			if( !$this->textOnly($middle_name))
			{
				$msg="textonly";
				array_push($result, $msg);
				echo json_encode($result);
				return ;
			}
		}
		

		if( !$this->validateEmail($email))
			{
				$msg="emailInvalid";
				array_push($result, $msg);
				echo json_encode($result);
				return ;
			}


		if($dob>Date('Y-m-d'))
		{
			return 0;
		}

			$data=array(
				'title'=>$title,
				'first_name'=>trim($first_name),
				'middle_name'=>$middle_name,
				'last_name'=>$last_name,
				'join_date'=>$join_date,
				'is_active'=>'1',
				'department_id'=>$department,
				'gender'=>$gender,
				'dob'=>$dob,
				'email'=>$email
			);

			$id=$this->Admin_model->add_employee($data,$password);
			$message= "Dear ".$first_name." , "."<br>"."Welcome to EMS. You have been registered as an employee. Please have a look at your account details below "."<br>"."Login ID: ".$id."<br>"."Password: ".$password."<br>";
				 $this->Admin_model->sendEmail('Account Registered',$message,$email);


			$this->db->where('emp_id',$_SESSION['current_employee_id']);
			$this->db->delete('managers');

			if($is_manager=='true'){
				$mdata=['emp_id'=>$id];
			$this->db->insert('managers',$mdata);
			
			}	
			
				array_push($result, $id);
			

		}
		echo json_encode($result);
	}

//this  edits general information
	public function updateGeneral()
	{
		$_POST = $this->security->xss_clean($_POST);

		$result=array();
		extract($_POST);

		if(!$this->validateDate($join_date))
		{
			$msg="errorDate";
			array_push($result, $msg);
			echo json_encode($result);
			return ;
		}
		if($title!='Mr'&&$title!='Mrs'&&$title!='Ms'&&$title!='Dr'){
			$msg="error";
			array_push($result, $msg);
			echo json_encode($result);
			return ;
		}


		$this->form_validation->set_rules('title','Title','required|trim',array('required' => 'You must provide a %s.'));
		$this->form_validation->set_rules('first_name','First Name','required|trim');
		$this->form_validation->set_rules('last_name','Last Name','required|trim');
		$this->form_validation->set_rules('email','Email address','required|trim');

		if($this->form_validation->run()===FALSE)
		{
			$result=$this->form_validation->error_array();
			$msg="false";
			array_push($result, $msg);
			echo json_encode($result);
			return ;
		}
		else
		{

		if(!$this->textOnly($first_name) || !$this->textOnly($last_name))
		{
			$msg="textonly";
			array_push($result, $msg);
			echo json_encode($result);
			return ;
		}

		if($gender!='Male' && $gender!='Female' && $gender!='Others'){
			$msg="errorgender";
			array_push($result, $msg);
			echo json_encode($result);
			return ;
		}
		if($middle_name != '')
		{
			if( !$this->textOnly($middle_name))
			{
				$msg="textonly";
				array_push($result, $msg);
				echo json_encode($result);
				return ;
			}
		}
		
		if($dob>Date('Y-m-d'))
		{
			return 0;
		}

		if( !$this->validateEmail($email))
			{
				$msg="emailInvalid";
				array_push($result, $msg);
				echo json_encode($result);
				return ;
			}
			$data=array(
				'title'=>$title,
				'first_name'=>$first_name,
				'middle_name'=>$middle_name,
				'last_name'=>$last_name,
				'join_date'=>$join_date,
				'is_active'=>'1',
				'department_id'=>$department,
				'gender'=>$gender,
				'dob'=>$dob,
				'email'=>$email
			);

			$this->db->where('emp_id',$_SESSION['current_employee_id']);
			$this->db->delete('managers');

			if($is_manager=='true'){
				$mdata=['emp_id'=>$_SESSION['current_employee_id']];
			$this->db->insert('managers',$mdata);
			}

			if($this->Admin_model->update_employee($data,$_SESSION['current_employee_id']))
			{
				$message= "Dear ".$first_name.","."<br>"."Your email has been updated. Please use the previous ID and Password to log in" ;
				$this->Admin_model->sendEmail('Email Updated',$message,$email);
				
				array_push($result, 'true');
			}

		}
		echo json_encode($result);
	}




//Address form
	public function addAddress()
	{
		$_POST = $this->security->xss_clean($_POST);
		$result=array();
		extract($_POST);

//validate
		$this->form_validation->set_rules('currentaddress_street','Current street','required|trim',array('required' => 'You must provide a %s.'));

		$this->form_validation->set_rules('currentaddress_municipality','Current municipality','required|trim',array('required' => 'You must provide a %s.'));
			$this->form_validation->set_rules('currentaddress_district','Current district','required|trim',array('required' => 'You must provide a %s.'));

	
		if($this->form_validation->run()===FALSE)
		{
			$status=$this->form_validation->error_array();
		}else
		{
			// validation municipality
			if($permanentaddress_municipality!='')
			{
				if(!$this->textOnly($permanentaddress_municipality))
				{
					$msg="textonlyMunicipality";
					array_push($result, $msg);
					echo json_encode($result);
					return ;
				}
			}

			//
			if(!$this->textOnly($currentaddress_municipality))
			{
				$msg="textonlyMunicipality";
				array_push($result, $msg);
				echo json_encode($result);
				return ;
			}

			if($permanentaddress_district!='')
			{
				if(!$this->alphanumeric($permanentaddress_district))
				{
					$msg="textonlyDistrict";
					array_push($result, $msg);
					echo json_encode($result);
					return ;
				}
			}

			//
			if(!$this->alphanumeric($currentaddress_district))
			{
				$msg="textonlyDistrict";
				array_push($result, $msg);
				echo json_encode($result);
				return ;
			}


			$primaryAdd=array(
				'street'=>$permanentaddress_street,
				'municipality'=>$permanentaddress_municipality,
				'district'=>$permanentaddress_district,
				'state'=>$permanentaddress_state,
				'country'=>$permanentaddress_country,

			);
			$secondaryAdd=array(
				'street'=>$currentaddress_street,
				'municipality'=>$currentaddress_municipality,
				'district'=>$currentaddress_district,
				'state'=>$currentaddress_state,
				'country'=>'Nepal'
			);

			// check is used in whether the adress is already in database or not
			$check=NULL;

	
				$query=$this->db->get_where("addresses",$primaryAdd);
				$check=$query->row_array();
		

			if($check==NULL){
					if(isset($_SESSION['current_employee_id'])){
						$id=$_SESSION['current_employee_id'];
					}
					else{
						$id=$_SESSION['user_id'];
					}

					$primary_id=$this->Admin_model->update_address($primaryAdd,$id);
					
			}
			else{
				$primary_id=$check['address_id'];
			}

			$query=$this->db->get_where("addresses",$secondaryAdd);
			$check=$query->row_array();

			if($check==''){
				if(isset($_SESSION['current_employee_id'])){
						$id=$_SESSION['current_employee_id'];
					}
					else{
						$id=$_SESSION['user_id'];
					}
				$secondary_id=$this->Admin_model->update_address($secondaryAdd,$id);
			}
			else{
				$secondary_id=$check['address_id'];
			}
					if(isset($_SESSION['current_employee_id'])){
						$id=$_SESSION['current_employee_id'];
					}
					else{
						$id=$_SESSION['user_id'];
					}

			$this->Admin_model->update_employee_address($primary_id,$secondary_id,$id);

			$status=array('true');
		}
		echo json_encode($status);
	} 




// contact form
	public function addContact()
	{
		$status=array();
		$_POST = $this->security->xss_clean($_POST);
		extract($_POST);
		$this->form_validation->set_rules('mobile_phone','Mobile phone','required|trim',array('required' => 'You must provide a %s.'));


		if($home_phone!='')
		{
			if(!$this->contactNumber($home_phone))
			{
				$msg="errorContactHome";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}

		if($other_phone1!='' || $other_phone2!='' || $other_phone3!='')
		{
			if(!$this->contactNumber($other_phone1) || !$this->contactNumber($other_phone2) || !$this->contactNumber($other_phone3))
			{
				$msg="errorContactOther";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}

		if(!$this->contactNumber($mobile_phone))
		{
			$msg="errorContactMobile";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}


		if($this->form_validation->run()===FALSE)
		{
			$status=$this->form_validation->error_array();
			
		}

		else
		{
			$data=array(
				'home_phone'=>$home_phone,
				'mobile_phone'=>$mobile_phone,
				'other_phone1'=>$other_phone1,
				'other_phone2'=>$other_phone2,
				'other_phone3'=>$other_phone3
			);
					if(isset($_SESSION['current_employee_id'])){
						$id=$_SESSION['current_employee_id'];
					}
					else{
						$id=$_SESSION['user_id'];
					}

			$contact_id=$this->Admin_model->update_contact($data,$id);
			$this->Admin_model->update_employee_contact($contact_id,$id);
				$status=array('true');
			

		}
		echo json_encode($status);
	}
// nationality
	public function addNationality()
	{
		$status=array();
		$_POST = $this->security->xss_clean($_POST);
		extract($_POST);
		if($visa_expiry_date<Date('Y-m-d'))
			{return 0;}

		$this->form_validation->set_rules('passport_no','Passport Number','required|trim',array('required' => 'You must provide a %s.'));

		$this->form_validation->set_rules('passport_issue_place','Place of Issue','required|trim',array('required' => 'You must provide a %s.'));

		if($nationality=='Non-Nepalese')
		$this->form_validation->set_rules('visa_type','Visa type','required|trim',array('required' => 'You must provide a %s.'));

		if($this->form_validation->run()===FALSE)
		{
			$status=$this->form_validation->error_array();
			
		}
		

		else {
			if($visa_type!='')
			{
				if(!$this->textOnly($visa_type))
				{
					$msg="errorVisatype";
					array_push($status, $msg);
					echo json_encode($status);
					return ;
				}
			}

			if(!$this->alphanumeric($passport_issue_place))
			{
				$msg="errorPassportIssue";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
			

		
			if($nationality=='Nepalese')
			{
				$data=array(
				'nationality'=>$nationality,
				'visa_permission'=>'Not required',
				'visa_type'=>'',
				'visa_expiry_date'=>'',
				'passport_no'=>$passport_no,
				'passport_issue_place'=>$passport_issue_place
					);
			}
		else{

		if($visa_type=='')
		{
		$msg="errorVisatype";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		$data=array(
		'nationality'=>$nationality,
		'visa_permission'=>$visa_permission,
		'visa_type'=>$visa_type,
		'visa_expiry_date'=>$visa_expiry_date,
		'passport_no'=>$passport_no,
		'passport_issue_place'=>$passport_issue_place
	);
			}

		if(isset($_SESSION['current_employee_id'])){
				$id=$_SESSION['current_employee_id'];
			}
			else{
				$id=$_SESSION['user_id'];
			}

			$this->Admin_model->update_employee($data,$id);
			$status=array('true');

		}
			

			
		
		echo json_encode($status);
	}

// Emergency contact
	public function addEmergency()
	{
		$status=array();
		$_POST = $this->security->xss_clean($_POST);
		extract($_POST);

		$this->form_validation->set_rules('e_name','Contact Person Name','required|trim',array('required' => 'You must provide detail of %s.'));

		$this->form_validation->set_rules('e_relation','Relation','required|trim',array('required' => 'You must provide relation to the person.'));

		$this->form_validation->set_rules('e_phone','Contact No.','required|trim',array('required' => 'You must provide contact details of person.'));

		if($this->form_validation->run()===FALSE)
		{
			$status=$this->form_validation->error_array();
			echo json_encode($status);
			return ;
		}
		else
		{

		if(!$this->textOnly($e_name))
		{
			$msg="errorEmergencyName";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		if($e_relation=='')
		{
			$msg="errorEmergencyRelation";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}
		if(!$this->textOnly($e_relation))
		{
			$msg="errorEmergencyRelation";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		if(!$this->contactNumber($e_phone))
		{
			$msg="errorEmergencyContact";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		if($e_address!='')
		{
			if(!$this->alphanumeric($e_address))
			{
				$msg="errorEmergencyAddress";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}

		
	
			$data=array(
				'e_name'=>$e_name,
				'e_relation'=>$e_relation,
				'e_address'=>$e_address,
				'e_phone'=>$e_phone
			);
			if(isset($_SESSION['current_employee_id'])){
						$id=$_SESSION['current_employee_id'];
					}
					else{
						$id=$_SESSION['user_id'];
					}

			$this->Admin_model->update_employee($data,$id);
			$status=array('true');

		
	}
		echo json_encode($status);
	}

// Education tab
	public function addEducation()
	{
		$status=array();
		$_POST = $this->security->xss_clean($_POST);
		extract($_POST);
		$this->form_validation->set_rules('degree_title','Degree title','required',array('required' => 'You must provide your highest degree'));

		$this->form_validation->set_rules('university','Institute','required|trim',array('required' => 'You must provide name of the Institute.'));

		if($this->form_validation->run()===FALSE)
		{
			$status=$this->form_validation->error_array();
		}
		else{
		if($highest_degree!='PhD' && $highest_degree!='Master' && $highest_degree!='Bachelor' && $highest_degree!='High School' && $highest_degree!='Middle School'  && $highest_degree!='None' ){
		$msg="error";
		array_push($status, $msg);
		echo json_encode($status);
		return ;
		}

		if(!$this->textOnly($degree_title))
		{
			$msg="errorEducationdegree";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		if(!$this->textOnly($university))
		{
			$msg="errorEducationuniversity";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		else
		{
			$data=array(
				'highest_degree'=>$highest_degree,
				'degree_title'=>$degree_title,
				'university'=>$university,
			);
					if(isset($_SESSION['current_employee_id'])){
						$id=$_SESSION['current_employee_id'];
					}
					else{
						$id=$_SESSION['user_id'];
					}

			$this->Admin_model->update_employee($data,$id);
			$status=array('true');

		}
	}
		echo json_encode($status);
	}

// health information
	public function addHealth()
	{
		$status=array();
		$_POST = $this->security->xss_clean($_POST);
		extract($_POST);

		if($allergies!='No')
		{
			$this->form_validation->set_rules('allergy_description','allergy_description','required',array('required' => 'You must provide %s'));
			if($this->form_validation->run()===FALSE)
			{
			$status=$this->form_validation->error_array();
			echo json_encode($status);
			return ;
			}
		}


		if($blood_group!='A +ve' && $blood_group!='A -ve' && $blood_group!='B +ve' && $blood_group!='B -ve' && $blood_group!='AB +ve'  && $blood_group!='AB -ve' && $blood_group!='O +ve'  && $blood_group!='O -ve' && $blood_group!=''){
			$msg="error";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}
		if($medical_complications!='')
		{
			if(!$this->alphanumeric($medical_complications))
			{
				$msg="errorMedicalComplication";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}
		
		if($regular_medication!='')
		{
			if(!$this->alphanumeric($regular_medication) )
			{
				$msg="errorMedicalRegular";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}

		if($allergy_description!='')
		{
			if(!$this->alphanumeric($allergy_description) )
			{
				$msg="errorMedicalAllergy";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
			
		}
			if($allergies=='No')
			{
			 $data=array(
				'blood_group'=>$blood_group,
				'medical_complications'=>$medical_complications,
				'regular_medication'=>$regular_medication,
				'allergies'=>$allergies,
				'allergy_description'=>''
			);
			}
			else
			{
				$data=array(
				'blood_group'=>$blood_group,
				'medical_complications'=>$medical_complications,
				'regular_medication'=>$regular_medication,
				'allergies'=>$allergies,
				'allergy_description'=>$allergy_description
			);
			}
			
			if(isset($_SESSION['current_employee_id'])){
				$id=$_SESSION['current_employee_id'];
			}
			else{
				$id=$_SESSION['user_id'];
			}

			$this->Admin_model->update_employee($data,$id);
			$status=array('true');

		
		echo json_encode($status);
	}

	// PAN number
	public function addPan()
	{
		$status=array();
		$_POST = $this->security->xss_clean($_POST);
		extract($_POST);

		$this->form_validation->set_rules('pan','PAN','required',array('required' => 'You must provide a PAN Number'));

		if($this->form_validation->run()===FALSE)
		{
			$status=$this->form_validation->error_array();
		}else
		{
			if($this->numberonly($pan)==true)
			{

				$data=array(
					'pan'=>$pan
				);	
						if(isset($_SESSION['current_employee_id'])){
							$id=$_SESSION['current_employee_id'];
						}
						else{
							$id=$_SESSION['user_id'];
						}

				$this->Admin_model->update_employee($data,$id);
				$status=array('true');

			}
			else
			{
				$msg="errorPan";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}

		echo json_encode($status);

	}




// for work experience
function addWork(){
	$status=array();
	$_POST = $this->security->xss_clean($_POST);
	extract($_POST);
	
	$dateTimestamp1 = strtotime($from_date); 
		$dateTimestamp2 = strtotime($to_date); 
		if(!$this->alphanumeric($organization))
		{
			$msg="errorOrganization";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		else if(!$this->alphanumeric($responsibility))
		{
			$msg="errorResponsibility";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		else if(!$this->alphanumeric($position))
		{
			$msg="errorPosition";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		else if(!$this->validateDate($from_date))
		{
			$msg="errorFromDate";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		else if(!$this->validateDate($to_date))
		{
			$msg="errorToDate";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}
		
		else if($dateTimestamp1>$dateTimestamp2)
		{
			$msg="fromdateGreater";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		else if($from_date>Date('Y-m-d'))
		{
			$msg="fromdateError";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		else if($to_date>Date('Y-m-d'))
		{
			$msg="todateError";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}
		else if(!$this->contactNumber($contact_person_number))
		{
			$msg="errorContact";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}
		
		else
		{
			$data=[
				'from_date'=>$from_date,
				'to_date'=>$to_date,
				'organization'=>$organization,
				'responsibility'=>$responsibility,
				'position'=>$position,
				'contact_person_number'=>$contact_person_number,
				'emp_id'=>$_SESSION['current_employee_id']
			];
			if($id==''){
				$this->Admin_model->insert('employee_work_experience',$data);
				$id=$this->db->insert_id();
				array_push($status, $id);
				echo json_encode($status);
			}
			else{
				$this->db->where('id',$id);
				$this->db->update('employee_work_experience',$data);
				$msg="update";
				array_push($status, $msg);
				echo json_encode($status);
			}
			
		}
	// }	
		
}





function getWork(){
	extract($_POST);
	$this->db->where('id',$id);
	$res=$this->db->get('employee_work_experience');
	$result=$res->row_array();

	echo json_encode($result);

}


function checkExp(){
	if(isset($_SESSION['current_employee_id']))
		$id=$_SESSION['current_employee_id'];
	else $id = $_SESSION['user_id'];

	$this->db->where('emp_id',$id);
	$getlist=$this->db->get('employee_work_experience');
	$list=$getlist->result_array();

	if(count($list)>0) echo "true"; else echo "false";
}

function deleteWorkExp(){
	extract($_POST);
	$status=$this->Admin_model->deleteWorkExperience($id);
	echo $status;
}


//function for adding documents
	function addDocuments(){
		$_SESSION['path']="document"; 
		$status='';
		$_POST = $this->security->xss_clean($_POST);

		extract($_POST);

		$tmpName = $_FILES['document']['tmp_name'];
		$realName= $_SESSION['current_employee_id'].'-'.$_FILES['document']['name'];

		// list of allowed file types
		$allowed =  array('gif','png' ,'jpg','doc','docx','pdf','PNG','JPG');

		$ext = pathinfo($realName, PATHINFO_EXTENSION);

		if(!in_array($ext,$allowed)) {
		$msg="errorFileType";
		$status='false';
		echo $status;
		return ;
		}



		
		$target_path = 'assets/files/'.$realName;
		move_uploaded_file($tmpName,$target_path);

					if(isset($_SESSION['current_employee_id'])){
						$id=$_SESSION['current_employee_id'];
					}
					else{
						$id=$_SESSION['user_id'];
					}

		if($doc_title=='')
		{
			$doc_data=array(
				'doc_title'=>$realName,
				'doc_file'=>$realName,
				'emp_id'=>$id
			);

		}
		else{
			$doc_data=array(
				'doc_title'=>$doc_title,
				'doc_file'=>$realName,
				'emp_id'=>$id
			);}


			if(	$this->Admin_model->insert('employee_documents',$doc_data))

			// if(	$this->Admin_model->add_documents($doc_data))
				{
					$status='true';
				}

			else{ $status='false'; }

			echo $status;

		}


//function for editing documents
	function editDocuments(){

		$_SESSION['path']="document"; 
		$status='';
		$_POST = $this->security->xss_clean($_POST);
		extract($_POST);
		if($fileCount==0){
			if($doc_title==''){
				$this->db->where('doc_id',$doc_id);
				$doc=$this->db->get('employee_documents');
				$docDetail=$doc->row_array();

				$doc_title=$docDetail['doc_file'];
			}
			$doc_data=array(
				'doc_title'=>$doc_title,
				'emp_id'=>$_SESSION['current_employee_id']
			);
			$this->db->where('doc_id',$doc_id);
			$this->db->update('employee_documents',$doc_data);
			$status='true';
			echo $status;
			return ;
		}
		

		
		$tmpName = $_FILES['document']['tmp_name'];
		$realName= $_SESSION['current_employee_id'].'-'.$_FILES['document']['name'];
		// list of allowed file types
		$allowed =  array('gif','png' ,'jpg','doc','docx','pdf','PNG','JPG');

		$ext = pathinfo($realName, PATHINFO_EXTENSION);

		if(!in_array($ext,$allowed)) {
		$msg="errorFileType";
		$status='false';
		echo $status;
		return ;
		}



		
		$target_path = 'assets/files/'.$realName;
		move_uploaded_file($tmpName,$target_path);

					if(isset($_SESSION['current_employee_id'])){
						$id=$_SESSION['current_employee_id'];
					}
					else{
						$id=$_SESSION['user_id'];
					}

		if($doc_title=='')
		{
			$doc_data=array(
				'doc_title'=>$realName,
				'doc_file'=>$realName,
				'emp_id'=>$id
			);

		}
		else{
			$doc_data=array(
				'doc_title'=>$doc_title,
				'doc_file'=>$realName,
				'emp_id'=>$id
			);}

			$this->db->where('doc_id',$doc_id);
			$this->db->update('employee_documents',$doc_data);
			$status='true';


			echo $status;

		}

	// <!-- delete files from the database -->
	 function deleteFile()
	 {
	 	$_SESSION['path']="document";
		$_POST = $this->security->xss_clean($_POST);

		extract($_POST);
		$this->db->where('doc_id',$doc_id);
			$getFile = $this->db->get('employee_documents');
			$document= $getFile->row_array();

			$filename=$document['doc_file'];
			$path='assets/files/'.$filename;
		$this->Admin_model->deleteFile($path,$doc_id);
	}





// while adding leave, if same leave is already in database,
// 	error is shown else leave is created.

// while editing leave, leave name is updated

		public function saveLeave()
		{
		$_POST = $this->security->xss_clean($_POST);

			$is_one_day_val='0';
			extract($_POST);
			if($is_one_day=='true')
			{
				$is_one_day_val='1';
			}
			
			$data=[
				'leave_name'=>$leave_name,
				'is_one_day'=>$is_one_day_val,
				'created_by'=>$_SESSION['user_id']
			];

			if($leave_id=='')
			{
				$leave=$this->db->where('leave_name',$leave_name);
				$list=$this->db->get('leaves');
				$getList= $list->result_array();
				if(count($getList)==0)
				{
					$this->db->insert('leaves',$data);
					echo "inserted";
				}

				else echo "already";
			}			
			else{
				$is_one_day_val='0';
				if($is_one_day=='true')
				{
					$is_one_day_val='1';
				}
				$data=[
					'leave_name'=>$leave_name,
					'is_one_day'=>$is_one_day_val,
					'created_by'=>$_SESSION['user_id'],
					'leave_id'=>$leave_id
				];

				$leave=$this->db->where('leave_name',$leave_name);
				$list=$this->db->get('leaves');
				$getList= $list->row_array();

				$currentleave=$this->db->where('leave_id',$leave_id);
				$currentlist=$this->db->get('leaves');
				$getcurrentlist=$currentlist->row_array();

				if($getList!=NULL)
				$result=array_diff($getList,$getcurrentlist);

				else $result=[];


				if(count($result)==0)
				{
					$this->db->where('leave_id',$leave_id);
					$this->db->update('leaves',$data);
					echo "updated";
				}
				else echo "already";
			}

		}

		public function deleteLeave(){
		$_POST = $this->security->xss_clean($_POST);

			extract($_POST);
			$this->db->where('leave_id',$leave_id);
			$check=$this->db->get('leave_packages');
			$list=$check->result_array();

			if(count($list)==0){
				$this->db->where('leave_id',$leave_id);
				$this->db->delete('leaves');
				echo "deleted";
			}
			else{
				echo "assigned";
			}

			
		}

// save package
		public function savePackage(){
		$_POST = $this->security->xss_clean($_POST);

			extract($_POST);

			$arrayLeave=json_decode($leaveArr, true);
			$arrayDuration=json_decode($durationArr, true);
			foreach ($arrayDuration as $row) {
				if($row<1){
				echo "invalidDuration";
				return 0;
				}
			}

			$data=[ 'package_name'=>$package_name, 'created_by'=>$_SESSION['user_id'] ];

			if($package_id=='')
			{
				$leave=$this->db->where('package_name',$package_name);
				$list=$this->db->get('packages');
				$getList= $list->row_array();

				if(count($getList)==0)
				{
					$this->db->insert('packages',$data);
					$pkgId=$this->db->insert_id();
					$this->addLeaveToPackage($arrayLeave,$arrayDuration,$pkgId,'insert');
					echo "inserted";
				}
				else
					echo "already";
			}
			else{
				$data=[
					'package_name'=>$package_name,
					'created_by'=>$_SESSION['user_id'],
					'package_id'=>$package_id
				];

				$package=$this->db->where('package_name',$package_name);
				$list=$this->db->get('packages');
				$getList= $list->row_array();

				$currentPkg=$this->db->where('package_id',$package_id);
				$currentlist=$this->db->get('packages');
				$getcurrentlist=$currentlist->row_array();

				if($getList!=NULL)
				$result=array_diff($getList,$getcurrentlist);

				else $result=[];

				if(count($result)==0)
				{
					$this->db->where('package_id',$package_id);
					$this->db->update('packages',$data);
					$this->addLeaveToPackage($arrayLeave,$arrayDuration,$package_id,'update');
					echo "updated";
				}
				else echo "already";
				
				
			}
	
		}
		

		function addLeaveToPackage($leave,$duration,$id,$operation){
				//get id of substitute leave
			$this->db->where('leave_name','Substitute');
			$query=$this->db->get('leaves');
			$subs=$query->row_array();

			$subs_id=$subs['leave_id'];


			if($operation=="insert"){
				foreach ($leave as $index => $leaveId) {
					$data=['leave_id'=>$leaveId, 'package_id'=>$id, 'duration'=>$duration[$index],'created_by'=>$_SESSION['user_id']];
					$this->db->insert('leave_packages',$data);
				}
				$data=['leave_id'=>$subs_id, 'package_id'=>$id, 'duration'=>0,'created_by'=>$_SESSION['user_id']];
					$this->db->insert('leave_packages',$data);



			}
			if($operation=="update"){
				$this->db->where('package_id',$id);
				$this->db->delete('leave_packages');

				foreach ($leave as $index => $leaveId) {
					$data=['leave_id'=>$leaveId, 'package_id'=>$id, 'duration'=>$duration[$index],'created_by'=>$_SESSION['user_id']];
					$this->db->insert('leave_packages',$data);
				}
					$data=['leave_id'=>$subs_id, 'package_id'=>$id, 'duration'=>0,'created_by'=>$_SESSION['user_id']];
					$this->db->insert('leave_packages',$data);
			}
		}

		// delete package
		public function deletePackage(){

			extract($_POST);
			$this->db->where('package_id',$package_id);
			$check=$this->db->get('employees');
			$list=$check->result_array();

			if(count($list)==0){
				$this->db->where('package_id',$package_id);
				$this->db->delete('packages');
				echo "deleted";
			}
			else{
				echo "assigned";
			}
		}

		//check employee attendance today

		public function checkStatus($id){


		$this->db->where('emp_id',$id);
		$this->db->where('is_approved','approved');

		$query=$this->db->get('employee_leaves');
		$empLeave=$query->row_array();

		if($empLeave==NULL){
			$status='present';
			return $status;
		}
		else{

		$leaveBegin=$empLeave['from_date'];
		$leaveEnd=$empLeave['to_date'];

		$currentDate = Date('Y-m-d'); // Today


		if($currentDate >= $leaveBegin &&
			$currentDate<= $leaveEnd){
		
			$status='absent';
		}
		else{
			$status='present';  
		}
		}
			return $status;

	}


public function assignTemp(){
	extract($_POST);

	$data=['recommender_id'=>$tempRecommender];
	$this->db->where('id',$id);
	$this->db->update('employee_leaves',$data);
}

public function approveTemp(){
	extract($_POST);
	$data=[
		'approver_id'=>$_SESSION['user_id'],
		'is_approved'=>"approved",
	];
	$this->db->where('id',$id);
	$this->db->update('employee_leaves',$data);
}

public function approveTempAll(){
	extract($_POST);
	$data=[
		'approver_id'=>$_SESSION['user_id'],
		'recommender_id'=>$_SESSION['user_id'],
		'is_recommended'=>"recommended",
		'is_approved'=>"approved",
	];
	$this->db->where('id',$id);
	$this->db->update('employee_leaves',$data);
}

public function rejectTemp(){
	extract($_POST);

	$this->db->where('id',$id);
	$data=[
		'approver_id'=>$_SESSION['user_id'],
		'is_approved'=>'denied',
		'denial_reason'=>$reason
	];
	$this->db->update('employee_leaves',$data);
}



// checking input types
public function textOnly($text)
{
	if (preg_match('/^[a-zA-Z .\-\']+$/',$text ))
		return true;
	else
		return false;
}

// checking input types number
public function numberonly($text)
{
	if (preg_match('/^[0-9]+$/',$text ))
		return true;
	else
		return false;
}

// checking phone number
public function contactNumber($value)
{
	if(preg_match('/^[0-9\-\(\)\/\+\s]*$/', $value))
		return true;
	else
		return false;
}

// alphanumeric but must contain alphabets
public function alphanumeric($value)
{
	if(preg_match('/^(?=.*[a-zA-Z])[a-zA-Z0-9 .\-\,]+$/',$value))
		return true;
	else
		return false;
}

// EMAIL VALIDATION
public function validateEmail($email)
{
	if(preg_match('/^(?=.*[a-zA-Z])\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',$email))
		return true;
	else
		return false;
}


// check date 
public function validateDate($date)
{
	if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) 
    	return true;
 	else  
   		return false; 
}

// report generation
public function reportGeneration()
{
	$title['title'] = 'Report Generation';
	$data['posts']=$this->Admin_model->archivedEmployeeList();
		
	if (isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true) 
	{
		$this->view('report_generation', $title, $data);
	}
	else { redirect('login'); }
}

}
?>