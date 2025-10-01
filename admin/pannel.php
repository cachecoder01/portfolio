<?php
session_start();
if (! isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
	header('location: index.html');
	exit();
}
?>

<?php
	include '../db/db_connect.php';
	$em=$_SESSION['email'];
	$stmt = $conn->prepare("SELECT * FROM reginfo WHERE email = ?");
    $stmt->bind_param("s", $em);
    $stmt->execute();

    $result=$stmt->get_result();
    if ($result->num_rows > 0) {
    	while ($row = $result->fetch_assoc()) {
    		$email=$row["email"];
    	}
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />

		<title>admin</title>
		<link rel="shortcut icon" type="Image/icon" href="../assets/logo/brand-logo.png">
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

		<style type="text/css">
			
#header {
	margin: 0;
	top: 0;
	position: fixed;
	width: 100%;
	padding: 15px;
	background-color: #15161D;
	color: white;
}
.brand_logo {
	padding: 5px;
	float: left;
}
.brand_name {
	float: left;
}
.profile {
	float: right;
	margin-right: 40px;
	display: flex;
	flex: wrap;
	padding: 3px;
	margin-top: 20px;
}
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

.dropdown {
	overflow: hidden;
	margin: 0;
}
.dropbtn, .dropbtn:focus { 
	padding: 3px;
	padding-left: 5px;
	margin-right: 40px;
	background-color: inherit;
	color: white;
	border: none;
}
.dropdown-content {
	display: none;
	margin-top: 10px;
	position: absolute;
	background-color: purple;
	box-shadow: 0px 1px 3px rgba(0, 0, 0, 0.05);
	z-index: 9;
	border-radius: 2px;
	padding: 3px;}
.dropdown-content a {
	color: white;
	padding: 3px;
	text-decoration: none;
	display: block;
	z-index: 9;
}
.show {
	display: block;
	z-index: 2;
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

	<div style="position: fixed; width: 100%;">

		<div id="header">
			<div class="brand_logo">
				<img src="../assets/logo/brand-logo.png" width="50">
			</div>
			<div class="brand_name">
				<h1 class="brand">Cachecoder<div style="display: inline; color: purple;">.</div></h1>
			</div>

			<div class="profile">
				<div style="padding: 3px; padding-right: 5px; border-right: thin solid purple;">
					<i class="fas fa-user"></i>
				</div>
				<div style="padding: 5px;">
					<?= $email ?>
				</div>
				<div style="">
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
		
		<div class="menu" >
			<div><button class="tablink" onclick="openPage('Home', this, 'purple')" >Expertise</button></div>
			<div><button class="tablink" onclick="openPage('News', this, 'purple')" >Education</button></div>
			<div><button class="tablink" onclick="openPage('Contact', this, 'purple')">Experience</button></div>
			<div><button class="tablink" onclick="openPage('About', this, 'purple')">Portfolio</button></div>
			<div><button class="tablink" onclick="openPage('Clients', this, 'purple')" id="defaultOpen">Clients</button></div>
		</div>

	</div>

		<main>
			<!-- expertise section-->
			<table id="Home" class="tabcontent">
				<tr>
					<td>
						<fieldset>
							<legend class="menu_name">expertise</legend>
							<form method="POST" action="expertise.php">
								<fieldset>
									<legend style="color: #555;">Id</legend>
									<input type="number" min="1" name="id" placeholder="Input Id" required="">
								</fieldset>
								<fieldset>
									<legend style="color: #555;">Category</legend>
									<Select input type="text" name="category" placeholder="Input Category" required="">
										<option>FrontEnd Development</option>
										<option>BackEnd Development</option>
										<option>DataBase</option>
										<option>UI/UX Designing</option>
										<option>Software Development</option>
										<option>App Development</option>
									</Select>
								</fieldset>
								<fieldset>
									<legend style="color: #555;">Language</legend>
									<input type="text" name="language" placeholder="Input Language" required="">
									<br><br>
									<input type="text" name="progress_bar" required="" placeholder="progress(%)">
								</fieldset><br>
								<div class="center">
									<input class="submit" type="submit" value="submit">
								</div>
							</form>
						</fieldset>
					</td>
				</tr>
			</table>
			<!-- /expertise section-->

			<!-- education section-->
			<table id="News" class="tabcontent">
				<tr>
					<td>
						<fieldset>
							<legend class="menu_name">education</legend>
							<form method="POST" action="education.php" enctype="multipart/form-data">
								<fieldset style="color: #555;">
									<legend>Id</legend>
									<input type="number" min="1" name="id" placeholder="Input Id" required="">
								</fieldset>
								<fieldset style="color: #555;">
									<legend>Period Of Education</legend>
									<label>From:</label>
									<input style="width: 70px;" type="number" name="from" placeholder="Start date" required="">
									<label>- To:</label>
									<input style="width: 70px;" type="number" name="to" placeholder="finish date" required=""><br>
									<input type="checkbox" name="status" value="Ongoing"> Currently schooling here
								</fieldset>
								<fieldset style="color: #555;">
									<legend >Degree</legend>
									<input type="text" name="degree" placeholder="Degree Attained" required="">
								</fieldset>
								<fieldset>
									<legend style="color: #555;">School/Colledge</legend>
									<input type="text" name="school" placeholder="name of School" required="">
								</fieldset>
								<fieldset>
									<legend style="color: #555;">Location</legend>
									<input type="text" name="location" placeholder="Input Location" required="">
								</fieldset>
								<fieldset style="color: #555;">
									<legend >Certificaion Obtained</legend>
									<input type="text" name="description" placeholder="Description">
								</fieldset><br>
								<div class="center">
									<input class="submit" type="submit" value="submit">
								</div>
							</form>
						</fieldset>
					</td>
				</tr>
			</table>
			<!-- /education section-->

			<!-- experience section-->
			<table id="Contact" class="tabcontent">
				<tr>
					<td>
						<fieldset>
							<legend class="menu_name">experience</legend>
							<form method="POST" action="experience.php" enctype="multipart/form-data">
								<fieldset style="color: #555;">
									<legend>Id</legend>
									<input type="number" name="id" min="1" placeholder="Input Id" required="">
								</fieldset>
								<fieldset style="color: #555;">
									<legend >Period Of Program</legend>
									<label style="color: #555;">From:</label>
									<input style="width: 70px;" type="number" name="from" placeholder="Start_Date" required="">
									<label style="color: #555;">- To:</label>
									<input style="width: 70px;" type="number" name="to" placeholder="Finish_Date"><br>
                                    <input type="checkbox" name="status" value="Ongoing"> Ongoing
								</fieldset>
								<fieldset>
									<legend style="color: #555;">Program/Course</legend>
									<input type="text" name="program" placeholder="program" required="">
								</fieldset>
								<fieldset>
									<legend style="color: #555;">Organisation</legend>
									<input type="text" name="org" placeholder="name of Organisation" required="">
								</fieldset>
								<fieldset>
									<legend style="color: #555;">Location</legend>
									<input type="text" name="location" placeholder="Input Location">
								</fieldset>
								<fieldset style="color: #555;">
									<legend >Certificaion Obtained</legend>
									<input type="text" name="description" placeholder="Description">
									<br><br>
									<input type="text" name="cert" placeholder="Certificaion">
								</fieldset><br>
								<div class="center">
									<input class="submit" type="submit" value="submit">
								</div>
							</form>
						</fieldset>
					</td>
				</tr>
			</table>
			<!-- /experience section-->

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

			<!-- clients section-->
			<div id="Clients" class="tabcontent">
				
				<table>
					<tr>
						<td>
							<fieldset>
								<legend style="color: #555;">Contact Message</legend>
								<button class="accordion">Messages <img src='../assets/fonts/caret-down-fill.svg'></button>
								<div class="panel">
									<div class="contact_sms" style="">
										<?php
										include '../db/db_connect.php';
										$stmt=$conn->prepare("SELECT * FROM contact_form ORDER BY time_added desc");
										$stmt->execute();

										$result=$stmt->get_result();
										if ($result->num_rows>0) {
											while ($row = $result->fetch_assoc()) {
												$id=$row["id"];
												$name=$row["name"];
												$email=$row["email"];
												$sub=$row["subject"];
												$sms=$row["message"];
										?>
											<form method='POST' action='del_contact.php' onsubmit="return confirm('Are you sure you want to delete this message?');">
												<input type="hidden" name="id" value="<?= $id ?>">
										<?php
												echo "<p>Subject: " .$sub. "</p>
													  <p style='margin-bottom: 0;'>" .$sms. "</p>
													  <p style='font-size: small; color: #ccc; margin-top: 0;'>
													  	" .$name."<br>
													  	<a href='mailto:" .$email."'>" .$email."</a>
													  	<button type='submit' style='all: unset;'>
													  		<img src='../assets/fonts/trash3.svg'>
													  	</button>
													  </p>
													";
										echo '</form>';
											}
										}else {
											echo "<p>No Message</p>";
										}
										?>
									</div>
								</div>
							</fieldset>
						</td>
					</tr>
				</table>

				<table>
					<tr>
						<td>
							<fieldset>
								<legend style="color: #555;">Testimonials</legend>
								<button class="accordion">Messages <img src='../assets/fonts/caret-down-fill.svg'></button>
								<div class="panel">
									<div class="contact_sms" style="">
										<?php
										if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
											$id = intval($_POST['id']);
										}
										?>
										<?php
										$stmt=$conn->prepare("SELECT * FROM testimonial ORDER BY id desc");
										$stmt->execute();

										$result=$stmt->get_result();
										if ($result->num_rows>0) {
											while ($row = $result->fetch_assoc()) {
												$id=htmlspecialchars($row["id"]);
												$name=htmlspecialchars($row["name"]);
												$email=$row["email"];
		  										$brand_name=$row["brand_name"];
		  										$brand_logo=$row["brand_img"];
		  										$test=$row["testimonial"];
		  								?>
		  									<div>
		  										<form method='POST' action='del_testimonial.php' onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
		  												<input type='hidden' name='id' value='<?= $id ?>'>
		  												
												  <p>
													<?php if (!empty($brand_logo)) {?>
			    											<img src="../assets/images/clients/<?= $brand_logo ?>" alt="Client/brand-logo" class="client-image" />
			    										<?php } ?>
													<?= $brand_name ?>
												  </p>
													  <p style='margin-bottom: 0;'><?= $test ?></p>
													  <p style='font-size: small; color: #999; margin-top: 0;'>
													  	<?= $name ?><br>
													  	<a href='mailto:<?= $email ?>'><?= $email ?></a>
													  	
													  	<button type='submit' style='all: unset;'>
													  		<img src='../assets/fonts/trash3.svg'>
													  	</button>
													  </p>
												</form>
											</div>
										<?php
											}
										}else {
											echo "<p>No Message</p>";
										}
										?>
									</div>
								</div>
							</fieldset>
						</td>
					</tr>
				</table>
				
			</div>
			
			<!-- /clients section-->
			
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
