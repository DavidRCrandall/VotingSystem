<?php
if(isset($_POST['submit'])){
    if(!empty($_POST['submit'])){

            session_start();
        	include 'voteObject.php';
            $voting = new vote();
            $votes = $voting->fetchVote($_POST['submit']);

            $unique = true;
  /*          foreach($votes as $vote){
                $count = 0;
                $check = array();
                while($count < $vote['voteNumber'] ){
                    $namespace=str_replace( " ", "-", $vote['voteName']);
                    $holder = $namespace.$count;
                    $name = $voting->fetchCanidateSingle(($_POST[$holder]+0));
                    if($name[0]['canidateName'] == "No Vote"){
                         $_SESSION['error'] = "";
                        $count++;
                    }else{
                    if(sizeof($check) > 0){
                        foreach($check as $test){
                            if($test == $_POST[$holder]){
                                    $unique = false;
                                }
                            }
                        }
                     if($unique == true){
                    array_push($check, $_POST[$holder]);
                    $_SESSION['error'] = "";
                    }
                    else{
                        $_SESSION['error'] = "Please do not vote for a canidate multiple times";
                        header("Location: ../submit.php");
                    }
                    $count++;
                }
            }
        }
*/
                   
        if($unique == true){
            $voting->ballotCast($_POST['submit']);
            foreach($votes as $vote){
            	$count = 0;
            	while($count < $vote['voteNumber'] ){
                    $namespace=str_replace( " ", "-", $vote['voteName']);
                	$holder = $namespace.$count;
                    if(isset($_POST[$holder])){
                		$submit = $_POST[$holder];
                		$voting->castVote($submit);
                    }
                    $count++;
        	   }
               $_SESSION['set'] = false; 
        	}
            header("Location: ../submit.php");
        }
    }else{
        header("Location: ../index.php");
    }
}else{
    header("Location: ../index.php");
}
?>