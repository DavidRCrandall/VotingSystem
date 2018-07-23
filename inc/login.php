<?php
	session_start();
	require_once 'userObject.php';
	if(isset($_POST['name']) && isset($_POST['password'])){
		$name = $_POST['name'];
		$pass = $_POST['password'];
		if(!empty($name) && !empty($pass)){
			$login = new user();
			$login->login($name, $pass);
			header("Location: ../admin.php");
		}else
		{
			header("Location: ../index.php");
		}
	}else
	{
		header("Location: ../index.php");
	}

?>