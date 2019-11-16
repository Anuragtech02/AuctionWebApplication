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
<title>Auction | Offers</title>
</head>
<style>
    #container{width: 700px}
	#login,#received{width: 300px; border: 1px solid #d6d7da;
		position: absolute;   
    	left: 50%;
    	top: 50%; 
	    transform: translate(-50%, -50%);
		padding: 0px 15px 15px 15px; border-radius: 5px;font-family: arial; line-height: 16px;color: #333333; font-size: 14px; background: #ffffff;rgba(200,200,200,0.7) 0 4px 10px -1px}
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
    <div id="received">
        <center><h3>Bids Received </h3></center>
       <center> <table>
            <tr>
            <th>UID</th>
            <th>Item Name</th>
            <th>Category</th>
            <th>Price offered</th>
            </tr>
            <?php
                $conn = mysqli_connect("localhost", "root", "", "auction");
                $uid=$userDetails->uid;
                // Check connection
                if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
                }
                $sql = "SELECT uid, item_name, category, offer FROM bids WHERE for_uid=$uid";
                $result = $conn->query($sql);
                /*if ($result->num_rows < 1){
                    echo "0 results";
                }*/
                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                    echo "<tr><td>" . $row["uid"]. "</td><td>" . $row["item_name"] . "</td><td>"
                    . $row["category"] ."</td><td>". $row["offer"] . "</td><td>";
                }
                echo "</table>";
                } else { echo "No offers received yet :("; }
                $conn->close();
            ?>
        </table></center>

        <p id="other"><a href="home.php">BACK</a></p>

    </div>        
    
</div>

<b><h4 id="home_h4"><a href="<?php echo BASE_URL; ?>logout.php">Logout</a></h4></b>
</body>
</html>