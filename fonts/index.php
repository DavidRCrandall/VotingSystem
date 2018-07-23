<?php
	session_start();
	$_SESSION['LOC'] = "Location: ../../index.php"
	include "application/models/articleObject.php";
	$article = new article();
?>

<!DOCTYPE HTML>
<html lang = "en">

	<head>
		<title>CBC</title>
		<meta charset = "UTF-8">	
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="icon" type="image/png" href="public/images/favicon.png"> <!--  Favicon needs to be generated -->
		<link rel="stylesheet" href="public/css/bootstrap.min.css">
		<link rel="stylesheet" href="public/css/bootstrap-grid.min.css">
		<link rel="stylesheet" href="public/css/cbc.css">
		<link rel="stylesheet" href="public/css/cbc_ar_tweaks.css">
		<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
		<link rel="stylesheet" href="public/css/cbc.css">		
	</head>

	<body>

		<!--Logo and nav holder-->
		<div class="top_bar">
			
			<!--Logo holder-->
			<div class="logo_holder">
				<img class="logo" src="public/images/logo.png"></img>
			</div>
			
			<!--Nav Btn-->
			<img src="public/images/nav_btn.png" class="nav_btn" onclick="openNav()"></img>
			
			<!--Nav overlay-->
			<div id="navOverlay" class="overlay">
			
				<button class="close_btn" onclick="closeNav()">X</button>
				<!--Nav bar-->
				<nav>
					<a href="application/views/ministries.php">Ministries</a>
					<a href="application/views/calendar.php">Calendar</a>
					<a href="application/views/missions.php">Missions</a>
					<a href="https://www.eservicepayments.com/cgi-bin/Vanco_ver3.vps?appver3=wWsk24ZWJSTZKsGd1RMKlg0BDvsSG3VIWQCPJNNxD8upkiY7JlDavDsozUE7KG0nFx2NSo8LdUKGuGuF396vbQ1tsuPCVHjp1W5JXYuakrGXHubq5Z7ap5JVmPErc4ZeYHCKCZhESjGNQmZ5B-6dxySzh1gG8jJI7W2VVuH8hsw=&ver=3">Online Giving</a>
					<a href="application/views/sermons.php">Sermons</a> 
					<a href="application/views/about.php">About</a>

					<?php
						if(isset($_SESSION['LOGIN'])){
					?>
						<a href="application/views/user.php">User</a>
					<?php
						} else{
					?>
						<a href="application/views/login.php">Login</a>
					<?php
						}
					?>

				</nav>
			</div>
		</div>

		<!--Showcase Image-->
		<img class="shcase_img" src="public/images/img_1.png"></img>

		<!--Begin Sections-->
		<div class="container-fluid">
			<?php
				function printRow($color, $title, $content) {
			?>
					<div class="row">
						<!--Begin Get To know us Section-->
						<div class="col-md-4 <?php echo $color; ?>">
							<h1 class="section_title font"><?php echo $title; ?></h1>
						</div>
						
						<div class="col border-bottom border-secondary">
							<div class="row">
								<div class="col-1 d-none d-lg-block arrow-right <?php echo $color; ?>"></div>
								<div class="col">
									<h4 class="filler_text"><?php echo $content; ?></h4>
								</div>
							</div>
						</div>
						<!--End Get To Know Us-->
					</div>
			<?php
				}
				if(isset($_SESSION['LOGIN'])){
					if($_SESSION['LOGIN'] == 0){
						printRow("mustard", "Edit the home page", '<form><button formaction="application/views/editIndex.php" type="submit" class="btn btn-outline-secondary btn-lg">Edit</button>
					</form>');
					}
				}
/********************************************************************/
				$text = $article->FetchArticleByPage(11);
				$print = $text[0]['ArticleBody'];
				printRow("teal", "Get To Know Us", $print);
/********************************************************************/
				$text = $article->FetchArticleByPage(12);
				$print = $text[0]['ArticleBody'];
				printRow("darkgray", "Service Times", $print);
/********************************************************************/
				include "application/models/calanderObject.php";
				$cal = new calander();
				$event = $cal->fetchAllEvents();
				$print = $event[0]["CalanderName"].' - '.date("M d @ h:i", strtotime($event[0]["CalanderStart"])).
				'<br>'.
				$event[1]["CalanderName"].' - '.date("M d @ h:i", strtotime($event[1]["CalanderStart"])).
				'<br>'.
				$event[2]["CalanderName"].' - '.date("M d @ h:i", strtotime($event[2]["CalanderStart"])).'
				<br>
				<br>
				<form>
				<button formaction="application/views/calendar.php" type="submit" class="btn btn-outline-secondary btn-lg">More</button>
				</form>';
				printRow("lightred", "Upcoming Events", $print);
/********************************************************************/
				$text = $article->FetchArticleByPage(13);
				$print = $text[0]['ArticleBody'].'<br><br>
				<form>
				<button type="submit" formaction="application/views/missions.php" class="btn btn-outline-secondary btn-lg">See More</button>
				</form>';
				printRow("darkgreen", "Missions", $print);
/********************************************************************/
				$text = $article->FetchArticleByPage(14);
				$print = $text[0]['ArticleBody'].'<br><br>
				<form>
				<button type="submit" formaction="application/views/sermons.php" class="btn btn-outline-secondary btn-lg">Listen to Sermons</button>
				</form>';
				printRow("blue", "Sermon Podcasts", $print);
/********************************************************************/
				$text = $article->FetchArticleByPage(15);
				$print = $text[0]['ArticleBody'].'<br><br>
				<form>
				<button type="submit" formaction="application/views/ministries.php" class="btn btn-outline-secondary btn-lg">See More</button>
				</form>';
				printRow("purple", "Ministries", $print);
/********************************************************************/
				$text = $article->FetchArticleByPage(16);
				$print = $text[0]['ArticleBody'].'<br><br>
				<form>
				<a href="https://www.eservicepayments.com/cgi-bin/Vanco_ver3.vps?appver3=wWsk24ZWJSTZKsGd1RMKlg0BDvsSG3VIWQCPJNNxD8upkiY7JlDavDsozUE7KG0nFx2NSo8LdUKGuGuF396vbQ1tsuPCVHjp1W5JXYuakrGXHubq5Z7ap5JVmPErc4ZeYHCKCZhESjGNQmZ5B-6dxySzh1gG8jJI7W2VVuH8hsw=&ver=3">Online Giving</a>
				</form>';
				printRow("darkred", "Online Giving", $print);
/********************************************************************/
				$text = $article->FetchArticleByPage(17);
				$print = $text[0]['ArticleBody'].'<br><br>
				<form>
				<button type="submit" formaction="application/views/contact.php" class="btn btn-outline-secondary btn-lg">Contact Us</button>
				</form>';
				printRow("mustard", "I'm New", $print);
/********************************************************************/
				$text = $article->FetchArticleByPage(18);
				$print = $text[0]['ArticleBody'].'<br><br>
				Our address is <u>8005 Highway 81 North in Easley, SC</u>';
				printRow("darkteal", "Contact and Info", $print);
/********************************************************************/
				$text = $article->FetchArticleByPage(19);
				$print = $text[0]['ArticleBody'].'<br><br>
				<form>
				<button type="submit" formaction="application/views/about.php" class="btn btn-outline-secondary btn-lg">Learn About CBC</button>
				</form>';
				printRow("purplegray", "About CBC, Staff &amp; More", $print);
/********************************************************************/
				$text = $article->FetchArticleByPage(20);
				$print = $text[0]['ArticleBody'];
				printRow("lightred", "Social Media", $print);
			?>	
		</div>

		<!--Footer-->
		<footer class="footer">
			<div class="container text-center">
				<span class="text-muted"><!-- Place sticky footer content here. --></span> 
			</div>
		</footer>
		
		<script src="public/js/navoverlay.js"></script>

	</body>
</html>