<?php
	class Database_model extends CI_Model {

		////////////////////// INSERT / UPDATE Query Functions ////////////////////////
		
		// save function
		public function save($tablename,$data, $pk = '',$id='')
		{
			try{ insert_table($tablename,$data); }
	       
	   		catch(Exception $e){  update_table($tablename,$data, $pk);  }
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

		////////////////////// SELECT Query Functions ////////////////////////

		// find a specific data 
		public function find($table, $field, $id) 
		{
			return $this->db->query('SELECT * from ' . $table . ' WHERE ' . $field . ' = ' . $id . '')->result_array();
		}

		// find all data from a specific table
		public function findAll($table, $select = '*') 
		{
			$query = $this->db->select($select);
			$query = $this->db->get($table);
			return $query->result_array();
		}

		

		public function findDescending($table, $field, $id, $sort_id)
		{
					return $this->db->query('SELECT * from ' . $table . ' WHERE ' . $field . ' = ' . $id . ' ORDER BY '. $sort_id. ' DESC ' )->result_array();

		}
		////////////////////// DELETE Query Functions ////////////////////////



		// querying all data related to employee
		public function getEmployeeDetails($id = FALSE) {

			$project = "SELECT *, e.emp_id AS employee_id, e.email AS email,
				               a.street AS p_street, a.municipality AS p_municipality, a.district AS p_district, a.state AS p_state, a.country AS p_country, 
				               asec.street AS t_street, asec.municipality AS t_municipality, asec.district AS t_district, asec.state AS t_state, asec.country AS t_country 
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
	}












