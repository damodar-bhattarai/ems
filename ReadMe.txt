---------------Follow the instructions to use the system-----------------------
----
--
/********Login Credentials for Admin********/
				User id: 276
				Password: Nepal@123
/*****************************************/


/***** HOW TO OPEN XAMPP AND COPY FOLDER**********/

1. Make sure to have Xampp installed on you PC. If not, first install it.

2. Copy the 'ems' folder in the 'C:\xampp\htdocs' folder.

3. First open the Xampp Control Panel and start Apache and MySQL.



/******** SETUP DATABASE AND START USING EMS ************/

1. Open the browser and type 'http://localhost/phpmyadmin/'.

2. Check if there is "ems" database already created.
 
3. If the "ems" database does not exists, go to step 5.
	Or else,
	Make sure to drop the database "ems" if it already exits.

4. To drop the database, click on "ems", go to 'operations' tab and click "Drop the database (DROP)" option.


5. Go to the browser and open '[url]/sql'. (example: localhost/ems/sql)
--- This will create database and hash the admin's password in the database

6. Open the 'ems' folder in the text editor (example: sublime).
	 Then goto the main folder 'ems'-> then to 'application' folder-> 'config' folder -> then open 'database.php'

7. In the file 'database.php', go to  line 81, or where you can see 'database' => ''.

8. There, change 'database' => '' to 'database' => 'ems' .

9. The setup is complete.

10. Open the login page and login with the provided user id and password in the beginning.
	The password needs to be changed to be able to use the EMS.





---------------Follow the instructions to use the email-----------------------
----
--
NOTE:
These steps are to followed twice for files(EMS.xml and Send Leave Email.xml) in 'ems/assets/mail' folder.


1. Go to Task Scheduler on windows

2. On the right side under "Actions" tab, click on import Task.
	Select the one xml file (example: EMS.xml) and click on OK.

#How to Start Task
1. Right click on task and select run.

2. Task will be started automatically everyday at 10 AM and repeats every 15 minutes in a day.


# Details of each file
1. EMS.xml
-- It sends all the pending emails automatically every 15 minutes once the task is started.
-- Each time, 10 emails are sent.


2. Send Leave Email.xml
-- It sends all the pending emails for employees on leave to the specified emails by admin, automatically at 10 AM everyday.


