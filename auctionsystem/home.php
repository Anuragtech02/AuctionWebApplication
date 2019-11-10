 <?php
include('config.php');
include('session.php');
$userDetails=$userClass->userDetails($session_uid);
//print_r($userDetails);
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css">
<title>Auction | Home</title>
</head>
<body>
<h1>Welcome <?php echo $userDetails->name; ?></h1>

<div id="home">
	<h3><center>What would you like to do ?<center></h3>
	<p>1.<a href="add.php" style="color:green"> Add item for auction.</a></p>
	<p>2.<a href="remove.php" style="color:green"> Remove item from auction.</a></p>
	<p>3.<a href="other.php" style="color:green"> See other items for bidding.</a></p>
</div>

<b><h4 id="home_h4"><a href="<?php echo BASE_URL; ?>logout.php">Logout</a></h4></b>

</form>
</body>
</html>
