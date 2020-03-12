<?php
    class Login_controller extends CI_Controller 
    {

        public function generalPage() 
        {
                              
            if (isset($_SESSION['loggedin'])&& $_SESSION['loggedin']==true) {
                if($_SESSION['type']=='admin')
                redirect('admin');
                else
                    redirect('employee');
            }
            else{ $this->load->view('login/login'); }
            
        }

         //test login
        public function checkLogin()
        {
            //checks the forms for data required
            $this->form_validation->set_rules('user_id', 'Login Id', 'required');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == FALSE)
                {
                    $this->load->view('login/login');
                }
             else
             {
                // check user id and password if the form is filled
                $result=$this->Validate_login_form->validate_id_password();

                //to redierect to the right user
                if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){


                    
                    if( $_SESSION['type']=='employee')
                        redirect('employee');
                    else
                        redirect('admin');
                }
                else{
                    $_SESSION['error_msg']=$result;
                     $this->load->view('login/login');
                }
             }
        }
        // to change password
        public function changePassword(){

           if ($this->input->post('submit') != NULL) {
                $result = $this->input->post();

               $this->db->where('user_id',$_SESSION['user_id']);
               $users=$this->db->get('users');
               $user=$users->row_array();

                $data['emp_id']=$_SESSION['user_id'];
                $data['cp']=trim($result['cp']);
                $data['np']=trim($result['np']);
                $data['rnp']=trim($result['rnp']);
                $error=false;

                    if(empty( $data['cp'])||empty($data['np'])||empty($data['rnp'])){
                    $data['error']="Fill All Fields";
                     $error=true;
                      $this->load->view('login/changePassword',$data);
                      return;
                    }

                    if(password_verify($user['user_pass'],$data['cp'])){
                     $data['error']="Invalid Current Password";
                     $error=true;
                      $this->load->view('login/changePassword',$data);
                      return;
                    }
                    if($data['np']!=$data['rnp']){
                    $data['error']="Password Do Not Match";
                    $error=true;
                     $this->load->view('login/changePassword',$data);
                     return;
                    }
                   if(preg_match('/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/', $data['np'])){}
                      else{

                      $data['error']="Password must be of minimum 8 characters and contain 1 uppercase, 1 symbol, 1 number, 1 lowercase";
                     $error=true;
                     $this->load->view('login/changePassword',$data);
                     return;
                    }


                    if($error==false){
                        $this->db->where('user_id',$_SESSION['user_id']);
                        $udata=[
                            'user_pass'=>password_hash($data['np'], PASSWORD_DEFAULT),
                            'modified_date'=>strtotime(Date('Y-m-d')),
                            'is_logged_in'=>'0',
                            'changed'=>'1'
                        ];
                        $this->db->update('users',$udata);
                        $message='Your new password is: '.$data['np'].'<br> Please Delete this mail if you have read the mail.';
                        $email=$this->Admin_model->getEmail($_SESSION['user_id']);
                        $this->Admin_model->sendEmail('Password Changed',$message,$email);

                        $_SESSION['success_msg']="Password Changed. Login With New Password";
                        session_destroy();
                        $this->load->view('login/login');
                    }
            }
            else
            $this->load->view('login/changePassword');
        }
//end of change password

        //start of forgot password
function forgot(){
    if ($this->input->post('request') != NULL) {
        $result = $this->input->post();
        if(!$this->numberonly($result['emp_id'])){
            $data['error']="Enter numberic ID only";
             $error=true;
             $this->load->view('login/forgot',$data);
             return;
        }
        else{
                $this->db->where('user_id',$result['emp_id']);
                $chk=$this->db->get('users');
                $check=$chk->row_array();
                if(empty($check)){
                    $data['error']="User Not Found";
                     $error=true;
                     $this->load->view('login/forgot',$data);
                     return;
                }
                else{
                  $this->db->where('user_id',$result['emp_id']);
                 $temp_pass=rand(1000000000,100000000000);
                  $pdata=['temp_pass'=>$temp_pass];
                  $this->db->update('users',$pdata);
                  $message = "We have received a password reset request. If you haven't requested then you can ignore this mail. <br> If you want to reset your password visit the link below.";
                  $message .= "<a href=\"".site_url()."resetPassword/".$result['emp_id']."/".$temp_pass."\"> Reset Password Here </a>";
                
                  $email=$this->Admin_model->getEmail($result['emp_id']);
                      $this->Admin_model->sendEmail('Password Reset Request',$message,$email);

                      $data['success']="Password Reset Link has been sent to your email";
                     $this->load->view('login/forgot',$data);
                     return;
            }

         
      }
  }
   $this->load->view('login/forgot');
}


// checking input types number
public function numberonly($text)
{
  if (preg_match('/^[0-9]+$/',$text ))
    return true;
  else
    return false;
}


// resetting passwrod
public function resetPassword($id,$password){
  $_SESSION['resetID']=$id;
  $_SESSION['resetPW']=$password;

  $this->db->where('user_id',$id);
  $getAll=$this->db->get('users');
  $user=$getAll->row_array();

  if(empty($user)){
    $data['error']="User Not Found";
   $error=true;
   $this->load->view('login/resetPassword',$data);
   return;
  }

  if($user['temp_pass']!=$password){
    $data['error']="Incorrect Password Reset Link";
   $error=true;
   $this->load->view('login/resetPassword',$data);
   return;
  }


  $data['id']=$_SESSION['resetID'];

  $this->load->view('login/resetPassword',$data);

}

// reset new password
function resetNewPassword(){
   if ($this->input->post('resetPw') != NULL) {

               $gotolocation='login/resetPassword';


                $result = $this->input->post();

               $this->db->where('user_id',$_SESSION['resetID']);
               $users=$this->db->get('users');
               $user=$users->row_array();

                $data['emp_id']=$_SESSION['resetID'];
                $data['np']=trim($result['np']);
                $data['rnp']=trim($result['rnp']);
                $error=false;

                    if(empty($data['np'])||empty($data['rnp'])){
                    $data['error']="Fill All Fields";
                     $error=true;
                      $this->load->view($gotolocation,$data);
                      return;
                    }

                   
                    if($data['np']!=$data['rnp']){
                    $data['error']="Password Do Not Match";
                    $error=true;
                     $this->load->view($gotolocation,$data);
                     return;
                    }
                   if(preg_match('/^(?=\P{Ll}*\p{Ll})(?=\P{Lu}*\p{Lu})(?=\P{N}*\p{N})(?=[\p{L}\p{N}]*[^\p{L}\p{N}])[\s\S]{8,}$/', $data['np'])){}
                      else{

                      $data['error']="Password must be of minimum 8 characters and contain 1 uppercase, 1 symbol, 1 number, 1 lowercase";
                     $error=true;
                     $this->load->view($gotolocation,$data);
                     return;
                    }


                    if($error==false){
                        $this->db->where('user_id',$data['emp_id']);
                        $udata=[
                            'user_pass'=>password_hash($data['np'], PASSWORD_DEFAULT),
                            'modified_date'=>strtotime(Date('Y-m-d')),
                            'is_logged_in'=>'0',
                            'temp_pass'=>''
                        ];
                        $this->db->update('users',$udata);
                        $message='Your new password is: '.$data['np'].'<br> Please Delete this mail if you have read the mail.';
                        $email=$this->Admin_model->getEmail($_SESSION['resetID']);
                        $this->Admin_model->sendEmail('Password Changed',$message,$email);

                        $_SESSION['success_msg']="Password Changed. Login With New Password";
                        session_destroy();
                        $this->load->view('login/login');
                    }
            }


}
















    }
?>