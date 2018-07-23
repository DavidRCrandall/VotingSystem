<?php
    if(isset($_POST['submit'])){
        if(!empty($_POST['submit'])){
            session_start();
            include 'inc/voteObject.php';
            $voting = new vote();
            $votes = $voting->fetchVote($_POST['submit']);
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
            <div class="col-lg-12 text-center">
                <h2>Please Confirm Your Choices.</h2>
                <form action="inc/submitVote.php" method="post">
                <?php
                    foreach($votes as $vote){
                        $count = 0;
                        $check = array();
                        ?><h3><?php echo "<br>".$vote['voteName'];?></h3><?php
                        while($count < $vote['voteNumber']){
                            $namespace=str_replace( " ", "-", $vote['voteName']);
                            $holder = $namespace.$count;
                            $name = $voting->fetchCanidateSingle(($_POST[$holder]+0));
                            if(sizeof($check) > 0){
                                $checkLoop =0;
                                while($checkLoop < sizeof($check)){
                                    if($_POST[$holder] == $check[$checkLoop]){
                                        $print = false;
                                        break;
                                    }else{
                                        $print = true;
                                    }
                                    $checkLoop++;
                                }
                                if($print){
                                    array_push($check, $_POST[$holder]);
                                    ?><h4><?php echo $name[0]['canidateName'];?></h4><?php
                                    ?>
                                <input  type="hidden" name=<?php echo $holder;?> value=<?php echo$_POST[$holder];?>>
                                    <?php
                                }
                            }else{
                                array_push($check, $_POST[$holder]);
                                ?><h4><?php echo $name[0]['canidateName'];?></h4><?php
                                ?>
                                <input  type="hidden" name=<?php echo $holder;?> value=<?php echo$_POST[$holder];?>>
                                <?php
                            }
                            $count++;
                        }
                    }
                ?>
                <br><br><button type="submit" name="submit" class="btn btn-success" value=<?php echo $_SESSION['voteID']; ?>>Confirm</button>
                </form>
                <form action="submit.php">
                   <br> <button type="submit" name="back" class="btn btn-danger">Back</button>
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
