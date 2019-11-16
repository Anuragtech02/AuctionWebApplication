<?php
class userClass
{
	 /* User Login */
     public function userLogin($usernameEmail,$password)
     {

          $db = getDB();
          $hash_password= hash('sha256', $password);
          $stmt = $db->prepare("SELECT uid FROM users WHERE  (username=:usernameEmail or email=:usernameEmail) AND  password=:hash_password");  
          $stmt->bindParam("usernameEmail", $usernameEmail,PDO::PARAM_STR) ;
          $stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
          $stmt->execute();
          $count=$stmt->rowCount();
          $data=$stmt->fetch(PDO::FETCH_OBJ);
          $db = null;
          if($count)
          {
                $_SESSION['uid']=$data->uid;
                return true;
          }
          else
          {
               return false;
          }    
     }

     /* User Registration */
     public function userRegistration($username,$password,$email,$name)
     {
          try{
			  $db = getDB();
			  $st = $db->prepare("SELECT uid FROM users WHERE username=:username OR email=:email");  
			  $st->bindParam("username", $username,PDO::PARAM_STR);
			  $st->bindParam("email", $email,PDO::PARAM_STR);
			  $st->execute();
			  $count=$st->rowCount();
          if($count<1)
          {
			  $stmt = $db->prepare("INSERT INTO users(username,password,email,name) VALUES (:username,:hash_password,:email,:name)");  
			  $stmt->bindParam("username", $username,PDO::PARAM_STR) ;
			  $hash_password= hash('sha256', $password);
			  $stmt->bindParam("hash_password", $hash_password,PDO::PARAM_STR) ;
			  $stmt->bindParam("email", $email,PDO::PARAM_STR) ;
			  $stmt->bindParam("name", $name,PDO::PARAM_STR) ;
			  $stmt->execute();
			  $uid=$db->lastInsertId();
			  $db = null;
			  $_SESSION['uid']=$uid;
			  return true;

          }
          else
          {
			  $db = null;
			  return false;
          }
          
         
          } 
          catch(PDOException $e) {
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
          }
     }
     
     /* User Details */
     public function userDetails($uid)
     {
        try{
          $db = getDB();
          $stmt = $db->prepare("SELECT email,username,name,uid FROM users WHERE uid=:uid");  
          $stmt->bindParam("uid", $uid,PDO::PARAM_INT);
          $stmt->execute();
          $data = $stmt->fetch(PDO::FETCH_OBJ);
          return $data;
         }
         catch(PDOException $e) {
          echo '{"error":{"text":'. $e->getMessage() .'}}'; 
          }

     }
	 /*Adds item to database*/
	 public function addItem($uid, $item_name, $category, $item_min_bid)
	 {
		try{
			$db = getDB();
			$stmt = $db->prepare("INSERT INTO items (uid,item_name,category,item_min_bid) values (:uid,:item_name,:category,:item_min_bid)");
			$stmt->bindParam("uid", $uid,PDO::PARAM_INT);
			$stmt->bindParam("item_name", $item_name,PDO::PARAM_STR);
			$stmt->bindParam("category", $category,PDO::PARAM_STR);
			$stmt->bindParam("item_min_bid", $item_min_bid, PDO::PARAM_INT);
			$stmt->execute();
			$item_id=$db->lastInsertId();
			$db=null;
			$_SESSION['uid']=$uid;
			return true;
		}	
		catch(PDOException $e){
			$db = null;
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		}
		 
	 }
	 
	 /*Removes item from db*/
	 public function removeItem($uid, $item_name)
	 {
		 
		 try{
			 $db=getDB();
			 $stmt=$db->prepare("DELETE FROM items WHERE uid=:uid and item_name=:item_name");
			 $stmt->bindParam("uid", $uid,PDO::PARAM_INT);
			 $stmt->bindParam("item_name", $item_name,PDO::PARAM_STR);
			 $stmt->execute();
			 $db=null;
			 $_SESSION['uid']=$uid;
			 return true;
		 }
		 catch(PDOException $e){
			 $db = null;
			 echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		 }
	 }

	 
	 public function bid($uid,$item_name, $your_bid)
	 {
		 try{
			 $db=getDB();
			 $stmt=$db->prepare("UPDATE items SET bid_id=:uid,your_bid=:your_bid WHERE item_name LIKE :item_name");
			 $stmt->bindParam("your_bid", $your_bid, PDO::PARAM_INT);
			 $stmt->bindParam("uid", $uid, PDO::PARAM_INT);
			 $stmt->bindParam("item_name", $item_name, PDO::PARAM_STR);
			 $stmt->execute();
			 
			 $db=null;
			 $_SESSION['uid']=$uid;
			 return true;
		 }
		 catch(PDOException $e){
			 $db=null;
			 echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		 }
	 }
	 public function sendBid($uid, $item_name,$category, $for_uid, $your_bid)
	 {
		 try{
			 $db=getDB();
			$stmt=$db->prepare("INSERT INTO bids (uid, item_name, category, offer, for_uid) VALUES (:uid,:item_name,:category,:your_bid,:for_uid)");
			$stmt->bindParam("your_bid", $your_bid, PDO::PARAM_INT);
			$stmt->bindParam("uid", $uid, PDO::PARAM_INT);
			$stmt->bindParam("item_name", $item_name, PDO::PARAM_STR);
			$stmt->bindParam("for_uid", $for_uid, PDO::PARAM_INT);
			$stmt->bindParam("category", $category, PDO::PARAM_STR);
			$stmt->execute();
			$db=null;
		 }
		 catch(PDOException $e)
		 {
			$db=null;
			echo '{"error":{"text":'. $e->getMessage() .'}}'; 
		 }
	 }
	 public function getCategory($item_name,$your_bid)
	 {
		$db=getDB();
		$stmt=$db->prepare("SELECT category FROM items WHERE item_name=:item_name");
		$stmt->bindParam("item_name", $item_name, PDO::PARAM_STR);
		$stmt->execute();
		$data = $stmt->fetch(PDO::FETCH_OBJ);
		$db=null;
		return $data;
	 }

}
?>