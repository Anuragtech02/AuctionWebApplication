 <?php
include('config.php');
//include('class/userClass.php');
include('session.php');
$userDetails=$userClass->userDetails($session_uid);
//print_r($userDetails);


$errorMsgAdd='';
$displayMsg='';

if (!empty($_POST['itemAdd'])) 
{

	$itemName=$_POST['itemName'];
	$item_min_bid=$_POST['minBid'];
	$uid=$userDetails->uid;
    $item_id=$userClass->addItem($uid,$itemName,$item_min_bid);

    if($item_id)
    {
    	$url=BASE_URL.'home.php';
    	header("Location: $url");
    }
    else
    {
      $errorMsgAdd="Something went wrong !.";
    }
    
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Auction | Add</title>
<link rel="stylesheet" href="style.css" type="text/css">
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
<h1>Welcome <?php echo $userDetails->name; ?></h1>
<div id="container">
<div id="add">
	<form method="post" action="" name="additem">
		<br>
		<label>Item Name</label>
		<input type="text" name="itemName" autocomplete="off" />
		<label>Enter minimum Bid</label>
		<input type="text" name="minBid" autocomplete="off" />
		<p id="add_p"><a href="home.php">BACK</p>
		<div class="errorMsg"><?php echo $errorMsgAdd; ?></div>
		<input type="submit" class="button" name="itemAdd" value="Add">
	</form>
</div>

<b><h4 id="home_h4"><a href="<?php echo BASE_URL; ?>logout.php">Logout</a></h4></b>

</form>
</div>
</body>
</html>