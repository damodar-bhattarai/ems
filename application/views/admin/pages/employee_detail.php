<div class="contents">
	<div class="emp-detail">
		<a class="float-right" href="<?= site_url('admin/employee_list'); ?>" id="small-link"> <i class="fa fa-long-arrow-left" aria-hidden="true"></i> &nbsp;Go back to Employee list</a>
		<div class="detail-head">
			<div class="head-pic">
				<?= img(array('src'=>'assets/images/images.jpg', 'alt'=> 'employee image')); ?>
			</div>


			<div class="head-name">
				<div class="item-1 text-left" ><?php echo $post['title'] . '. ' .  $post['first_name'] . ' ' .  $post['middle_name'] . ' ' .  $post['last_name'];  ?></div>
				<div class="item-2 text-left"><?php echo $post['department_name']; ?></div>
				<!-- edit profile -->
				 <a href="<?= base_url('admin'); ?>/employee_manage/<?php echo $this->uri->segment(3); ?>">Edit Profile</a>
		</div>

		</div>
		<!-- profile pic ends here -->

		<!-- details starts here -->
<div class="row">
	<!-- basic info starts -->
	<div class="column col-md-4">
		<div class="column">

			<div class="card">
		<h5 class="card-header text-center alert alert-dark">Basic Info</h5>
		<div class="card-body">
			<div class="body-row ">

				<div class="item-1 text-left">Id</div>
				<div class="item-2 text-left"><?php echo $post['emp_id']; ?></div>
			</div>

			<div class="body-row ">
				<div class="item-1 text-left" >Title</div>
				<div class="item-2 text-left"><?php echo $post['title']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >First Name</div>
				<div class="item-2 text-left"><?php echo $post['first_name']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Middle Name</div>
				<div class="item-2 text-left"><?php echo $post['middle_name']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Surname</div>
				<div class="item-2 text-left"><?php echo $post['last_name']; ?></div>
			</div>

			<div class="body-row ">
				<div class="item-1 text-left" >Date of join</div>
				<div class="item-2 text-left"><?php echo $post['join_date']; ?></div>
			</div>

				<div class="body-row ">
				<div class="item-1 text-left" >Gender</div>
				<div class="item-2 text-left"><?php echo $post['gender']; ?></div>
			</div>

				<div class="body-row ">
				<div class="item-1 text-left" >Date of birth</div>
				<div class="item-2 text-left"><?php echo $post['dob']; ?></div>
			</div>



			<div class="body-row ">
				<div class="item-1 text-left" >Permanent Address</div>
				<div class="item-2 text-left"><?php if (!empty($post['p_street'])) echo $post['p_street'] . ', '; 
									      if (!empty($post['p_municipality'])) echo $post['p_municipality'] . ', ';
									      if (!empty($post['p_district'])) echo $post['p_district'] . ', ';
									      if (!empty($post['p_state'])) echo $post['p_state'] . ', ';
									      if (!empty($post['p_country'])) echo $post['p_country'] ; ?></div>
			</div>

			<div class="body-row ">
				<div class="item-1 text-left" >Temporary Address</div>
				<div class="item-2 text-left"><?php if (!empty($post['t_street'])) echo $post['t_street'] . ', '; 
									      if (!empty($post['t_municipality'])) echo $post['t_municipality'] . ', ';
									      if (!empty($post['t_district'])) echo $post['t_district'] . ', ';
									      if (!empty($post['t_state'])) echo $post['t_state'] . ', Nepal';
									      ?></div>
			</div>

			<div class="body-row ">
				<div class="item-1 text-left" >Home Phone</div>
				<div class="item-2 text-left"><?php echo $post['home_phone']; ?></div>
			</div>

			<div class="body-row ">
				<div class="item-1 text-left" >Mobile Phone</div>
				<div class="item-2 text-left"><?php echo $post['mobile_phone']; ?></div>
			</div>

			<div class="body-row ">
				<div class="item-1 text-left" >Other Phones</div>
				<div class="item-2 text-left"><?php if (!empty($post['other_phone1'])) echo $post['other_phone1'] . ', '; 
									      if (!empty($post['other_phone2'])) echo $post['other_phone2'] . ', ';
									      if (!empty($post['other_phone3'])) echo $post['other_phone3'] ; ?></div>
			</div>

			<div class="body-row ">
				<div class="item-1 text-left" >Email Id</div>
				<!-- <div class="item-2 text-left"><?php echo $post['email']; ?></div> -->
				<div class="item-2 text-left"><?php echo $post['email']; ?></div>
			</div>

			</div>
		</div>
	</div>
	<!-- basic info ends -->	
	<!-- education -->
		<div class="column ">
			<div class="card">
			<h5 class="card-header text-center alert alert-dark">Education</h5>	
			<div class="card-body">
			<div class="body-row ">
				<div class="item-1 text-left" >Highest Degree</div>
				<div class="item-2 text-left"><?php echo $post['highest_degree']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Degree Title</div>
				<div class="item-2 text-left"><?php echo $post['degree_title']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >University</div>
				<div class="item-2 text-left"><?php echo $post['university']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Institute</div>
				<div class="item-2 text-left"><?php echo $post['institute']; ?></div>
			</div>
		</div>
		</div>
	</div>

<!-- col1 end -->
<!-- education ends here -->

</div> 


<div class="column col-md-4">
	
			<!-- Nationality -->
			<div class="column">
			<div class="card">
				<h5 class="card-header text-center alert alert-dark">Nationality</h5>
			<div class="card-body">
			<div class="body-row ">
				<div class="item-1 text-left" >Nationality</div>
				<div class="item-2 text-left"><?php echo $post['nationality']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Visa Permission</div>
				<div class="item-2 text-left"><?php echo $post['visa_permission']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Visa Type</div>
				<div class="item-2 text-left"><?php echo $post['visa_type']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Visa Expiry Date</div>
				<div class="item-2 text-left"><?php echo $post['visa_expiry_date']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Passport No.</div>
				<div class="item-2 text-left"><?php echo $post['passport_no']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Place of Issue</div>
				<div class="item-2 text-left"><?php echo $post['passport_issue_place']; ?></div>
			</div>
		</div>

		</div>
		</div>
<!-- nationality ends  -->



				<!-- Emergency contact -->

		<div class="column ">
				<div class="card">
			<h5 class="card-header text-center alert alert-dark">Emergency Contact</h5>
			<div class="card-body">
			<div class="body-row ">
				<div class="item-1 text-left">Name</div>
				<div class="item-2"><?php echo $post['e_name']; ?></div>
			</div>

			<div class="body-row ">
				<div class="item-1 text-left">Relation</div>
				<div class="item-2"><?php echo $post['e_relation']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left">Contact</div>
				<div class="item-2"><?php echo $post['e_phone']; ?></div>
			</div>

			<div class="body-row ">
				<div class="item-1 text-left">Address</div>
				<div class="item-2"><?php echo $post['e_address']; ?></div>
			</div>
		</div>
		</div>
</div>	

	<!-- emergency ends here -->
<!-- health starts here -->
<div class="column ">
				<div class="card">
	<h5 class="card-header text-center alert alert-dark">Health</h5>
	<div class="card-body">
			<div class="body-row ">
				<div class="item-1 text-left" >Blood Group</div>
				<div class="item-2 text-left"><?php echo $post['blood_group']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Medical Complications</div>
				<div class="item-2 text-left"><?php echo $post['medical_complications']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Regular Medication</div>
				<div class="item-2 text-left"><?php echo $post['regular_medication']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Allergies</div>
				<div class="item-2 text-left"><?php echo $post['allergies']; ?></div>
			</div>
			<div class="body-row ">
				<div class="item-1 text-left" >Allergy Description</div>
				<div class="item-2 text-left"><?php echo $post['allergy_description']; ?></div>
			</div>
		</div>
		</div>
	</div>
		<!-- health ends here -->


		
</div>

<div class="column col-md-4">
	<!-- health starts here -->
<div class="column ">
				<div class="card">
	<h5 class="card-header text-center alert alert-dark">Work Experiences</h5>
	<div class="card-body" style="height: 500px; overflow-y: scroll;">
		<?php foreach ($work_experience as $exp) { ?>
		
			<div class="body-row ">
				<div class="item-1 text-left" >Organization</div>
				<div class="item-2 text-left"><?php echo $exp['organization']; ?></div>
			</div>
				<div class="body-row ">
				<div class="item-1 text-left" >Responsibility</div>
				<div class="item-2 text-left"><?php echo $exp['responsibility']; ?></div>
			</div>
				<div class="body-row ">
				<div class="item-1 text-left" >Position</div>
				<div class="item-2 text-left"><?php echo $exp['position']; ?></div>
			</div>
				<div class="body-row ">
				<div class="item-1 text-left" >From</div>
				<div class="item-2 text-left"><?php echo $exp['from_date']; ?></div>
			</div>
				<div class="body-row ">
				<div class="item-1 text-left" >To</div>
				<div class="item-2 text-left"><?php echo $exp['to_date']; ?></div>
			</div>
				<div class="body-row ">
				<div class="item-1 text-left" >Contact Person Number</div>
				<div class="item-2 text-left"><?php echo $exp['contact_person_number']; ?></div>
			</div>
			<hr/>
		<?php } ?>
		</div>
		</div>
	</div>
		<!-- health ends here -->


		<!-- pan -->
		<div class="column ">
				<div class="card">
			<h5 class="card-header text-center alert alert-dark">PAN</h5>
			<div class="card-body">
			<div class="body-row ">
				<div class="item-1 text-left" >PAN</div>
				<div class="item-2 text-left"><?php echo $post['pan']; ?></div>
			</div>
		</div>
		</div>
	</div>
		<!-- pan ends here -->

			<!-- Leave Arpprover -->
		<div class="column ">
				<div class="card">
			<h5 class="card-header text-center alert alert-dark"> Arpprover / Recommender</h5>
			<div class="card-body">
			<div class="body-row ">
				<div class="item-1 text-left" > Recommender</div>
				<div class="item-2 text-left">
					<?php foreach ($recommender_name as $key => $value) {
						if($value['emp_id']==$recommender_id['recommender_id'])
							echo $value['first_name'].' '.$value['middle_name']. ' '. $value['last_name'];
					} ?>
					
			</div>
				</div>
			<div class="body-row ">
				<div class="item-1 text-left" > Arpprover</div>
				<div class="item-2 text-left"><?php foreach ($recommender_name as $key => $value) {
						if($value['emp_id']==$recommender_id['approver_id'])
							echo $value['first_name'].' '.$value['middle_name']. ' '. $value['last_name'];
					} ?></div>
			</div>

			<!-- package name -->
			<div class="body-row ">
				<div class="item-1 text-left" > Package Name</div>
				<div class="item-2 text-left"><?php foreach ($package_name as $key => $value) {
						if($value['package_id']==$post['package_id'])
							echo $value['package_name'];
					} ?></div>
			</div>
		</div>
		</div>
	</div>
		<!-- Leave Arpprover ends here -->
		
</div>
	</div>
	</div>
	</div>
</div>