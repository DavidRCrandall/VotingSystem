<?php
	session_start();
	if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['confirm'])){
		if(!empty($_POST['name']) && !empty($_POST['password']) && !empty($_POST['confirm']) ){
			require_once "userObject.php";
			$user = new user();
			if($_POST['password'] == $_POST['confirm']){
			if($return = $user->createUser($_POST['name'], $_POST['password'])){
				header("Location: ../users.php");
			}else{
				$_SESSION['userError'] = $return;
				header("Location: ../users.php");
			}
		}else{
			$_SESSION['userError'] = "Passwords do not match";
			header("Location: ../users.php");
		}
		}else{
			header("Location: ../index.php");
		}
	}else{
		header("Location: ../index.php");
	}


?>