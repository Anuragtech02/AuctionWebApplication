 <?php
if(!empty($_SESSION['uid']))
{
$session_uid=$_SESSION['uid'];
include('class/userClass.php');
$userClass = new userClass();
}

if(empty($session_uid))
{
	print_r("You must login first to see this page !");
	$url=BASE_URL.'login.php';
	header("Location: $url");
}
?>