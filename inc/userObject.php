<?php
	class user
	{
			function createUser($name, $password){
			include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);

			$stmt =$conn->prepare("INSERT INTO user (userName, userPassword, userLevel) VALUES (?,?, 1)");
			$stmt->bind_param("ss", $newName, $newPassword);

			$newName = mysqli_real_escape_string($conn, $name);
			$newPassword =password_hash($password, PASSWORD_DEFAULT);

			if($stmt->execute()){
				$stmt->close();
				$conn->close();
				return TRUE;
			}else{
				$stmt->close();
				$conn->close();
				return "Error Creating User";
			}	

		}

		function login($username, $password){
		include "inc.php";
		$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
		$query ="SELECT * FROM user WHERE userName = '$username'";
		$results = $conn->query($query);
		$rows = $results->fetch_all(MYSQLI_ASSOC);
		if(password_verify($password,$rows[0]["userPassword"])){
			$_SESSION['LOGIN'] = $rows[0]["userLevel"];
			$_SESSION['USER'] = $rows[0]["userID"];

		}
	}

		function updatePassword($password, $id){
		include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$stmt =$conn->prepare("UPDATE user SET userPassword=? WHERE userID=$id");
			$stmt->bind_param("s", $newPassword);

			$newPassword =password_hash($password, PASSWORD_DEFAULT);
			if($stmt->execute()){
				$stmt->close();
				$conn->close();
				return TRUE;
			}else{
			$stmt->close();
			$conn->close();
			return "Error password change failed";
		}
	}

	function deleteUser($id){
		include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$query = "DELETE FROM user WHERE userID='$id'";
			$results = $conn->query($query);
			$conn->close();
	}

	function fetchAll(){
		include "inc.php";
			$conn = new mysqli($IP,$USERNAME,$PASSWORD, $DB);
	
			$query ="SELECT * FROM user";
			$results = $conn->query($query);
			$return = $results->fetch_all(MYSQLI_ASSOC);
			$conn->close();
			return $return;
	}
}
?>