<?php
include('config.php');
include('session.php');
$userDetails=$userClass->userDetails($session_uid);


$errorMsgAdd='';
$displayMsg='';

if (!empty($_POST['addBid'])) 
{

    $itemName=$_POST['itemName'];
    $your_bid=$_POST['your_bid'];
	$uid=$userDetails->uid;
    $add_bid=$userClass->bid($uid, $itemName, $your_bid);

    if($add_bid)
    {
        $url=BASE_URL.'home.php';
        echo "Success !";
    	//header("Location: $url");
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
<title>Auction | Bid</title>
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
	<center><h2>Items availbale for bidding</h2></center>
	<br>
	<div id="otherTable">
	<table>
		<tr>
        <th>UID</th>
        <th>Item Name</th>
        <th>Min. Bid</th>
		</tr>
		<?php
            $conn = mysqli_connect("localhost", "root", "", "auction");
            $uid=$userDetails->uid;
			// Check connection
			if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
			}
            $sql = "SELECT uid, item_name, item_min_bid FROM items";
            $result = $conn->query($sql);
            if ($result->num_rows < 1){
                echo "0 results";
            }
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["uid"]. "</td><td>" . $row["item_name"] . "</td><td>"
                . $row["item_min_bid"] . "</td><td>";
            }
			echo "</table>";
			} else { echo "0 results"; }
			$conn->close();
		?>
    </table>
    <br>
    <h2><center>Your Bids</center></h2>
    <table>
        <tr>
        <th>Item Name</th>
        <th>Your Bid</th>
		</tr>
		<?php
            $conn = mysqli_connect("localhost", "root", "", "auction");
            // Check connection
            $uid=$userDetails->uid;
			if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
            }
            $sql = "SELECT item_name,your_bid FROM items WHERE bid_id=$uid";
			$result = $conn->query($sql);
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["item_name"]. "</td><td>". $row["your_bid"]. "</td><td>";
			}
			echo "</table>";
			} else { echo "0 results"; }
			$conn->close();
		?>
    </table>
	</div>		
	<form method="post" action="" name="bidItem">
		<br>
		<label>Enter name of the item to bid</label>
        <input type="text" name="itemName" autocomplete="off" />
        <label>Enter amount</label>
		<input type="number" name="your_bid" autocomplete="off" />
		<div class="errorMsg"><?php echo $errorMsgAdd; ?></div>
		<input type="submit" class="button" name="addBid" value="Add Bid">
		<p id="other"><a href="home.php">BACK</a></p>
	</form>
</div>

<b><h4 id="home_h4"><a href="<?php echo BASE_URL; ?>logout.php">Logout</a></h4></b>

</form>
</div>
</body>
</html>