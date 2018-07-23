<?php
	if(isset($_POST['delete'])){
		if(!empty($_POST['delete'])){
			require_once "userObject.php";
			$user = new user();
			$user->deleteUser($_POST['delete']);
			header("Location: ../users.php");
		}else{
			header("Location: ../index.php");
		}
	}else{
		header("Location: ../index.php");
	}


?>