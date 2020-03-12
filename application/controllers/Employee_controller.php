<?php
	class Employee_controller extends CI_Controller {

		public function __construct()
        {
               parent::__construct();
               if (!isset($_SESSION['loggedin'])|| $_SESSION['loggedin']!=true|| $_SESSION['type']!='employee') {
					redirect('login');
				}
				if(isset($_SESSION['changed'])&&$_SESSION['changed']!='1'){
                    $_SESSION['changePasswordMsg']="Change Your Password Before Logging In";
                    redirect('changePassword');
             }  
			date_default_timezone_set('Asia/Kathmandu');

        }
        public function view($page, $title = 'EMS', $data = FALSE)
         {
			if (!file_exists(APPPATH . 'views/employee/pages/' . $page . '.php')) 
				show_404();

			$this->load->view('employee/templates/header', $title);
			$this->load->view('employee/pages/' . $page . '', $data);
			$this->load->view('employee/templates/footer');
		}

		public function generalPage($page = 'dashboard') 
		{
			if (!file_exists(APPPATH . 'views/employee/pages/' . $page . '.php')) {
				show_404();
			}
 
			$data['title'] = ucfirst($page);
			$data['user']= $this->Admin_model->user_detail('users',$_SESSION['user_id']);
			$data['post'] = $this->Admin_model->getEmployeeDetails($_SESSION['user_id']);

		

			if (isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true) 
			{
				$this->load->view('employee/templates/header');
				$this->load->view('employee/pages/' . $page, $data);
				$this->load->view('employee/templates/footer');
			}
			else { redirect('login');}
		}


		public function dashboard()
		{
			$data['title']= 'Dashboard';
			$data['employee_leaves'] = $this->Employee_model->findAllLeaves($_SESSION['user_id']);
			$data['employee_leaves_approve'] = $this->Employee_model->findApproveLeaves();
			$data['employee_leaves_substitute'] = $this->Employee_model->findSubstituteLeaves();
			$data['recommendations']=$this->Employee_model->recommendationList('0');
			$data['duty_by']=$this->Admin_model->employeeList();
			$data['substitute_balance']=$this->Employee_model->findSubstituteLeaveBalance($_SESSION['user_id']);
			$data['leavelist']=$this->leaveBalance();
			$data['substituteleave']=$this->substituteleave();

			$this->view('dashboard', $data);
		}

		// get substitute leave
		public function substituteleave(){
			$this->db->where('leave_name','Substitute');
			$query=$this->db->get('leaves');
			$leaves=$query->row_array();
			$this->db->where('emp_id',$_SESSION['user_id']);
			$this->db->where('employee_leave_balance.leave_id',$leaves['leave_id']);
			$this->db->join('leaves','employee_leave_balance.leave_id=leaves.leave_id');
			$query=$this->db->get('employee_leave_balance');
			return $query->row_array();
		}

		// archive approved list
		public function leaveApproveArchive()
		{
			$data['title']= 'Archived Lists';
			$data['employee_leaves_approve'] = $this->Employee_model->findArchivedApproveLeaves();
			$data['duty_by']=$this->Admin_model->employeeList();
			$data['leavelist']=$this->leaveBalance();

			$this->view('leave_approve_archive', $data);
		}
		// archived recommended leaves list page
		public function leaveRecommendedArchive()
		{
			$data['title']= 'Archived Lists';
			$data['employee_leaves'] = $this->Employee_model->findAllLeaves();
			$data['recommendations']=$this->Employee_model->recommendationList('1');
			$data['duty_by']=$this->Admin_model->employeeList();
			$data['leavelist']=$this->leaveBalance();

			$this->view('leave_recommended_archive', $data);
		}

		public function leaveBalance(){
			return $this->Employee_model->leaveDetail($_SESSION['user_id']);	
		}

		public function leave_details($lid=NULL){

			$title['title']= 'Leave Details';
			$data['leavelist']=$this->leaveBalance();
			$data['leaveDetail']=$data['leavelist'][$lid];
			$data['leaveDetail']['taken']=$data['leaveDetail']['duration']-$data['leaveDetail']['remain_days'];
			$leaveID= $data['leaveDetail']['leave_id'];
			$data['employee_leaves'] = $this->Employee_model->findAllLeaves($_SESSION['user_id'], $leaveID);
			// $data['employee_leaves'] = $this->Employee_model->getLeaveDetail($lid);

			$this->view('leave_details', $title, $data);

		}

		public function profileupdate($id = NULL) 
		{
		$title['title'] = 'Update Profile';

		if (isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true) 
		{	
			$data['empList']=$this->Admin_model->employeeList();
			$data['departments']=$this->Database_model->findAll('departments');
			if($this->uri->segment(3)){
				 $id=$this->uri->segment(3);   
				$data['assigned']=$this->Admin_model->getAssign($id);
				$data['packagelist']=$this->Admin_model->packageManage();			}
			else{
				$data['assigned']='';
			}
			if ($id != NULL) {
				$data['post'] = $this->Admin_model->getEmployeeDetails($id);
				$data['work_experience'] = $this->Database_model->find('employee_work_experience', 'emp_id', $id);
				$data['documents'] = $this->Database_model->find('employee_documents', 'emp_id', $id);
				$data['recommender_id']=$this->Admin_model->getRecommenderApprover($id);
				$data['recommender_name']=$this->Admin_model->employeeList();
				$data['package_name']=$this->Admin_model->packageManage();
				$this->view('profile_update', $title, $data);
			} else
				$this->view('profile_update', $title);
		} else
			redirect('login');
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


		public function leaveForm()
		{
			$title['title'] = 'Leave Form';
			// this returns employees name only : not Admin's name
			$data['duty_performed_by'] = $this->Employee_model->showEmployeesOnly();
			$data['substitute_balance']=$this->Employee_model->findSubstituteLeaveBalance($_SESSION['user_id']);
			$data['leaves'] = $this->Employee_model->leaveDetail($_SESSION['user_id'], 0);

			$data['leavelist']=$this->leaveBalance();
			
			// whether employee can take substitute leave or not / showing 'Substitute Leave' in drop-down
			$sbs_emp = $this->Database_model->find('employee_leave_balance', 'emp_id', $_SESSION['user_id']);
			$data['can_take_sbs'] = FALSE;	
			if ($sbs_emp) {
				foreach ($sbs_emp as $sbs) 
				{
					$remaining_days = $sbs['remain_days'];
				}
				if ($remaining_days > 0) 
				{
					$data['can_take_sbs'] = TRUE;
				}
			}

			// disabling multiple button at initial stage / as page refreshes
			$i = TRUE; 
			foreach ($data['leaves'] as $value) {
            	if ($i == TRUE) {
            		if ($value['is_one_day'] == 1) {
	            		$data['disableMultipleBtn'] = TRUE;
            		}
              		$data['remainingDuration'] = $value['remain_days']; $i = FALSE;
            	}
            }

			if ($this->input->post('submit') != NULL) {
				$leave = $this->input->post();

				$data['clb'] = $this->Employee_model->checkLeaveBalance($_SESSION['user_id'], (int)$leave['leave_id']);

				// is_one_day validation
				$emp_leave = $this->Database_model->find('leaves', 'leave_id', $leave['leave_id']);
				foreach ($emp_leave as $value) {
					$is_one_day = $value['is_one_day'];
				}
				if ($is_one_day == 1 && isset($leave['to_date'])) {
					$data['leave_form'] = $leave; 

					// disabling the multiple button after form submission
					if ($is_one_day == 1) $data['leave_form']['disableMultipleBtn'] = TRUE; 

					$data['not_valid'] = $data['clb']['l_leave_name'] . ' Leave cannot have \'Multiple Days\' as Duration Type.';
					$this->view('leave_form', $title, $data);
					return;
				}

				// from_date and to_date validation
				if (!empty($leave['to_date'])) {	
					// if from-date is greater than to date
					if ($leave['to_date'] < $leave['from_date']) {	
						$data['leave_form'] = $leave; 
						$data['not_valid_inject'] = 'From-date cannot be greater than to-date';
						$this->view('leave_form', $title, $data);
						return;
					}
					// if user tries to submit more than 0.5 day for half day
					if ($leave['duration_type'] == 'half' && (round((strtotime($leave['to_date']) - strtotime($leave['from_date'])) / 86400)) > 0.5) { 
						$data['leave_form'] = $leave; 
						$data['not_valid_inject'] = 'Half day has exceeded 1/2 day.';
						$this->view('leave_form', $title, $data);
						return;
					}
					// if user tries to submit more than 1 day for full day
					if ($leave['duration_type'] == 'full' && (round((strtotime($leave['to_date']) - strtotime($leave['from_date'])) / 86400) + 1) > 1) {
						$data['leave_form'] = $leave; 
						$data['not_valid_inject'] = 'A full day cannot be greater than 1 day.';
						$this->view('leave_form', $title, $data);
						return;
					}
				}

				// checking leave balance (if the remaining days exceeds more than the requested days)
				if ($leave['duration_type'] == 'half') {
					if ($data['clb']['elb_remain_days'] < 0.5) {
						$data['leave_form'] = $leave; 

						// disabling the multiple button after form submission
						if ($is_one_day == 1) $data['leave_form']['disableMultipleBtn'] = TRUE; 

						$data['not_valid'] = 'You have only <script type="text/javascript"> document.write(trim_day('. $data['clb']['elb_remain_days'] .')); </script> left for '. $data['clb']['l_leave_name'].'.';
						$this->view('leave_form', $title, $data);
						return;
					}
				}
				else if ($leave['duration_type'] == 'full') {
					if ($data['clb']['elb_remain_days'] < 1) {
						$data['leave_form'] = $leave; 
						
						// disabling the multiple button after form submission
						if ($is_one_day == 1) $data['leave_form']['disableMultipleBtn'] = TRUE; 

						$data['not_valid'] = 'You have only <script type="text/javascript"> document.write(trim_day('. $data['clb']['elb_remain_days'] .')); </script> left for '. $data['clb']['l_leave_name'].'.';
						$this->view('leave_form', $title, $data);
						return;
					}
				}
				else {
					if ($data['clb']['elb_remain_days'] < (round((strtotime($leave['to_date']) - strtotime($leave['from_date'])) / 86400) + 1)) {
						$data['leave_form'] = $leave; 
						$data['not_valid'] = 'You have only <script type="text/javascript"> document.write(trim_day('. $data['clb']['elb_remain_days'] .')); </script> left for '. $data['clb']['l_leave_name'].'.';
						$this->view('leave_form', $title, $data);
						return;
					}
				}

				$leaveData = array(
					'emp_id'=> $_SESSION['user_id'],	// inserts current user id
					'leave_id'=> (int)$leave['leave_id'],
					'from_date'=> $leave['from_date'],
					'duration_type' => $leave['duration_type'],
					'duty_performed_by'=> (int)$leave['duty_performed_by'],
					'reason'=> trim($leave['reason']),
					'recommender_id'=>$this->Admin_model->getRecommenderId($_SESSION['user_id']),
					'approver_id'=>$this->Admin_model->getApproverId($_SESSION['user_id'])
				);

				if (!empty($leave['to_date'])) {
					$leaveData['to_date'] = $leave['to_date'];
				}

				$this->Database_model->insert('employee_leaves', $leaveData);

				$data['valid'] = TRUE; 

				// sending email to employee who requested leave
				$leavename=$this->Admin_model->getNameByLid($leave['leave_id']);
				$message="Your ".$leavename." from ".$leave['from_date']. " has been sent for processing.";
				$email=$this->Admin_model->getEmail();
				$this->Admin_model->sendEmail('Leave Applied',$message,$email);

				//sending mail to recommender
				$requester_name=$this->Admin_model->getName($_SESSION['user_id']);
				$message=$leavename." has been applied by ".$requester_name." from ".$leave['from_date'];
				$recId=$this->Admin_model->getRecommenderId($_SESSION['user_id']);
				$email=$this->Admin_model->getEmail($recId)
				;
				$titleEmail="Leave Requested by ".$requester_name;
				$this->Admin_model->sendEmail($titleEmail,$message,$email);

				$this->view('leave_form', $title, $data);
			} 
			else {
				$this->view('leave_form', $title, $data);
			}


		}


		// archive Substitute Leave by Recommender
		public function archiveSubstituteRecord()
		{
			extract($_POST);
			$this->Database_model->update('substitute_leaves', array('is_archived' => '1'), 'id', $id);
		}

		// Un-archive Substitute Leave by Recommender
		public function unArchiveSubstituteRecord()
		{
			extract($_POST);
			$this->Database_model->update('substitute_leaves', array('is_archived' => '0'), 'id', $id);
		}


		// archived Substitute leaves 
		public function leaveSubstituteArchive()
		{	
			$title['title'] = 'Archived Substitute Leaves';
			$data['employee_leaves_substitute'] = $this->Employee_model->findSubstituteLeavesArchived();
			$this->view('leave_substitute_archive', $title, $data);

		}
		

		public function leaveSubstituteForm()
		{
			$title['title'] = 'Substitute Leave Form';

			// testing
			// increase the Substitue Leave Balance of an employee
			// $substitute_emp = $this->Database_model->find('substitute_balance', 'emp_id', 317);

			// foreach ($substitute_emp as $sbs) {
			// 	$remaining_days = $sbs['remain_days'];

			// $remaining_days = $remaining_days + 1;

			// $this->Database_model->update('substitute_balance', array('remain_days' => $remaining_days), 'emp_id', 317);

			// $substitute_emp = $this->Database_model->find('substitute_balance', 'emp_id', 317);
			// }

			if ($this->input->post('submit') != NULL) {
				$leave = $this->input->post();
				$employee = $this->Database_model->find('employee_approvers', 'emp_id', $_SESSION['user_id']);

				foreach ($employee as $emp) {
					$recommender_id = $emp['recommender_id'];
				}

				$substituteLeave = array(
					'emp_id'=> (int)$_SESSION['user_id'],	// inserts current user id
					'recommender_id' => (int)$recommender_id,
					'date'=> $leave['date'],
					'description' => $leave['description']
				);

				// var_dump($substituteLeave); die();
				$this->Database_model->insert('substitute_leaves', $substituteLeave);

				$data['valid'] = TRUE; 
				// send mail to recommender
				$message="A substitute leave has been requested by an employee.";
				$this->Admin_model->sendEmail('Substitute Leave Request',$message,$this->Admin_model->getEmail($recommender_id));

				$this->view('leave_substitute_form', $title, $data);
			} 
			else {
				$this->view('leave_substitute_form', $title);
			}
		}


		// leave recommend to approver
		public function recommendLeave()
		{
			
			extract($_POST);
			
			$data=array('is_recommended'=>'recommended','recommender_id'=>$_SESSION['user_id']);
			$this->db->where('id',$l_id);
			$this->db->update('employee_leaves',$data);

			$this->db->where('id',$l_id);
			$getDetail=$this->db->get('employee_leaves');
			$list=$getDetail->row_array();

			// send email to leave requester
			$recommender_name=$this->Admin_model->getName($_SESSION['user_id']);
			$leavename=$this->Admin_model->getNameById($l_id);

			$message="Your ".$leavename." from ".$list['from_date']." has been recommended by ".$recommender_name." and waiting to be approved";

			$email=$this->Admin_model->getEmail($list['emp_id']);
			$this->Admin_model->sendEmail('Leave Recommended',$message,$email);
			// end of send mail

			//send email to approver to approve the leave request
				$message=$recommender_name." has recommended a ".$leavename." and is waiting for your approval. ";
				$reqId=$this->Admin_model->getEmpIdbyLID($l_id);
				$recId=$this->Admin_model->getRecommenderId($reqId);
				$email=$this->Admin_model->getEmail($recId)
				;
				$title="New Leave Request";
				$this->Admin_model->sendEmail($title,$message,$email);
		
		}

		
		// deny leave by recommender
		public function denyLeaveFromRecommender()
		{
			
			extract($_POST);
			$data=array('is_recommended'=>'denied','denial_reason'=>$denial_reason,'recommender_id'=>$_SESSION['user_id']);
			$this->db->where('id',$id);
			$this->db->update('employee_leaves',$data);

			// send email to leave requester
			$this->db->where('id',$id);
			$getDetail=$this->db->get('employee_leaves');
			$list=$getDetail->row_array();

			$recommender_name=$this->Admin_model->getName($_SESSION['user_id']);
			$leavename=$this->Admin_model->getNameById($id);

			$message="Your ".$leavename." from ".$list['from_date']. " has been denied by ".$recommender_name.".";
			$message .='<br><br>';
			$message .="Reason for Leave Denied is:<br>".$denial_reason;
			$email=$this->Admin_model->getEmail($list['emp_id']);
			$this->Admin_model->sendEmail('Leave Denied by Recommender',$message,$email);
			// end of send mail

		}

		// deny leave by Approver
		public function denyLeaveFromApprover()
		{
			extract($_POST);
			$data=array('is_approved'=>'denied', 'denial_reason'=>$denial_reason,'approver_id'=>$_SESSION['user_id']);
			$this->db->where('id',$id);
			$this->db->update('employee_leaves',$data);

			// send email to leave requester
			$this->db->where('id',$id);
			$getDetail=$this->db->get('employee_leaves');
			$list=$getDetail->row_array();

			$approver_name=$this->Admin_model->getName($_SESSION['user_id']);
			$leavename=$this->Admin_model->getNameById($id);
			$message="Your ".$leavename." from ".$list['from_date']. " has been denied by ".$approver_name.".";
			$message .='<br><br>';
			$message .="Reason for Leave Denied is:<br>".$denial_reason;

			$email=$this->Admin_model->getEmail($list['emp_id']);
			$this->Admin_model->sendEmail('Leave Denied by Approver',$message,$email);
			// end of send mail
		}


// add personal details
	public function addPersonalInformation()
	{
		$status=array();
		extract($_POST);
		$data=array(
			'gender'=>$gender,
			'dob'=>$dob,
			'email'=>$email
		);

		$id=$_SESSION['user_id'];

		$this->Admin_model->update_employee($data,$id);
		$status=array('true');
		echo json_encode($status);
	}

//Address form
	public function addAddress()
	{
		$status=array();
		extract($_POST);

//validate
		$this->form_validation->set_rules('currentaddress_street','Current street','required|trim',array('required' => 'You must provide a %s.'));

		$this->form_validation->set_rules('currentaddress_municipality','Current municipality','required|trim',array('required' => 'You must provide a %s.'));

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
				$id=$_SESSION['user_id'];
				$primary_id=$this->Admin_model->update_address($primaryAdd,$id);
					
			}
			else{
				$primary_id=$check['address_id'];
			}

			$query=$this->db->get_where("addresses",$secondaryAdd);
			$check=$query->row_array();

			if($check==''){
				$id=$_SESSION['user_id'];
				$secondary_id=$this->Admin_model->update_address($secondaryAdd,$id);
			}
			else{
				$secondary_id=$check['address_id'];
			}
				$id=$_SESSION['user_id'];

			$this->Admin_model->update_employee_address($primary_id,$secondary_id,$id);

			$status=array('true');
		}
		echo json_encode($status);
	} 

		public function profile()
		{	
			$data['post'] = $this->Database_model->getEmployeeDetails($_SESSION['user_id']);
			$data['work_experience'] = $this->Database_model->find('employee_work_experience', 'emp_id', $_SESSION['user_id']);
			$data['documents'] = $this->Database_model->find('employee_documents', 'emp_id', $_SESSION['user_id']);
		
			$title['title'] = $data['post']['first_name'] .' '. $data['post']['middle_name'] .' '. $data['post']['last_name'];
			$data['recommender_id']=$this->Admin_model->getRecommenderApprover($_SESSION['user_id']);
			$data['recommender_name']=$this->Admin_model->employeeList();
			$data['package_name']=$this->Admin_model->packageManage();
			$this->view('profile', $title, $data);
		}

		// approve status on table 'employee_leaves' and update leave balance on table 'employee_leave_balance'
		public function leaveApprove()
		{
			extract($_POST);

			$data['leave_by_emp'] = $this->Database_model->find('employee_leaves', 'id', $id);
			$data['leave_blnc_by_emp'] = $this->db->get_where('employee_leave_balance', array('emp_id =' => $e_id, 'leave_id =' => $leave_id))->row_array();

			$remaining_days = $this->Employee_model->checkLeaveBalance($e_id, $leave_id);
		
			if ($d_type == 'half') {
				$leaveBalance =  $remaining_days['elb_remain_days'] - 0.5;
			}
			else if ($d_type == 'full') { 
				$leaveBalance =  $remaining_days['elb_remain_days'] - 1;
			}
			else if ($d_type == 'multiple') {
				$leaveBalance =  $remaining_days['elb_remain_days'] - $no_of_days;
			}
			


			// if employee request leave for Friday and Sunday separately then, Saturday is also counted as a leave within a single week
			foreach ($data['leave_by_emp'] as $lbe) {
				$from_date = $lbe['from_date'];
				$emp_id = $lbe['emp_id'];
			}

			if (date("D", strtotime($from_date)) == 'Sun') {
				if ($this->Employee_model->findLeaveOnFri(278, date("Y-m-d", strtotime("2019-08-25" . ' -2 days'))) == TRUE) { 
				 	// $this->Employee_model->leaveApprove($id, $emp_id, $leave_id, 22);
					$leaveBalance =  $leaveBalance - 1;
				}
			}

			$this->Employee_model->leaveApprove($id, $e_id, $leave_id, $leaveBalance);

			// send email to leave requester
			$this->db->where('leave_id',$leave_id);
			$getDetail=$this->db->get('employee_leaves');
			$list=$getDetail->row_array();

			$approver_name=$this->Admin_model->getName($_SESSION['user_id']);
			$leavename=$this->Admin_model->getNameByLid($leave_id);
			$message="Your ".$leavename." from ".$list['from_date']. " to ".$list['to_date']. " has been approved by ".$approver_name.".";
			
			$email=$this->Admin_model->getEmail($list['emp_id']);
			$this->Admin_model->sendEmail('Leave Approved',$message,$email);
			// end of send mail

	}

		public function denyApprove()
		{
			extract($_POST);
			$data=array('is_approved'=>'denied', 'denial_reason'=>$denial_reason);
			$this->db->where('id',$id);
			$this->db->update('employee_leaves',$data);



		}

		// archive approval lists
		public function archiveApprovalRecord()
		{
			extract($_POST);
			$data=array('is_archived_by_approver'=>'1');
			$this->db->where('id',$id);
			$this->db->update('employee_leaves',$data);
		}

		// archive recommender lists
		public function archiveRecommendRecord()
		{
			extract($_POST);
			$data=array('is_archived'=>'1');
			$this->db->where('id',$id);
			$this->db->update('employee_leaves',$data);
		}

		// unarchive recommended leaves
		public function unArchiveRecommendedLeave()
		{
			extract($_POST);
			$data=array('is_archived'=>'0');
			$this->db->where('id',$id);
			$this->db->update('employee_leaves',$data);
		}

		// unarchive approved leaves
		public function unArchiveApprovedLeave()
		{
			extract($_POST);
			$data=array('is_archived_by_approver'=>'0');
			$this->db->where('id',$id);
			$this->db->update('employee_leaves',$data);
		}

		// public function appLeaveApprove()
		// {	
		// 	$title['title'] = 'Approve Leaves';
		// 	$data['employee_leaves'] = $this->Employee_model->findApproveLeaves();

		// 	$this->view('app_leave_approve', $title, $data);
		// }



		// approve status on table 'substitute_leaves' and update leave balance on table 'substitute_balance'
		public function leaveSubstitute()
		{
			extract($_POST);

			// increase the Substitue Leave Balance of an employee
			// $substitute_emp = $this->Database_model->find('substitute_balance', 'emp_id', $emp_id);

			// foreach ($substitute_emp as $sbs) {
			// 	$remaining_days = $sbs['remain_days'];
			// }

			// $remaining_days = $remaining_days + 1;

			// $this->Database_model->update('substitute_balance', array('remain_days' => $remaining_days), 'emp_id', $emp_id);


			//get id of substitute leave
			$this->db->where('leave_name','Substitute');
			$query=$this->db->get('leaves');
			$subs=$query->row_array();

			$leave_id=$subs['leave_id'];

			//getting leave balance of employee
			$this->db->where('emp_id',$emp_id);
			$this->db->where('leave_id',$leave_id);
			$query= $this->db->get('employee_leave_balance');
			$leaveBalance=$query->row_array();

			$previous_remain_days=$leaveBalance['remain_days'];
			$remain_days=$previous_remain_days + 1;

			// Increasing leave balance of  employee
			$data=['emp_id'=>$emp_id,'leave_id'=>$leave_id,'remain_days'=>$remain_days];
			$this->db->where('emp_id',$emp_id);
			$this->db->where('leave_id',$leave_id);
			$this->db->update('employee_leave_balance',$data);

			//increasing total days on leave package table
			$data=['leave_id'=>$leave_id,'duration'=>$remain_days];
			$pkgId=$this->Admin_model->getPackageId($emp_id);
			$this->db->where('leave_id',$leave_id);
			$this->db->where('package_id',$pkgId);
			$this->db->update('leave_packages',$data);


			$this->Database_model->update('substitute_leaves', array('is_approved' => 'approved'), 'id', $id);


			// send email to employee
			$this->Admin_model->sendEmail('Substitute Leave Added','Your substitute leave has been increased by 1 day.',$this->Admin_model->getEmail($emp_id));
		}

		// deny Substitute leave by Recommender
		public function denySubstituteLeave()
		{
			extract($_POST);
			$this->Database_model->update('substitute_leaves', array('is_approved' => 'denied', 'denial_reason' => $denial_reason), 'id', $id);

			// send email to employee
			$message='Unfortunately, Your substitute leave request has been rejected.<br> The reason for denial is: <br>'.$denial_reason.'.';
			

			$this->db->where('id',$id);
			$res=$this->db->get('substitute_leaves');
			$result=$res->row_array();
			$this->Admin_model->sendEmail('Substitute Leave Rejected',$message,$this->Admin_model->getEmail($result['emp_id']));
			
		}

		



// contact form
	public function addContact()
	{
		$status=array();
		extract($_POST);
		$this->form_validation->set_rules('mobile_phone','Mobile phone','required|trim',array('required' => 'You must provide a %s.'));

		if($home_phone!='')
		{
			if(!$this->contactNumber($home_phone))
			{
				$msg="errorContact";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}

		if($other_phone1!='' || $other_phone2!='' || $other_phone3!='')
		{
			if(!$this->contactNumber($other_phone1) || !$this->contactNumber($other_phone2) || !$this->contactNumber($other_phone3))
			{
				$msg="errorContact";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}

		if(!$this->contactNumber($mobile_phone))
		{
			$msg="errorContact";
			array_push($status, $msg);
			echo json_encode($status);
			return ;
		}

		if($this->form_validation->run()===FALSE)
		{
			$status=$this->form_validation->error_array();
		}else
		{
			$data=array(
				'home_phone'=>$home_phone,
				'mobile_phone'=>$mobile_phone,
				'other_phone1'=>$other_phone1,
				'other_phone2'=>$other_phone2,
				'other_phone3'=>$other_phone3
			);
					
				$id=$_SESSION['user_id'];

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
		extract($_POST);

		$this->form_validation->set_rules('nationality','nationality','required',array('required' => 'You must provide a %s.'));

		$this->form_validation->set_rules('visa_permission',' Visa Permission','required',array('required' => 'You must select a %s.'));


		$this->form_validation->set_rules('passport_no','Passport Number','required|trim',array('required' => 'You must provide a %s.'));

		$this->form_validation->set_rules('passport_issue_place','Place of Issue','required|trim',array('required' => 'You must provide a %s.'));

		if($this->form_validation->run()===FALSE)
		{
			$status=$this->form_validation->error_array();
		}else
		{
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
					
				$id=$_SESSION['user_id'];
					

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
		
			$id=$_SESSION['user_id'];

			$this->Admin_model->update_employee($data,$id);
			$status=array('true');

		
	}
		echo json_encode($status);
	}

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
					
						$id=$_SESSION['user_id'];
					

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
		extract($_POST);

		$this->form_validation->set_rules('blood_group','Blood Group','required',array('required' => 'You must provide %s'));

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
				$msg="errorMedical";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}
		
		if($regular_medication!='')
		{
			if(!$this->alphanumeric($regular_medication) )
			{
				$msg="errorMedical";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}

		if($allergy_description!='')
		{
			if(!$this->alphanumeric($allergy_description))
			{
				$msg="errorMedical";
				array_push($status, $msg);
				echo json_encode($status);
				return ;
			}
		}

		if($this->form_validation->run()===FALSE)
		{
			$status=$this->form_validation->error_array();
		}else
		{
			$data=array(
				'blood_group'=>$blood_group,
				'medical_complications'=>$medical_complications,
				'regular_medication'=>$regular_medication,
				'allergies'=>$allergies,
				'allergy_description'=>$allergy_description
			);
					
						$id=$_SESSION['user_id'];
					

			$this->Admin_model->update_employee($data,$id);
			$status=array('true');

		}
		echo json_encode($status);
	}
	



//function for adding documents
	function addDocuments(){
	$_SESSION['path']="document"; 
		$status='';
		$_POST = $this->security->xss_clean($_POST);

		extract($_POST);

		$tmpName = $_FILES['document']['tmp_name'];
		$realName= $_FILES['document']['name'];

		// list of allowed file types
		$allowed =  array('gif','png' ,'jpg','doc','docx','pdf');

		$ext = pathinfo($realName, PATHINFO_EXTENSION);
		if(!in_array($ext,$allowed) ) {
		echo 'filerror';
		return ;
		}



		$target_path = 'assets/files/'.$realName;
		move_uploaded_file($tmpName,$target_path);

					
						$id=$_SESSION['user_id'];
					

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
				{$status='true';}

			else{ $status='false'; }

			echo $status;

		}
	// <!-- delete files from the database -->
	 function deleteFile()
	 {
	 	$_SESSION['path']="document";
		extract($_POST);
		$this->db->where('doc_id',$doc_id);
			$getFile = $this->db->get('employee_documents');
			$document= $getFile->row_array();

			$filename=$document['doc_file'];
			$path='assets/files/'.$filename;
		$this->Admin_model->deleteFile($path,$doc_id);
	}





function getWork(){
	extract($_POST);
	$this->db->where('id',$id);
	$res=$this->db->get('employee_work_experience');
	$result=$res->row_array();
	echo json_encode($result);
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
				'emp_id'=>$_SESSION['user_id']
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







function deleteWorkExp(){
	extract($_POST);
	$status=$this->Admin_model->deleteWorkExperience($id);
	echo $status;
}
//employe profile update:  edits general information
	public function updateGeneralbyEmployee()
	{
		$_POST = $this->security->xss_clean($_POST);

		$result=array();
		extract($_POST);

		if($gender!='Male' && $gender!='Female' && $gender!='Others'){
			$msg="errorgender";
			array_push($result, $msg);
			echo json_encode($result);
			return ;
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

		$this->form_validation->set_rules('email','Email address','required|trim');

		if($this->form_validation->run()===FALSE)
		{
			$result=$this->form_validation->error_array();
		}
		else
		{
			$data=array(
				
				'gender'=>$gender,
				'dob'=>$dob,
				'email'=>$email
			);
			$id=$_SESSION['user_id'];
			$this->db->where('emp_id',$id);
			if($this->db->update('employees',$data))
			{
				
				array_push($result, 'true');
			}

		}

		echo json_encode($result);
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
				'emp_id'=>$_SESSION['user_id']
			);
			$this->db->where('doc_id',$doc_id);
			$this->db->update('employee_documents',$doc_data);
			$status='true';
			echo $status;
			return ;
		}
		

		
		$tmpName = $_FILES['document']['tmp_name'];
		$realName= $_SESSION['user_id'].'-'.$_FILES['document']['name'];
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
		$id=$_SESSION['user_id'];
				
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
}
