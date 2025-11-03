<?php
session_start();
if (! isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
	header('location: index.html');
	exit();
}
?>

<?php
	include '../db/db_connect.php';
	$email=$_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

		<title>CacheCodeR | Admin</title>

		<link rel="shortcut icon" type="Image/icon" href="../assets/images/app-images/brand-logo.png">
		<link rel="stylesheet" type="text/css" href="css/style.css">		
    	<link rel="stylesheet" href="../assets/fonts/css/all.min.css">

		<style type="text/css">

.menu {
	width: 100%; margin-top: 40px;  font-size: x-small;
}
@media only screen and (max-width: 768px){
	.profile {
		margin-top: 3px;
	}
	.menu {
		margin-top: 75px;
	}
}

.tabcontent {
	color: white;
	display: none;
	padding: 200px 0;
	height: 100%;
	display: flex;
	flex-wrap: wrap;
	justify-content: center;  
	}
		</style>
		
<body>

	<header>
		<nav>
			<div class="nav-child">
				<div class="brand">
					<div class="brand-logo">
						<img src="../assets/images/app-images/brand-logo.png">
					</div>
					<h1>Cachecoder<span>.</span></h1>
				</div>
			</div>
			<div class="nav-child">
				<div class="profile">
					<div class="user">
						<i class="fas fa-user"></i>
					</div>
					<div class="email">
						<?= $email ?>
					</div>
					<div>
						<button onclick="myfunction()" class="dropbtn"><i class="fa fa-caret-down"></i></button>
                  		<span>
                  			<div id="myDropdown" class="dropdown-content">
                    			<div>
                      				<a onclick="return confirm('Are you sure you want to LogOut?')" href="logout.php">LogOut <i class="fa fa-sign-out"></i></a>
                      			</div>
                      		</div>
                  		</span>
					</div>
				</div>
			</div>
		</nav>

		<div class="nav-menu">
			<div class="nav-menu-child"><button class="tablink" onclick="openPage('Project', this, 'purple')" id="defaultOpen">Portfolio</button></div>
			<div class="nav-menu-child"><button class="tablink" onclick="openPage('About', this, 'purple')" >Education</button></div>
		</div>
	</header>

		<main>

			<section id="Project" class="tabcontent">
				<div>
					<form method="POST" action="portfolio.php" enctype="multipart/form-data">
						<fieldset>
							<legend>portfolio</legend>
							<div class="input-style">
								<input type="number" min="1" name="id" placeholder="Input Id" required="">
							<div>
							<div class="input-style">
								<input type="text" name="title" placeholder="Input Title eg. e-cormmerce">
							<div>								
							<div class="input-style">
								<input type="text" name="discription" placeholder="Input Description About Project" required="">
							<div>
							<div class="input-style">
								<input type="file" name="img" accept="image/*" required="">
							<div>
							<div class="input-style">
								<input type="text" name="link" placeholder="Input Project Link">
							<div>
								
								<div class="center">
									<input class="submit" type="submit" value="submit">
								</div>
						</fieldset>
					</form>
				</div>
			</section>

			<!-- portfolio section-->
			<table id="About" class="tabcontent">
				<tr>
					<td>
						<fieldset>
							<legend class="menu_name">portfolio</legend>
							<form method="POST" action="portfolio.php" enctype="multipart/form-data">
								<fieldset style="color: #555;">
									<legend>Id</legend>
									<input type="number" min="1" name="id" placeholder="Input Id" required="">
								</fieldset>
								<fieldset>
									<legend style="color: #555;">Title</legend>
									<input type="text" name="title" placeholder="Input Title eg. e-cormmerce">
								</fieldset>
								<fieldset>
									<legend style="color: #555;">Description</legend>
									<input type="text" name="discription" placeholder="Input Description About Project" required="">
								</fieldset>
								<fieldset style="color: #555;">
									<legend style="color: #555;">Image/Logo</legend>
									<input type="file" name="img" accept="image/*" required="">
								</fieldset>
								<fieldset style="color: #555;">
									<legend >Project Link</legend>
									<input type="text" name="link" placeholder="Input Project Link">
								</fieldset><br>
								<div class="center">
									<input class="submit" type="submit" value="submit">
								</div>
							</form>
						</fieldset>
					</td>
				</tr>
			</table>
			<!-- /portfolio section-->			
			
		</main>

		<script>
    		function myfunction() {
    		  document.getElementById("myDropdown").classList.toggle("show");
    		}
    		window.onclick=function (event) {
    		  if (!event.target.matches('.dropbtn')) {var dropdowns = document.getElementByClassName("dropdown-content");
    		    var i;
    		    for (i = 0; i < dropdowns.length; i++) {
    		      var openDropdown = dropdowns[i];
    		      if (openDropdown.classList.contains('show')) {openDropdown.classlist.remove('show');}
    		      }
    		    }   
    		  }
  		</script>

		<script>
			function openPage(pageName,elmnt,color) {
			  var i, tabcontent, tablinks;
			  tabcontent = document.getElementsByClassName("tabcontent");
			  for (i = 0; i < tabcontent.length; i++) {
			    tabcontent[i].style.display = "none";
			  }
			  tablinks = document.getElementsByClassName("tablink");
			  for (i = 0; i < tablinks.length; i++) {
			    tablinks[i].style.backgroundColor = "";
			  }
			  document.getElementById(pageName).style.display = "block";
			  elmnt.style.backgroundColor = color;
			}
			
			// Get the element with id="defaultOpen" and click on it
			document.getElementById("defaultOpen").click();
		</script>

		<script>
    		var acc = document.getElementsByClassName("accordion");
    		var i;
    
    		for (i = 0; i < acc.length; i++) {
    		  acc[i].addEventListener("click", function() {
	        this.classList.toggle("actives");
	        var panel = this.nextElementSibling;
        	if (panel.style.display === "block") {
	          panel.style.display = "none";
	        } else {
  		        panel.style.display = "block";
  		      }
      		});
  		  }
  		</script>

	</body>
</html>
