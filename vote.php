<?php
session_start();
include 'inc/voteObject.php';
if(!isset($_SESSION['LOGIN'])){
    header("Location: index.php");
}
$vote = new vote();
if(isset($_POST['name']) && isset($_POST['reset'])){
        $name = $_POST['name'];
        $reset = $_POST['reset'];
        if(!empty($name) && !empty($reset)){
            $vote->createBallot($name, $reset);
            header('Location: vote.php');
        }
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
    $vote = new vote();
    $ballots = $vote->fetchBallot();
    if(!empty($ballots)){
        foreach($ballots as $ballot){
            echo $ballot['ballotName'].'<br>';
            ?>
            <form action="inc/ballotDelete.php" method="post">
             <button type="submit" name="id" class="btn btn-danger btn-xs"  value=<?php echo $ballot['ballotID']?>>Delete</button><br>
            </form>
            <form action="details.php" method="post">
             <button type="submit" name="id" class="btn btn-success btn-xs" value=<?php echo $ballot['ballotID']?>>Details</button><br>
            </form>
            <?php
        }
    }
    

    
?>
<br>
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#Add">Add a Ballot</button>

<!-- Modal -->
<div id="Add" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Ballot</h4>
      </div>
      <div class="modal-body">
        <form action="vote.php" method="post">
        Name: <br>
        <input type="text" name="name"><br>
        Reset Code: <br> 
        <input type="text" name="reset"><br>
        <input type="submit">
</form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


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
