<?php
ini_set('max_execution_time', 0);
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Create database
$sql = "CREATE DATABASE ems";
if ($conn->query($sql) === TRUE) {
  
mysqli_select_db($conn,'ems');
//creating table address
$query1=mysqli_query($conn,"CREATE TABLE `addresses` (
  `address_id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `municipality` varchar(255) NOT NULL,
  `district` varchar(255) NOT NULL,
  `state` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");


//creating table for contacts
$query2=mysqli_query($conn,"CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `home_phone` varchar(255) DEFAULT NULL,
  `mobile_phone` varchar(255) DEFAULT NULL,
  `other_phone1` varchar(255) DEFAULT NULL,
  `other_phone2` varchar(255) DEFAULT NULL,
  `other_phone3` varchar(255) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");


//creating a table for department
$query3=mysqli_query($conn,"CREATE TABLE `departments` (
  `id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

//input department data
$query4=mysqli_query($conn,"INSERT INTO `departments` (`id`, `department_name`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(2, '+2', '', '2019-08-08 06:03:37', '', '2019-08-08 06:03:37'),
(3, 'A-Level', '', '2019-08-08 06:03:49', '', '2019-08-08 06:03:49'),
(4, 'Computing', '', '2019-08-08 06:04:01', '', '2019-08-08 06:04:01'),
(5, 'Environment Science', '', '2019-08-08 06:04:01', '', '2019-08-08 06:04:01'),
(6, 'Management', '', '2019-08-08 06:04:10', '', '2019-08-08 06:04:10')
");


// creating email_notifications table
$query5=mysqli_query($conn,"CREATE TABLE `email_notifications` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

//creating a table for department
$query6=mysqli_query($conn,"CREATE TABLE `employees` (
  `emp_id` int(11) NOT NULL,
  `is_department_head` enum('0','1') NOT NULL DEFAULT '0',
  `title` enum('Mr','Ms','Mrs','Dr') NOT NULL,
  `first_name` varchar(255) NOT NULL,
  `middle_name` varchar(255) DEFAULT NULL,
  `last_name` varchar(255) NOT NULL,
  `join_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL,
  `department_id` int(11) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `email` varchar(255) DEFAULT NULL,
  `nationality` varchar(255) NOT NULL,
  `visa_permission` varchar(255) NOT NULL,
  `visa_type` varchar(255) DEFAULT NULL,
  `visa_expiry_date` date DEFAULT NULL,
  `passport_no` varchar(255) DEFAULT NULL,
  `passport_issue_place` varchar(255) DEFAULT NULL,
  `e_name` varchar(255) DEFAULT NULL,
  `e_relation` varchar(255) DEFAULT NULL,
  `e_address` varchar(255) DEFAULT NULL,
  `e_phone` varchar(255) DEFAULT NULL,
  `highest_degree` enum('','PhD','Master','Bachelor','High School','Middle School') NOT NULL,
  `degree_title` varchar(255) NOT NULL,
  `university` varchar(255) DEFAULT NULL,
  `institute` varchar(255) NOT NULL,
  `dob` date NOT NULL,
  `gender` enum('Male','Female','Others') NOT NULL,
  `blood_group` enum('','A +ve','A -ve','B +ve','B -ve','AB +ve','AB -ve','O +ve','O -ve') NOT NULL,
  `medical_complications` text,
  `regular_medication` text,
  `allergies` varchar(255) NOT NULL,
  `allergy_description` text,
  `pan` varchar(255) DEFAULT NULL,
  `previous_employer` varchar(255) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `is_approver` enum('0','1') NOT NULL DEFAULT '0',
  `is_recommender` enum('0','1') NOT NULL DEFAULT '0',
  `is_on_leave` enum('0','1') NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

//input department data
$query7=mysqli_query($conn,"INSERT INTO `employees` (`emp_id`, `is_department_head`, `title`, `first_name`, `middle_name`, `last_name`, `join_date`, `is_active`, `department_id`, `created_by`, `created_date`, `modified_by`, `modified_date`, `email`, `nationality`, `visa_permission`, `visa_type`, `visa_expiry_date`, `passport_no`, `passport_issue_place`, `e_name`, `e_relation`, `e_address`, `e_phone`, `highest_degree`, `degree_title`, `university`, `institute`, `dob`, `gender`, `blood_group`, `medical_complications`, `regular_medication`, `allergies`, `allergy_description`, `pan`, `previous_employer`, `package_id`, `is_approver`, `is_recommender`, `is_on_leave`) VALUES
(276, '0', 'Mr', 'Graham', '', 'Riggs', '2019-07-29', 1, 3, '', '2019-07-29 06:02:13', NULL, '2019-07-29 06:02:13', 'candy.khando@gmail.com', 'Non-Nepalese', 'Yes', '123', '2019-08-23', '234', '234', 'o', 'p', '', 'p[', '', '', '', '123', '1960-11-30', 'Male', 'A -ve', '', '', 'Yes', '123', 'jqdslkjaslk', NULL, NULL, '1', '1', '0')");


// creating employee_addresses table
$query8=mysqli_query($conn,"CREATE TABLE `employee_addresses` (
  `emp_id` int(11) NOT NULL,
  `primary_addressId` int(11) DEFAULT NULL,
  `secondary_addressId` int(11) DEFAULT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");


//creating approvers table
$query9=mysqli_query($conn,"CREATE TABLE `employee_approvers` (
  `ea_id` int(11) NOT NULL,
  `approver_id` int(11) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `recommender_id` int(11) DEFAULT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(255) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

$query10=mysqli_query($conn,"CREATE TABLE `employee_contacts` (
  `emp_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(50) NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// creating employee_documents table
$query11=mysqli_query($conn,"CREATE TABLE `employee_documents` (
  `doc_id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `doc_title` varchar(255) DEFAULT NULL,
  `doc_file` text NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(255) DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// creating employee_leaves table
$query12=mysqli_query($conn,"CREATE TABLE `employee_leaves` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `recommender_id` int(11) DEFAULT NULL,
  `approver_id` int(11) DEFAULT NULL,
  `package_id` int(11) DEFAULT NULL,
  `is_approved` enum('pending','approved','denied') NOT NULL DEFAULT 'pending',
  `duration_type` varchar(255) NOT NULL,
  `is_recommended` enum('pending','denied','recommended') NOT NULL DEFAULT 'pending',
  `leave_applied_date` date NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date DEFAULT NULL,
  `duty_performed_by` int(11) NOT NULL,
  `reason` text NOT NULL,
  `denial_reason` text,
  `approved_date` date NOT NULL,
  `recommended_date` date NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(255) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `is_archived` enum('0','1') NOT NULL,
  `is_archived_by_approver` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// creating employee_leave_balance table
$query13=mysqli_query($conn,"CREATE TABLE `employee_leave_balance` (
  `emp_id` int(11) NOT NULL,
  `leave_id` int(11) NOT NULL,
  `remain_days` double(11,2) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");


// creating employee_work_experience table
$query14=mysqli_query($conn,"CREATE TABLE `employee_work_experience` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `from_date` date NOT NULL,
  `to_date` date NOT NULL,
  `organization` varchar(255) NOT NULL,
  `responsibility` text NOT NULL,
  `position` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `created_by` varchar(255) NOT NULL,
  `contact_person_number` int(11) NOT NULL,
  `modified_by` varchar(255) NOT NULL,
  `modified_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// creating leaves table
$query15=mysqli_query($conn,"CREATE TABLE `leaves` (
  `leave_id` int(11) NOT NULL,
  `leave_name` varchar(255) NOT NULL,
  `is_one_day` enum('0','1') NOT NULL DEFAULT '0',
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(255) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");


// inserting required data into leaves table
$query16=mysqli_query($conn,"INSERT INTO `leaves` (`leave_id`, `leave_name`, `is_one_day`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 'Substitute', '1', '', '2019-09-03 05:35:38', NULL, '2019-09-03 05:35:38')
");

// creating leaves_packages table
$query17=mysqli_query($conn,"CREATE TABLE `leave_packages` (
  `leave_id` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `duration` int(11) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(255) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// creating managers table
$query18=mysqli_query($conn,"CREATE TABLE `managers` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// creating modules table
$query19=mysqli_query($conn,"CREATE TABLE `modules` (
  `module_id` int(11) NOT NULL,
  `module_name` varchar(255) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// creating packages table 
$query20=mysqli_query($conn,"CREATE TABLE `packages` (
  `package_id` int(11) NOT NULL,
  `package_name` varchar(255) NOT NULL,
  `created_by` varchar(255) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(255) DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// creating permissions table
$query21=mysqli_query($conn,"CREATE TABLE `permissions` (
  `permission_id` int(11) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// creating roles table
$query22=mysqli_query($conn,"CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// insert data into the roles table
$query23=mysqli_query($conn,"INSERT INTO `roles` (`role_id`, `role_name`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 'admin', '', '2019-08-01 09:04:05', NULL, '2019-08-01 09:04:05'),
(2, 'employee', '', '2019-08-01 09:04:05', NULL, '2019-08-01 09:04:05')
");

// create role_permission_module table
$query24=mysqli_query($conn,"CREATE TABLE `role_permission_modules` (
  `module_id` int(11) NOT NULL,
  `permission_id` int(11) NOT NULL,
  `role_id` int(11) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// create table substitute_leaves
$query25=mysqli_query($conn,"CREATE TABLE `substitute_leaves` (
  `id` int(11) NOT NULL,
  `emp_id` int(11) DEFAULT NULL,
  `recommender_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `description` text,
  `denial_reason` text NOT NULL,
  `is_approved` enum('pending','denied','approved') NOT NULL DEFAULT 'pending',
  `is_archived` enum('0','1') NOT NULL DEFAULT '0',
  `created_by` int(11) DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` int(11) DEFAULT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// create users table
$query26=mysqli_query($conn,"CREATE TABLE `users` (
  `user_num` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_pass` varchar(255) NOT NULL,
  `is_logged_in` tinyint(1) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(50) NOT NULL,
  `modified_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `temp_pass` varchar(255) NOT NULL,
  `changed` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");


// insert into users table
$query27=mysqli_query($conn,"INSERT INTO `users` (`user_num`, `user_id`, `user_pass`, `is_logged_in`, `created_by`, `created_date`, `modified_by`, `modified_date`, `temp_pass`, `changed`) VALUES
(257, 276, 'Nepal@123', 0, '', '2019-07-29 06:02:13', '', '0000-00-00 00:00:00', '', 0)
");

// create user_roles tables
$query26=mysqli_query($conn,"CREATE TABLE `user_roles` (
  `role_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_by` varchar(50) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `modified_by` varchar(50) DEFAULT NULL,
  `modified_date` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

// insert data into user_roles
$query27=mysqli_query($conn,"INSERT INTO `user_roles` (`role_id`, `user_id`, `created_by`, `created_date`, `modified_by`, `modified_date`) VALUES
(1, 257, '', '2019-08-02 04:56:00', NULL, '2019-08-02 04:56:00')
");

/*----------ALTER STATEMENTS-------*/
$query28=mysqli_query($conn,"ALTER TABLE `addresses`
  ADD PRIMARY KEY (`address_id`)
");

$query29=mysqli_query($conn,"ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`)
");

$query30=mysqli_query($conn,"ALTER TABLE `departments`
  ADD PRIMARY KEY (`id`)
");

$query31=mysqli_query($conn,"ALTER TABLE `email_notifications`
  ADD PRIMARY KEY (`id`)
");

$query32=mysqli_query($conn,"ALTER TABLE `employees`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `departmentId` (`department_id`),
  ADD KEY `package_id` (`package_id`)
");

$query33=mysqli_query($conn,"ALTER TABLE `employee_addresses`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `primary_addressId` (`primary_addressId`),
  ADD KEY `secondary_addressId` (`secondary_addressId`)
");

$query34=mysqli_query($conn,"ALTER TABLE `employee_approvers`
  ADD PRIMARY KEY (`ea_id`),
  ADD KEY `approver_id` (`approver_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `recommendar_id` (`recommender_id`)
");

$query35=mysqli_query($conn,"ALTER TABLE `employee_contacts`
  ADD PRIMARY KEY (`emp_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `contact_id` (`contact_id`)
");


$query36=mysqli_query($conn,"ALTER TABLE `employee_documents`
  ADD PRIMARY KEY (`doc_id`),
  ADD KEY `emp_id` (`emp_id`)
");

$query37=mysqli_query($conn,"ALTER TABLE `employee_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `approver_id` (`approver_id`),
  ADD KEY `leave_id` (`leave_id`),
  ADD KEY `package_id` (`package_id`),
  ADD KEY `recommender_id` (`recommender_id`)
");

$query38=mysqli_query($conn,"ALTER TABLE `employee_leave_balance`
  ADD PRIMARY KEY (`emp_id`,`leave_id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `leave_id` (`leave_id`)
");

$query39=mysqli_query($conn,"ALTER TABLE `employee_work_experience`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`)
");

$query40=mysqli_query($conn,"ALTER TABLE `leaves`
  ADD PRIMARY KEY (`leave_id`)
");

$query41=mysqli_query($conn,"ALTER TABLE `leave_packages`
  ADD PRIMARY KEY (`leave_id`,`package_id`),
  ADD KEY `package_id` (`package_id`)
");

$query42=mysqli_query($conn,"ALTER TABLE `managers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`)
");

$query43=mysqli_query($conn,"AALTER TABLE `modules`
  ADD PRIMARY KEY (`module_id`)
");


$query44=mysqli_query($conn,"ALTER TABLE `packages`
  ADD PRIMARY KEY (`package_id`)
");


$query45=mysqli_query($conn,"ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permission_id`)
");


$query46=mysqli_query($conn,"ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`)
");


$query47=mysqli_query($conn,"ALTER TABLE `role_permission_modules`
  ADD PRIMARY KEY (`module_id`,`permission_id`,`role_id`),
  ADD KEY `permissionId` (`permission_id`),
  ADD KEY `roleId` (`role_id`)
");

$query48=mysqli_query($conn,"ALTER TABLE `substitute_balance`
  ADD PRIMARY KEY (`emp_id`)
");


$query49=mysqli_query($conn,"ALTER TABLE `substitute_leaves`
  ADD PRIMARY KEY (`id`),
  ADD KEY `emp_id` (`emp_id`),
  ADD KEY `recommender_id` (`recommender_id`),
  ADD KEY `emp_id_2` (`emp_id`)
");


$query50=mysqli_query($conn,"ALTER TABLE `users`
  ADD PRIMARY KEY (`user_num`),
  ADD KEY `user_id` (`user_id`)
");


$query51=mysqli_query($conn,"ALTER TABLE `user_roles`
  ADD PRIMARY KEY (`role_id`,`user_id`),
  ADD KEY `user_id` (`user_id`)
");

$query52=mysqli_query($conn,"ALTER TABLE `addresses`
  MODIFY `address_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6
");


$query53=mysqli_query($conn,"ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT
");


$query54=mysqli_query($conn,"ALTER TABLE `departments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7
");


$query55=mysqli_query($conn,"ALTER TABLE `email_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT
");


$query56=mysqli_query($conn,"ALTER TABLE `employees`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318
");


$query57=mysqli_query($conn,"ALTER TABLE `employee_approvers`
  MODIFY `ea_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5
");


$query58=mysqli_query($conn,"ALTER TABLE `employee_documents`
  MODIFY `doc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15
");

$query59=mysqli_query($conn,"ALTER TABLE `employee_leaves`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=248
");


$query60=mysqli_query($conn,"ALTER TABLE `employee_work_experience`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3
");

$query61=mysqli_query($conn,"ALTER TABLE `leaves`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45
");


$query62=mysqli_query($conn,"ALTER TABLE `modules`
  MODIFY `module_id` int(11) NOT NULL AUTO_INCREMENT
");


$query63=mysqli_query($conn,"ALTER TABLE `packages`
  MODIFY `package_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47
");


$query64=mysqli_query($conn,"ALTER TABLE `substitute_balance`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=318
");



$query65=mysqli_query($conn,"ALTER TABLE `users`
  MODIFY `user_num` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=299
");


$query66=mysqli_query($conn,"ALTER TABLE `employees`
  ADD CONSTRAINT `employees_ibfk_1` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  ADD CONSTRAINT `employees_ibfk_2` FOREIGN KEY (`package_id`) REFERENCES `packages` (`package_id`) ON DELETE SET NULL ON UPDATE SET NULL
");



$query67=mysqli_query($conn,"ALTER TABLE `employee_addresses`
  ADD CONSTRAINT `employee_addresses_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_addresses_ibfk_2` FOREIGN KEY (`primary_addressId`) REFERENCES `addresses` (`address_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `employee_addresses_ibfk_3` FOREIGN KEY (`secondary_addressId`) REFERENCES `addresses` (`address_id`) ON DELETE SET NULL ON UPDATE SET NULL
");


$query68=mysqli_query($conn,"ALTER TABLE `employee_approvers`
  ADD CONSTRAINT `employee_approvers_ibfk_1` FOREIGN KEY (`approver_id`) REFERENCES `employees` (`emp_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `employee_approvers_ibfk_2` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_approvers_ibfk_3` FOREIGN KEY (`recommender_id`) REFERENCES `employees` (`emp_id`) ON DELETE SET NULL ON UPDATE SET NULL
");


$query69=mysqli_query($conn,"ALTER TABLE `employee_documents`
  ADD CONSTRAINT `employee_documents_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE
");


$query70=mysqli_query($conn,"ALTER TABLE `employee_leaves`
  ADD CONSTRAINT `employee_leaves_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `employee_leaves_ibfk_2` FOREIGN KEY (`approver_id`) REFERENCES `employees` (`emp_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `employee_leaves_ibfk_4` FOREIGN KEY (`package_id`) REFERENCES `employees` (`package_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `employee_leaves_ibfk_5` FOREIGN KEY (`recommender_id`) REFERENCES `employees` (`emp_id`) ON DELETE SET NULL ON UPDATE SET NULL,
  ADD CONSTRAINT `employee_leaves_ibfk_6` FOREIGN KEY (`leave_id`) REFERENCES `leaves` (`leave_id`) ON DELETE CASCADE ON UPDATE CASCADE
");


$query71=mysqli_query($conn,"ALTER TABLE `employee_work_experience`
  ADD CONSTRAINT `employee_work_experience_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE
");



$query72=mysqli_query($conn,"ALTER TABLE `managers`
  ADD CONSTRAINT `managers_ibfk_1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`) ON DELETE CASCADE ON UPDATE CASCADE
");

$query73=mysqli_query($conn,"ALTER TABLE `substitute_leaves`
  ADD CONSTRAINT `fk_sl_employees_ei1` FOREIGN KEY (`emp_id`) REFERENCES `employees` (`emp_id`),
  ADD CONSTRAINT `fk_sl_employees_ei2` FOREIGN KEY (`recommender_id`) REFERENCES `employees` (`emp_id`)
");


// table for mail groups added
$query74=mysqli_query($conn,"CREATE TABLE `mail_groups` (
  `id` int(11) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `mail_group` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1
");

$query75=mysqli_query($conn,"ALTER TABLE `mail_groups`
  ADD PRIMARY KEY (`id`)
");

$query76=mysqli_query($conn,"ALTER TABLE `mail_groups`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT
");

    echo "Database created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

$conn->close();
?>