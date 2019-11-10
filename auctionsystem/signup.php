<?php 
include("config.php");
include('class/userClass.php');
$userClass = new userClass();

$errorMsgReg='';

if (!empty($_POST['signupSubmit'])) 
{

	$username=$_POST['usernameReg'];
	$email=$_POST['emailReg'];
	$password=$_POST['passwordReg'];
    $name=$_POST['nameReg'];
	$username_check = preg_match('~^[A-Za-z0-9_]{3,20}$~i', $username);
	$email_check = preg_match('~^[a-zA-Z0-9._-]+@[a-zA-Z0-9._-]+\.([a-zA-Z]{2,4})$~i', $email);
	$password_check = preg_match('~^[A-Za-z0-9!@#$%^&*()_]{6,20}$~i', $password);

	if($username_check && $email_check && $password_check && strlen(trim($name))>0) 
	{
    $uid=$userClass->userRegistration($username,$password,$email,$name);
    if($uid)
    {
    	$url=BASE_URL.'home.php';
    	header("Location: $url");
    }
    else
    {
      $errorMsgReg="Username or Email already exits.";
    }
    
	}
}
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">
<title>Auction | Signup</title>
</head>
<style>
	#container{width: 700px}
	#login,#signup{width: 300px; border: 1px solid #d6d7da; padding: 0px 15px 15px 15px; border-radius: 5px;font-family: arial; line-height: 16px;color: #333333; font-size: 14px; background: #ffffff;rgba(200,200,200,0.7) 0 4px 10px -1px}
	h3{color:#365D98}
	form label{font-weight: bold;}
	form label, form input{display: block;margin-bottom: 5px;width: 90%}
	form input{ border: solid 1px #666666;padding: 10px;border: solid 1px #BDC7D8; margin-bottom: 20px}
	.button {
		background-color: #5fcf80 !important;
		border-color: #3ac162 !important;
		font-weight: bold;
		padding: 12px 15px;
		max-width: 100px;
		color: #ffffff;
	}
	.errorMsg{color: #cc0000;margin-bottom: 10px}
</style>

<body>
	<h1><center>Welcome to the auction site!<center></h1>
	<div id="container">
		<div id="signup">
			<h3>Registration</h3>
			<form method="post" action="" name="signup">
				<label>Name</label>
				<input type="text" name="nameReg" autocomplete="off" />
				<label>Email</label>
				<input type="text" name="emailReg" autocomplete="off" />
				<label>Username</label>
				<input type="text" name="usernameReg" autocomplete="off" />

				<label>Password</label>
				<input type="password" name="passwordReg" autocomplete="off"/>
				<div class="errorMsg"><?php echo $errorMsgReg; ?></div>
				<p>Already have an account ? <a href="login.php">Login</a></p>
				<input type="submit" class="button" name="signupSubmit" value="Signup">
			</form>
		</div>
	</div>
</body>
</html>
