<!DOCTYPE html>
<html lang="lt">
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8" >
	<title>Welcome to CodeIgniter</title>
	<link rel="stylesheet" href="<?php echo base_url();?>css/reset.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="all">
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.8.3.min.js" ></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/cufon-yui.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>fonts/Sansation_Light_300-Sansation_700-Sansation_Light_italic_300-Sansation_italic_700.font.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/roundabout.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/roundabout_shapes.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/gallery_init.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/cufon-replace.js"></script>
	<!--[if lt IE 7]>
	<link rel="stylesheet" href="<?php echo base_url();?>css/ie6.css" type="text/css" media="all">
	<![endif]-->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo base_url();?>js/html5.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/IE9.js"></script>
	<![endif]-->
</head>
<body>
<header>
  <div class="container">
    <h1><?php echo anchor("category", "Katalogas"); ?></h1>
		<nav>
		<ul>
			<li><a href="">Áraðai</a></li>
			<li><a href="">Vartotojai</a></li>
			<li><a href="">Patvirtinti</a></li>
			<li><a href="">Valdymas</a></li>
			<li><a href="">Vartotojas</a></li>
			<li><a href="">Atsijungti</a></li>
		</ul>
		</nav>
  </div>
</header>
<section id="gallery">
  <div class="container">
    <ul id="myRoundabout">
      <li><img src="<?php echo base_url();?>images/slide3.jpg" alt=""></li>
      <li><img src="<?php echo base_url();?>images/slide2.jpg" alt=""></li>
      <li><img src="<?php echo base_url();?>images/slide5.jpg" alt=""></li>
      <li><img src="<?php echo base_url();?>images/slide1.jpg" alt=""></li>
      <li><img src="<?php echo base_url();?>images/slide4.jpg" alt=""></li>
    </ul>
  </div>
</section>
<div class="main-box">
  <div class="container">
    <div class="inside">
      <div class="wrapper">
		<section id="content">
		  <article>
			<h2 class="pageH2">Welcome to CodeIgniter!</h2>
				<p>The page you are looking at is being generated dynamically by CodeIgniter.</p>

				<p>If you would like to edit this page you'll find it located at:</p>
				<code>application/views/welcome_message.php</code>

				<p>The corresponding controller for this page is found at:</p>
				<code>application/controllers/welcome.php</code>

				<p>If you are exploring CodeIgniter for the very first time, you should start by reading the <a href="user_guide/">User Guide</a>.</p>
		  </article>
		</section>
      </div>
    </div>
  </div>
</div>
<footer> 
  <div class="container">
    <div class="footerlink">
		<a href="#" class="scrollup">Scroll</a>
      <p class="lf">Katalogas &copy; 2012 <?php echo anchor("category", "Katalogas"); ?> - All Rights Reserved</p>
      <!--p class="rf"><a href="http://all-free-download.com/free-website-templates/">Free CSS Templates</a> by <a href="http://www.templatemonster.com/">TemplateMonster</a></p-->
	  <p class="rf">Page rendered in <strong>{elapsed_time}</strong> seconds</p>
      <div style="clear:both;"></div>
    </div>
  </div>
</footer>
<script type="text/javascript"> Cufon.now(); </script>
</body>
</html>