<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/about.css">
	<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
	<title>About us Page</title>
</head>
<body>
	<?php
		session_start();
		include_once("../includes/header.php");
	?>
	<div class="about-wrapper">
		<div class="about-title">
			<h1>About Us</h1>
			<p>Welcome to GemaLoka, where your music finds its stage, our platform connects, and the local <br>	music scene thrives. Our mission is simple yet profound: to support and amplify the diverse talents <br> of Malaysia's local music scene, bringing the spotlight to rising stars and underground gems alike.</p>
		</div>
	</div>
	
	<div class="about-container">
		<!-- our mission wrapper -->
		<div class="mission-wrapper">
			<h2>Our Missions</h2>
			<div class="mission-grid">
				<div class="mission-grid-item">
					<h2>Empower Local Musicians</h2>
					<p>Provide a platform for local musicians to showcase their talent and reach a wider audience</p>
				</div>
				<div class="mission-grid-item">
					<h2>Foster Community Engagement</h2>
					<p>Create an inclusive environment where artists and fans can connect and celebrate music together</p>
				</div>
				<div class="mission-grid-item">
					<h2>Promote Cultural Exchange</h2>
					<p>Showcase diverse genres and perspectives, fostering cross-cultural dialogue and appreciation</p>
				</div>
			</div>
		</div>

		<!-- founding story section -->
		<div class="story-wrapper">
			<div class="story-grid">
				<div class="story-left">
					<h2>Founding Story</h2>
					<p>GemaLoka was founded by Aizad and Nazrin, two passionate music enthusiasts dedicated to uncovering and promoting the best of Malaysia's local music talent. With a vision of inclusivity and unity, they embarked on a journey to provide a platform where all genres and styles are celebrated, and where every artist has the opportunity to shine.
					</p>
				</div>
				<div class="story-right">
					<img src="../pictures/pictureblack.jpg">
				</div>
			</div>
		</div>

		<!-- future goals section -->
		<div class="goals-wrapper">
			<h2>Future Goals</h2>
			<div class="goals-grid">
				<div class="goals-grid-parent">
					<div class="goals-child">
						<i class='bx bx-expand-alt'></i>
						<p>Extend our platform to connect with more local musicians and audiences nationwide.</p>
					</div>
					<div class="goals-child">
						<i class='bx bxs-extension'></i>
						<p>Partner with sponsors to organize impactful events supporting the local music scene's growth.</p>
					</div>
					<div class="goals-child">
						<i class='bx bxs-wrench'></i>
						<p>Develop innovative, user-centric features and tools that enhance the user experience within the GemaLoka community.</p>
					</div>
					<div class="goals-child">
						<i class='bx bx-unite'></i>
						<p>Foster a vibrant space where artists, fans, and industry professionals unite to celebrate music's diversity.</p>
					</div>
				</div>
			</div>
		</div>

		<!--meet the team section -->
		<div class="grid-wrapper">
			<h2>Meet the Team</h2>
			<div class="grid">
				<div class="grid-item">
					<div class="grid-image">
						<img src="../pictures/naz.jpg">
					</div>
					<div class="grid-desc">
						<h3>Nazrin Daniel</h3>
						<p>Co-Founder</p>
					</div>
				</div>
				<div class="grid-item">
					<div class="grid-image">
						<img src="../pictures/jad.jpg">
					</div>
					<div class="grid-desc">
						<h3>Aizad Azmi</h3>
						<p>Co-Founder</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
		include_once ("../includes/footer.php");
	?>
</body>
</html>