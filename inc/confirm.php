<?php
	session_start();
	if(isset($_POST['confirm']) && isset($_POST['password']) && isset($_POST['id']) ){
		if(!empty($_POST['confirm']) && !empty($_POST['password']) && !empty($_POST['id']) ){
			require_once "userObject.php";
			$user = new user();
			if($_POST['password'] == $_POST['confirm']){
				$result = $user->updatePassword($_POST['password'], $_POST['id']);
				if($result){
				header("Location: ../users.php");
			}else{
				$_SESSION['passError'] = $result;
				header("Location: ../editPass.php");
			}
			}else{
				$_SESSION['passError'] = "passwords did not match";
				header("Location: ../editPass.php");
			}
		}else{
			header("Location: ../index.php");
		}
	}else{
		header("Location: ../index.php");
	}


?>