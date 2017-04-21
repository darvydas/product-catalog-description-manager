<!DOCTYPE html>
<html lang="lt">
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8" >
	<title>Katalogas::Registracija</title>
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
    <h1 class="head"><?php echo anchor("category", "Katalogas"); ?></h1>
		<nav>
		<ul>
			<li><a href="">Įrašai</a></li>
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
  <a href="http://www.b-a.lt/ispardavimai" title="Išpardavimas parduotuvėje"><img class="reklama" src="<?php echo base_url();?>images/reklama_kvepalai_kosmetika_ispardavimas.jpg" alt="Išpardavimas parduotuvėje"></a>
    <!--ul id="myRoundabout">
      <li><img src="<?php // echo base_url();?>images/slide3.jpg" alt=""></li>
      <li><img src="<?php // echo base_url();?>images/slide2.jpg" alt=""></li>
      <li><img src="<?php // echo base_url();?>images/slide5.jpg" alt=""></li>
      <li><img src="<?php // echo base_url();?>images/slide1.jpg" alt=""></li>
      <li><img src="<?php // echo base_url();?>images/slide4.jpg" alt=""></li>
    </ul-->
  </div>
</section>
<div class="main-box">
  <div class="container">
    <div class="inside">
      <div class="wrapper">
		<section id="content">
		  <article>
			<h2 class="pageH2">Registracija</h2>
			<?php echo validation_errors(); ?> 
			<?php echo form_open('register'); ?>
			<table>
				<tr><td>Prisijungimo vardas</td><td><?php echo form_input('login_name', $this->input->post('login_name')); ?></td></tr>
				<tr><td>Slaptažodis</td><td><?php echo form_password('password'); ?></td></tr>
				<tr><td>Slaptažodžio patvirtinimas</td><td><?php echo form_password('password2'); ?></td></tr>
				<tr><td>El. paštas</td><td><?php echo form_input('mail', $this->input->post('mail')); ?></td></tr>
				<?php echo form_hidden('active', 0); ?>
				<tr><td><?php echo form_submit('register_submit', 'Registruotis'); ?></td><td><?php echo anchor ('login', 'Prisijungimas');?></td></tr>			
			</table>
			<?php echo form_close(); ?>
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