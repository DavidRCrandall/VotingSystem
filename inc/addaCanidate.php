<?php
include 'voteObject.php';
    $vote = new vote();
if(isset($_POST['name'])){
        $name = $_POST['name'];
        if(!empty($name)){
            $vote->createCanidate($name, $_POST['id']);
            header('Location: ../details.php');
        }else{
    		header("Location: ../index.php");
        }
    }else{
    	header("Location: ../index.php");
    }
?>