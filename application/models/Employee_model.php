<?php
	class Employee_model extends CI_Model {
	
		public function findAllLeaves($emp_id = FALSE, $leave_id = FALSE)
		{
			$project = "SELECT *, el.emp_id as em
					    FROM employee_leaves el
					    LEFT JOIN leaves l ON l.leave_id = el.leave_id
					    LEFT JOIN employees e ON e.emp_id = el.duty_performed_by";

			
			if ($leave_id !== FALSE && $emp_id !== FALSE) {	
				$project = $project . ' WHERE el.leave_id = ' . $leave_id . ' AND el.emp_id = ' . $emp_id . ' ORDER BY el.id DESC';
				$query = $this->db->query($project);
				return $query->result_array();
			}
			else if ($emp_id !== FALSE && $leave_id === FALSE) {	
				$project = $project . ' WHERE el.emp_id = ' . $emp_id . ' ORDER BY el.id DESC';
				$query = $this->db->query($project);
				return $query->result_array();
			}
			else if ($emp_id === FALSE && $leave_id === FALSE) {	
				$project = $project . ' ORDER BY el.id DESC';
				$query = $this->db->query($project);
				return $query->result_array();
			}
		}
	
		public function leaveDetail($id, $r_days = FALSE){
			$leaves= "SELECT e.emp_id,e.package_id,p.package_name,lp.leave_id,l.leave_name,lp.duration,elb.remain_days, l.is_one_day
					FROM employees e
					JOIN packages p ON e.package_id=p.package_id
					JOIN leave_packages lp ON p.package_id=lp.package_id
					JOIN leaves l ON lp.leave_id=l.leave_id
					JOIN employee_leave_balance elb ON l.leave_id=elb.leave_id AND e.emp_id=elb.emp_id
					WHERE e.emp_id=$id";

			if ($r_days !== FALSE) {
				$leaves = $leaves . " AND elb.remain_days > $r_days";
				$query = $this->db->query($leaves);
				return $query->result_array();
			}

			$query = $this->db->query($leaves);
				return $query->result_array();
 
			// $this->db->select('e.emp_id,e.package_id,p.package_name,lp.leave_id,l.leave_name,lp.duration,elb.remain_days');
			// $this->db->from('employees e');
			// $this->db->join('packages p', 'e.package_id = p.package_id');
			// $this->db->join('leave_packages lp','p.package_id=lp.package_id');
			// $this->db->join('leaves l','lp.leave_id=l.leave_id');
			// $this->db->join('employee_leave_balance elb','l.leave_id=elb.leave_id');
			// $this->db->join('employee_leave_balance elb2','e.emp_id=elb2.emp_id');
			// $this->db->where('e.emp_id',$id);
			// $query = $this->db->get();		
			// return $query->result_array();

		}

		public function checkLeaveBalance($id, $leave_id){
			$leaves= "SELECT l.leave_name AS l_leave_name, elb.remain_days AS elb_remain_days
					FROM employees e
					JOIN packages p ON e.package_id=p.package_id
					JOIN leave_packages lp ON p.package_id=lp.package_id
					JOIN leaves l ON lp.leave_id=l.leave_id
					JOIN employee_leave_balance elb ON l.leave_id=elb.leave_id AND e.emp_id=elb.emp_id
					WHERE e.emp_id=$id AND elb.leave_id = $leave_id";
			$query = $this->db->query($leaves);
			return $query->row_array();
		}

		public function findApproveLeaves($id = FALSE)
		{
			$approver=$_SESSION['user_id'];
			$project = "SELECT *, el.id AS elId, el.emp_id AS e_id, e.first_name AS e_first_name, e.middle_name AS e_middle_name, e.last_name AS e_last_name, dpb.first_name AS dpb_first_name, dpb.middle_name AS dpb_middle_name, dpb.last_name AS dpb_last_name, ea.approver_id AS aid, eaid.first_name AS eaid_first_name, eaid.middle_name AS eaid_middle_name, eaid.last_name AS eaid_last_name, l.leave_id AS lID

					    FROM employee_leaves el
					    LEFT JOIN leaves l ON l.leave_id = el.leave_id 
					    LEFT JOIN employees e ON e.emp_id = el.emp_id 
					    LEFT JOIN employee_approvers ea ON ea.emp_id = el.emp_id 
					    LEFT JOIN employees eaid ON ea.approver_id = eaid.emp_id 
					    LEFT JOIN employees dpb ON dpb.emp_id = el.duty_performed_by 
						WHERE el.is_archived_by_approver = '0' AND  ea.approver_id=$approver AND el.is_recommended = 'recommended' OR el.is_approved = 'denied' AND el.is_archived_by_approver = '0' AND  ea.approver_id=$approver
						ORDER BY el.id DESC";

			if ($id === FALSE) {	
				// $project = $project . ' WHERE el.is_recommended = recommended';ss
				// $this->db->order_by('emp_id', 'DESC');
				$query = $this->db->query($project);
				return $query->result_array();
			}

			$project = $project . ' WHERE el.id = ' . $id ;
			$query = $this->db->query($project);
			
			return $query->row_array();
		}

		// get list of archived leaves
		public function findArchivedApproveLeaves($id = FALSE)
		{
			$approver=$_SESSION['user_id'];
			$project = "SELECT *, el.emp_id AS e_id, e.first_name AS e_first_name, e.middle_name AS e_middle_name, e.last_name AS e_last_name, dpb.first_name AS dpb_first_name, dpb.middle_name AS dpb_middle_name, dpb.last_name AS dpb_last_name, ea.approver_id AS aid, eaid.first_name AS eaid_first_name, eaid.middle_name AS eaid_middle_name, eaid.last_name AS eaid_last_name, l.leave_id AS lID

					    FROM employee_leaves el
					    LEFT JOIN leaves l ON l.leave_id = el.leave_id 
					    LEFT JOIN employees e ON e.emp_id = el.emp_id 
					    LEFT JOIN employee_approvers ea ON ea.emp_id = el.emp_id 
					    LEFT JOIN employees eaid ON ea.approver_id = eaid.emp_id 
					    LEFT JOIN employees dpb ON dpb.emp_id = el.duty_performed_by 
						WHERE el.is_archived_by_approver = '1' AND  ea.approver_id=$approver AND el.is_recommended = 'recommended' OR el.is_approved = 'denied' AND el.is_archived_by_approver = '1' AND  ea.approver_id=$approver
						ORDER BY el.id DESC";

			if ($id === FALSE) {	
				// $project = $project . ' WHERE el.is_recommended = recommended';ss
				// $this->db->order_by('emp_id', 'DESC');
				$query = $this->db->query($project);
				return $query->result_array();
			}

			$project = $project . ' WHERE el.id = ' . $id ;
			$query = $this->db->query($project);
			
			return $query->row_array();
		}

		public function findSubstituteLeavesArchived($id = FALSE)
		{
			$recommender=$_SESSION['user_id'];
			$project = "SELECT *, sl.id AS slId, sl.emp_id AS e_id, e.first_name AS e_first_name, e.middle_name AS e_middle_name, e.last_name AS e_last_name

					    FROM substitute_leaves sl
					    LEFT JOIN employees e ON e.emp_id = sl.emp_id 
					    LEFT JOIN employee_approvers ea ON ea.emp_id = sl.emp_id 
					    LEFT JOIN employees esid ON ea.recommender_id = esid.emp_id 
						WHERE sl.is_archived = '1' AND  ea.recommender_id=$recommender
						ORDER BY sl.id DESC";

			if ($id === FALSE) {	
				$query = $this->db->query($project);
				return $query->result_array();
			}

			$project = $project . ' WHERE sl.id = ' . $id ;
			$query = $this->db->query($project);
			
			return $query->row_array();
		}

		// fetch leaves information
		public function recommendationList($is_archived)
		{
			$recommender = $_SESSION['user_id'];
			$this->db->join('employees', 'employee_leaves.emp_id = employees.emp_id');
			$this->db->join('leaves', 'employee_leaves.leave_id = leaves.leave_id');
			$this->db->join('employee_approvers', 'employee_leaves.emp_id =employee_approvers.emp_id');
			$this->db->where('employee_leaves.is_archived', $is_archived);
			$this->db->where('employee_approvers.recommender_id', $recommender);
			$this->db->order_by('id','DESC');
			$query = $this->db->get('employee_leaves');
			return $query->result_array();
		}

		public function leaveApprove($id, $e_id, $leave_id, $leaveBalance)
		{
			// update leave balance on table 'employee_leave_balance'
			$data1=array('remain_days'=>$leaveBalance);
			$array = array('emp_id' => $e_id, 'leave_id' => $leave_id);
			$this->db->where($array); 
			$this->db->update('employee_leave_balance',$data1);		

			// update status on column 'is_archived' on table 'employee_leave_balance'
			$data2=array('is_approved'=>'approved','approver_id'=>$_SESSION['user_id']);
			$this->db->where('id',$id);
			$this->db->update('employee_leaves',$data2);
		}


		//employee's recommender and approver
		public function getRecommenderApprover($id)
		 {
		 	
			$this->db->join('employees', 'employee_approvers.emp_id = employees.emp_id');
			$query = $this->db->get('employee_approvers');
			return $query->row_array();
		 } 

		 // list of employeees
		 public function employeeList() {
			$this->db->join('departments', 'departments.id=employees.department_id');
			$this->db->where('is_active', '1');
			$query = $this->db->get('employees');
			return $query->result_array();
		}

		// package lists
		public function packageManage() {
			$query = $this->db->get('packages'); 
			return $query->result_array();
 			}

 		// check leave on Friday by an Employee
 		public function findLeaveOnFri($emp_id, $date) 
		{
			if ($this->db->query("SELECT * from employee_leaves WHERE (emp_id = $emp_id AND from_date = '".$date."' AND is_approved = 'approved' AND duration_type != 'half') OR (emp_id = $emp_id AND to_date = '".$date."' AND is_approved = 'approved' AND duration_type != 'half')")->num_rows() >= 1) { 
				return TRUE;
			} else {
				return FALSE;
			}
		}

		public function findSubstituteLeaves($id = FALSE)
		{
			$recommender=$_SESSION['user_id'];
			$project = "SELECT *, sl.id AS slId, sl.emp_id AS e_id, e.first_name AS e_first_name, e.middle_name AS e_middle_name, e.last_name AS e_last_name

					    FROM substitute_leaves sl
					    LEFT JOIN employees e ON e.emp_id = sl.emp_id 
					    LEFT JOIN employee_approvers ea ON ea.emp_id = sl.emp_id 
					    LEFT JOIN employees esid ON ea.recommender_id = esid.emp_id 
						WHERE sl.is_archived = '0' AND  ea.recommender_id=$recommender
						ORDER BY sl.id DESC";

			if ($id === FALSE) {	
				$query = $this->db->query($project);
				return $query->result_array();
			}

			$project = $project . ' WHERE sl.id = ' . $id ;
			$query = $this->db->query($project);
			
			return $query->row_array();
		}

// this returns each employee's substitute leave balance
		public function findSubstituteLeaveBalance($id)
		{
			//get id of substitute leave
			$this->db->where('leave_name','Substitute');
			$query=$this->db->get('leaves');
			$subs=$query->row_array();

			$leave_id=$subs['leave_id'];

			$this->db->where('emp_id',$id);
			$this->db->where('leave_id',$leave_id);
			$query=$this->db->get('employee_leave_balance');
			$result=$query->row_array();
			return $result;

		}

// funtion to show employees only NOT ADMIN
		public function showEmployeesOnly()
		{
			$this->db->join('users', 'users.user_id=employees.emp_id');
			$this->db->join('user_roles', 'user_roles.user_id=users.user_num');
			$this->db->where('user_roles.role_id=2');
			$query=$this->db->get('employees');
			return $query->result_array();
		}



	}
