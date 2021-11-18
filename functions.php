<?php 
session_start();

include 'DB/dbconfig.php';

// variable declaration
$username = "";
$email    = "";
$errors   = array(); 


// call the register() function if register_btn is clicked
if (isset($_POST['register_btn'])) {
	register();
}



/* REGISTER USER

function register(){
	// call these variables with the global keyword to make them available in function
	global $db, $errors, $username, $email;

	// receive all input values from the form. 
	$username    =  $_POST['username'];
	$email       =  $_POST['email'];
	$password_1  =  $_POST['password_1'];
	$password_2  =  $_POST['password_2'];

	// form validation: ensure that the form is correctly filled
	if (empty($username)) { 
		array_push($errors, "Username is required"); 
	}
	if (empty($email)) { 
		array_push($errors, "Email is required"); 
	}
	if (empty($password_1)) { 
		array_push($errors, "Password is required"); 
	}
	if ($password_1 != $password_2) {
		array_push($errors, "The two passwords do not match");
	}

	// register user if there are no errors in the form
	if (count($errors) == 0) {
		$password = $password_1;

		if (isset($_POST['user_type'])) {
			$user_type = $_POST['user_type'];
			$query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', '$user_type', '$password')";
			mysqli_query($db, $query);
			$_SESSION['success']  = "New user successfully created!!";
			header('location: home.php');
		}else{
			$query = "INSERT INTO users (username, email, user_type, password) 
					  VALUES('$username', '$email', 'user', '$password')";
			mysqli_query($db, $query);

			// get id of the created user
			$logged_in_user_id = mysqli_insert_id($db);

			$_SESSION['user'] = getUserById($logged_in_user_id); // put logged in user in session
			$_SESSION['success']  = "You are now logged in";
			header('location: index.php');				
		}
	}
}

*/



// RETURN USER ARRAY FROM THEIR ID
function getUserById($id){
	global $db;
	$query = "SELECT * FROM users WHERE id=" . $id;
	$result = mysqli_query($db, $query);
	$user = mysqli_fetch_assoc($result);
	return $user;
}


// ERROR DISPLAY

function display_error() {
	global $errors;

	if (count($errors) > 0){
		echo '<div class="errormsg">';
        echo '<div class="error_notification">';
			foreach ($errors as $error){
				echo $error .'<br>';
			}
		echo '</div>';
        echo '</div>';
	}
}	


//RESTRICT DIRECT LEVEL ACCESS BY URL. THIS FUNCTION CAN BE CALLED WITH DIFFERENT PAGES TO RESTRICT


// LOG USER OUT IF LOGOUT BUTTON CLICKED
if (isset($_GET['logout'])) {
	session_destroy();
	unset($_SESSION['user']);
	header("location:index.php");
}





// CALL THE LOGIN() FUNCTION IF login_btn IS CLICKED
if (isset($_POST['login_btn'])) {
	login();
}

// To access admin Pages validation might be for all admin pages


function isLoggedIn()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}


// TO ACCESS SUPER_USER PAGES VALIDATION MIGHT (HOME) BE FOR ALL SUPER_USER PAGES

function isSuper_user()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['role_code'] == 'VP'  || isset($_SESSION['user']) && $_SESSION['user']['role_code'] == 'AM' || isset($_SESSION['user']) && $_SESSION['user']['role_code'] == 'admin' || isset($_SESSION['user']) && $_SESSION['user']['role_code'] == 'HREXEC' || isset($_SESSION['user']) && $_SESSION['user']['role_code'] == 'FINH' || isset($_SESSION['user']) && $_SESSION['user']['role_code'] == 'CMNGR' || isset($_SESSION['user']) && $_SESSION['user']['role_code'] == 'PR') {
		return true;
	}else{
		return false;
	}
}



function isHr_admin()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['role_code'] == 'BLADM') {
		return true;
	}else{
		return false;
	}
}



function isIt_dept()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['role_code'] == 'ITL' || $_SESSION['user']['role_code'] == 'ITT') {
		return true;
	}else{
		return false;
	}
}

function isNr_user()
{
	if (isset($_SESSION['user'])) {
		return true;
	}else{
		return false;
	}
}


function isNr_user_orion()
{
	if (isset($_SESSION['user']) && $_SESSION['user']['role_code'] == 'SRACC') {
		return true;
	}else{
		return false;
	}
}



      

// LOGIN USER
function login(){
	global $db, $username, $errors;

	// grap form values
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	// make sure form is filled properly
	if (empty($username)) {
		array_push($errors, "Username is required");
	}
	if (empty($password)) {
		array_push($errors, "Password is required");
	}

	// attempt login if no errors on form
	if (count($errors) == 0) {

		$query = "SELECT * FROM users WHERE user_id='$username' AND password='$password' ";
        $params = array();
        $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
        $results = sqlsrv_query($db, $query, $params, $options );
                
		if (sqlsrv_num_rows($results) == 1) { // user found
			// check if user is admin or user
			$logged_in_user = sqlsrv_fetch_array($results);
            
            $query_fr_bs_dt = "SELECT * FROM hr_user_profile WHERE (emp_code='$username') AND (emp_status NOT IN ('Terminated', 'Resigned', 'Absconding'))";
             $result_fr_bs_dt = sqlsrv_query($db, $query_fr_bs_dt);
            $logged_in_user_bs_dt = sqlsrv_fetch_array($result_fr_bs_dt);
          
            if(!empty($logged_in_user_bs_dt)){
                
			if ($logged_in_user['role_code'] == 'VP' || $logged_in_user['role_code'] ==  'AM' || $logged_in_user['role_code'] ==  'admin' || $logged_in_user['role_code'] ==  'HREXEC' || $logged_in_user['role_code'] ==  'FINH' || $logged_in_user['role_code'] ==  'CMNGR'|| $logged_in_user['role_code'] ==  'PR') {
				
                $_SESSION['user'] = $logged_in_user; // adding all data to session variable 'user'
                  $_SESSION['user_bs_dt'] = $logged_in_user_bs_dt;
        
             // for hr_user_document emp id repeats morethan once       
				header('location: users/super_users/home.php');		  
            }
            
            	elseif ($logged_in_user['role_code'] ==  'BLADM') {
				
                $_SESSION['user'] = $logged_in_user; // adding all data to session variable 'user'
                $_SESSION['user_bs_dt'] = $logged_in_user_bs_dt;
        
             // for hr_user_document emp id repeats morethan once       
				header('location: users/hr_admin/home.php');		  
            }
            
            
            	elseif ($logged_in_user['role_code'] == 'ITL' || $logged_in_user['role_code'] == 'ITT' ) {
				
                $_SESSION['user'] = $logged_in_user; // adding all data to session variable 'user'
                $_SESSION['user_bs_dt'] = $logged_in_user_bs_dt;
        
             // for hr_user_document emp id repeats morethan once       
				header('location: users/it_dept/home.php');		  
            }
            
             else{ 
				
                $_SESSION['user'] = $logged_in_user; // adding all data to session variable 'user'
                $_SESSION['user_bs_dt'] = $logged_in_user_bs_dt;
        
             // for hr_user_document emp id repeats morethan once       
				header('location: users/nr_users/home.php');		  
            }
              
                
		}else{
			array_push($errors, "User is Not Authorized for Login");
		}
        }else {
			array_push($errors, "Wrong username/password");
	}
}
}

if (isset($_POST['reset_btn'])) {
	reset_password ();
}


function reset_password(){
	
	global $db, $username, $errors;

	// grap form values
	$user_code = trim($_POST['userid']);
	$user_mailid = trim($_POST['email']);
	
	$query1 = "SELECT * FROM USERS WHERE user_id='$user_code'";
    $results = sqlsrv_query($db, $query1);        
    $user_det = sqlsrv_fetch_array($results);        
    $_SESSION['user_det'] = $user_det;				
	$username = $_SESSION['user_det']['username'];
	
	$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
	 $temp_password = implode($pass); // Generate new strong password
	 
	 
	 //$query = "update users set password='$temp_password' where user_id='$user_code'";	 
	 $query = "select * from users";	 
	 $getqry = sqlsrv_query($db, $query)or die( print_r( sqlsrv_errors(), true));
     
	 if($query){	
	 
			$_SESSION['report'] = "New password sent to your E-mail";	

				$to = "$user_mailid";					
				$subject = "HRMS password reset";
					
				$message = "<html>
				<head>
				<title>HTML email</title>
				<style>
				td{
				text-align:left;
				}
				</style>
				</head>
				<body style='margin:0px;'>
				<div style='font-family: Helvetica, Arial, sans-serif;background:#fafafa;margin:0;padding:0'>
				
				<table class='m_-3122556097721131372bg-fw-blue' border='0' cellpadding='10' cellspacing='0' width='100%' style='background: #001554'>
				<tbody>
				<tr>
				<td align='center' class='m_-3122556097721131372logoContainer' style='padding:10px 0 10px;display:block; text-align:center;'> 
					<div align='center' style='padding:10px 0px;'>
                            <img src='http://mef.ae/crm-head.png' alt='CRM PORTAL' border='0' class='m_-3122556097721131372logo CToWUd' width='330' style='display:block;padding:12px 0;'>
					</div>
                    </td>
                </tr>
				</tbody>
				</table>
				
				<table class='m_-3122556097721131372bg-lightest-grey' border='0' cellpadding='10' cellspacing='0' width='100%' style='background-color:#fafafa'>
					<tr style='background-color:#fafafa'><td style='padding-bottom:12px;font-family: Helvetica, Arial, sans-serif;'>Dear " .htmlspecialchars($username). ",</td></tr>
					<tr style='background-color:#fafafa'><td style='padding-bottom:12px;font-family: Helvetica, Arial, sans-serif;'> Your New Password is: <b>".htmlspecialchars($temp_password). "</b></td></tr>
					<tr style='background-color:#fafafa'><td style='padding-bottom:12px;font-family: Helvetica, Arial, sans-serif;'> Note: Please change the password after first login. </td></tr>
				</table>
				
				
				<br>	
				<table>
				<tr>
				<td>
				<h2 style='color:#000;display:block;font-family: Helvetica, Arial, sans-serif;font-size:14px;font-weight:700;margin:0px 0 5px;text-transform:uppercase;'>For Further details: </h2>
				</td>
				<td>
				<a href='http://hrms.mef.com/hrms/' style='color:#0000EE;' target='_blank' style='font-family: Helvetica, Arial, sans-serif;'>HRMS Portal</a>
				</td>
				</table>
					
					<br>					
					<table bgcolor='' border='' cellpadding='0' cellspacing='' width='100%' style='background:#001554;'><tbody><tr>
					<td align='center' style='padding:0px 0 0px;text-align:center;'>
                        
                        <p class='m_-3122556097721131372footer' style='margin-bottom:1em;color:#dadada;font-family: Helvetica, Arial, sans-serif;text-align:center;font-size:12px;text-decoration:none;margin:20px 0 10px'>MIDDLE EAST FUJI LLC </p>
						<p class='m_-3122556097721131372footer' style='margin-bottom:1em;font-family: Helvetica, Arial, sans-serif;color:#dadada;text-align:center;font-size:12px;text-decoration:none;margin:10px 0'>P.O. Box 19227, Dubai, United Arab Emirates</p>
                        <p class='m_-3122556097721131372footer' style='margin-bottom:1em;font-family: Helvetica, Arial, sans-serif;color:#dadada;text-align:center;font-size:12px;text-decoration:none;margin:10px 0'>All Rights Reserved. © 2018 MEF</p>
                        
                    </td>
					</tr>
					</tbody>
					</table>
					</div>
					</body>
					</html>";

					// Always set content-type when sending HTML email
					$headers .= "MIME-Version: 1.0" . "\r\n";
					$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
					//$headers .= "Cc: hayashir@mef.ae, josephb@mef.ae, autors@mef.ae, info@mef.ae, tiag@mef.ae, $emailteam_lead \r\n";
					//$headers .= 'Bcc: it-dept@mef.ae';
					
					mail($to,$subject,$message,$headers);
				
	 }
	 else{
		 $_SESSION['report'] = "Try Again";
	 }
	                                                                                                                                                                                                                                                                                                                                                                                                                   
}

//MEF_Visitor_form function

if (isset($_POST['submit'])) {
    
add_record_details();

}

function add_record_details(){
   
    global $db,$errors; 
    
   
    if(isset($_POST['submit'])){
		
		$name = $_POST["name"];
        $email = $_POST["email"];
        $contact = $_POST["contact"];
	    $purposeofvisit=$_POST["purposeofvisit"];
        $contactperson = $_POST["contactperson"];

        $query = "INSERT INTO visitor_form (Name,Email,Contact,Purpose_of_visit,Contact_person) VALUES('$name','$email','$contact','$purposeofvisit','$contactperson') ";
     
        $result = sqlsrv_query($db, $query);
		
        echo "<script>alert('Record Added successfully!');</script>";
		
        }
      
      else{     
        echo "<script>alert('Record Not Added Successfully.');</script>";     
        }
           
} 













