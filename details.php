<?php
session_start();
if(!isset($_SESSION['LOGIN'])){
    header("Location: index.php");
}
if(isset($_POST['redirct'])){
  header("Location: vote.php");
}
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
            <div class="col-lg-12">
                <?php

if(isset($_POST['id'])){
    if(!empty($_POST['id'])){
        $_SESSION['id'] = $_POST['id'];
    }
}

include 'inc/voteObject.php';
    $vote = new vote();
     if(isset($_POST['name']) && isset($_POST['number'])){
        $name = $_POST['name'];
        $number = $_POST['number'];
        if(!empty($name) && !empty($number)){
            $vote->createVote($name, $number, $_SESSION['id']);
            header('Location: details.php');
        }
    }
    $ballot = $vote->fetchBallot($_SESSION['id']);
    $cast = $ballot[0]['ballotCast'];
    echo '<h4>'.$ballot[0]['ballotName']." ".$cast.'</h4>'.'<br>';
    $results = $vote->fetchVote($_SESSION['id']);
    if(!empty($results)){
        foreach($results as $result){
            echo $result['voteName'].'<br>';
            $holder = $result['voteID'];
            ?>
            <p>Canidates</p>
            <ol>
            <?php
            $canidates = $vote->fetchCanidate($result['voteID']);
            foreach($canidates as $canidate){
                $percent = round($canidate['canidateCount']/$cast*100, 2);
                echo '<li>'.$canidate['canidateName'].': '.$canidate['canidateCount']." %$percent".'</li>';
            }
            ?>
        </ol>
            <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target=<?php echo '#add'.$result['voteID']; ?>>Add Canidate</button>

<!-- Modal -->
<div id=<?php echo 'add'.$result['voteID']; ?> class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Canidate</h4>
      </div>
      <div class="modal-body">
        <form action="inc/addaCanidate.php" method="post">
        Name: <br>
        <input type="text" name="name"><br>
        <input type="hidden" name="id" value=<?php echo $holder; ?>>
        <input type="submit">
    </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<br>
            <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target=<?php echo '#delete'.$result['voteID']; ?>>Delete Canidate</button>

<!-- Modal -->
<div id=<?php echo 'delete'.$result['voteID']; ?> class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Canidate</h4>
      </div>
      <div class="modal-body">
        <?php
            foreach($canidates as $canidate){
                echo '<p>'.$canidate['canidateName'].'</p>';
                ?>
                 <form action="inc/canidateDelete.php" method="post">
                    <button type="submit" name="id" value=<?php echo $canidate['canidateID']?>>Delete</button><br>
                 </form>
                <?php
            }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<br>
<br>
            <?php
        }
    }
    
?>
         <!-- Trigger the modal with a button -->
<br>
<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#Vote">Create a vote</button>

<!-- Modal -->
<div id="Vote" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Create Vote</h4>
      </div>
      <div class="modal-body">
       <form action="details.php" method="post">
        Name: <br>
        <input type="text" name="name"><br>
        Number: <br> 
        <input type="text" name="number"><br>
        <input type="submit">
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<br>

            <!-- Trigger the modal with a button -->
<button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target='#deleteVote'>Delete Vote</button>

<!-- Modal -->
<div id="deleteVote" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Delete Vote</h4>
      </div>
      <div class="modal-body">
        <?php
            foreach($results as $result){
                echo $result['voteName'];
                ?>
                 <form action="inc/voteDelete.php" method="post">
                    <button type="submit" name="id" value=<?php echo $result['voteID']?>>Delete</button><br>
                 </form>
                <?php
            }
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<form action="details.php" method="post">
<br><br><button type="submit" name="redirct" class="btn btn-success btn-sm" value="1">Go Back</button>
</form>


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
