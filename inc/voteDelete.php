<?php
	include 'voteObject.php';
	$vote = new vote();
	if(isset($_POST['id'])){
		if(!empty($_POST['id'])){
			$vote->deleteVote($_POST['id']);
		}
	}
	header('Location: ../details.php');
?>