<?php 
include("config.php");
include('class/userClass.php');
$userClass = new userClass();
$userDetails=$userClass->userDetails($session_uid);
?>
<!DOCTYPE html>
<html>
<head>
<title>Auction | Home</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<style>
#sidebar{
    h3:color='black';
    height:130px;
    width: 222px; 
    border: 1px solid #d6d7da;
	position: absolute;   
	right: 75.6%;
   	top: 20%; 
    transform: translate(-50%, -50%);
	padding: 0px 15px 15px 15px; border-radius: 5px;font-family: arial; line-height: 16px;color: #333333; font-size: 14px; background: #ffffff;rgba(200,200,200,0.7) 0 4px 10px -1px
}
#rightSidebar{
    h3:color='black';
    height:130px;
    width: 900px; 
    border: 1px solid #d6d7da;
	position: absolute;   
	left: 60%;
   	top: 20%; 
    transform: translate(-50%, -50%);
	padding: 0px 15px 15px 15px; border-radius: 5px;font-family: arial; line-height: 16px;color: #333333; font-size: 14px; background: #ffffff;rgba(200,200,200,0.7) 0 4px 10px -1px
}
</style>
<body>


<div id='sidebar'>
    <h3>Welcome <?php echo $userDetails->name; ?></h3>
    <h3><a href="add.php">• Add item for Bidding</a></h3>
    <h3><a href="remove.php">• Remove item from Bidding</a></h3>
    <h3><a href="received.php">• Bids/Offers Received</a></h3>
</div>
<div id='rightSidebar'>
<center><h2>Items availbale for bidding</h2></center>
	<br>
	<div id="otherTable">
	<center><table>
		<tr>
        <th>UID</th>
        <th>Item Name</th>
		<th>Category</th>
        <th>Min. Bid</th>
		</tr>
		<?php
            $conn = mysqli_connect("localhost", "root", "", "auction");
            $uid=$userDetails->uid;
			// Check connection
			if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
			}
            $sql = "SELECT uid, item_name, category, item_min_bid FROM items where uid!=$uid";
            $result = $conn->query($sql);
            /*if ($result->num_rows < 1){
                echo "0 results";
            }*/
			if ($result->num_rows > 0) {
				// output data of each row
				while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["uid"]. "</td><td>" . $row["item_name"] . "</td><td>"
                . $row["category"] ."</td><td>". $row["item_min_bid"] . "</td><td>";
            }
			echo "</table>";
			} else { echo "No items available!"; }
			$conn->close();
		?>
    </table></center>
</div>
</body>
</html>
