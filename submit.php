<?php
      session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>VotingSystem</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
    body {
        padding-top: 70px;
        /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
    }
    </style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">VotingSystem</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="selectVote.php">Voting</a>
                    </li>
                    <li>
                        <a href="admin.php">Admin</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-center">
                <?php

                    if(isset($_POST['id'])){
                        $_SESSION['voteID'] = $_POST['id'];
                    }

                    if(!isset($_SESSION['voteID'])){
                        header("Location: index.php");
                    }

                    include 'inc/voteObject.php';
                    $voting = new vote();
                    $ballot = $voting->fetchBallotByID($_SESSION['voteID']);

                    if(isset($_POST['reset'])){
                        if($_POST['reset'] == $ballot[0]['ballotReset']){
                            $_SESSION['set'] = true;
                        }
                    }

                    if($_SESSION['set'] == true){
                    echo "<h1>".$ballot[0]['ballotName']."</h1>";

                    if(isset($_SESSION['error'])){
                        echo $_SESSION['error'].'<br>';
                    }
                    
                    
                    $votes = $voting->fetchVote($_SESSION['voteID']);


                    ?> <form action="confirm.php" method="post"> <?php
                    foreach($votes as $vote){
                        $count = 0;
                        $canidates = $voting->fetchCanidateAlpha($vote['voteID']);
                        echo "<h2>".$vote['voteName']."</h2><br>";
                        while($count < $vote['voteNumber']){
                        ?>
                        <select style="font-size: 25px;" required name=<?php $new=str_replace( " ", "-", $vote['voteName']); echo $new.$count; ?>>
                        <?php
                        foreach($canidates as $canidate){
                            ?>
                                <option style="font-size: 25px;" value=<?php echo $canidate['canidateID']; ?>><?php echo $canidate['canidateName']; ?></option>
                            <?php
                        }
                        ?>
                        </select>
                        <?php
                        $count++;
                    }
                    ?><br><br><?php
                    }
                    ?> 
                     <br><button type="submit" name="submit" value=<?php echo $_SESSION['voteID']; ?>>Submit</button><br>
                     </form><?php


                 }else{
                    ?><h1>Thank You For Voting</h1><?php
                    echo "Enter Reset Code".'<br>';

                    ?><form action="submit.php" method="post">
                        <input type="password" name="reset"><br>
                        <input type="submit">
                    </form><?php
                 }

                ?>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>

</html>
