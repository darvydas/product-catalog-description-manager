<body>
<!-- START PAGE SOURCE -->
<header>
  <div class="container">
    <h1 class="head"><?php echo anchor("category", "Katalogas"); ?></h1>
		<nav>
			<ul>
	<?php if($adm == 2) : ?>
				<li><?php echo ($controler == "category") ? anchor("category", "Įrašai", array('class'=>'current')) : anchor("category", "Įrašai"); ?></li>
				<li><?php if($controler == "users" && ($segment2 == 'index' OR $segment2 == '')) { echo anchor("users", "Vartotojai", array('class'=>'current')); 
														}else echo anchor("users", "Vartotojai"); 
				?></li>
				<li><?php echo ($controler == "confirm") ? anchor("confirm", "Patvirtinti", array('class'=>'current')) : anchor("confirm", "Patvirtinti"); ?></li>
				<li><?php echo ($controler == "receivers") ? anchor("receivers", "Valdymas", array('class'=>'current')) : anchor("receivers", "Valdymas"); ?></li>
				<li><?php if(isset($usrid)){ 
							if(isset($segment2) && $segment2 == 'user_view') {echo anchor("users/user_view/".$usrid, "Vartotojas", array('class'=>'current'));} 
													else {echo anchor("users/user_view/".$usrid, "Vartotojas");} } ?></li>
				<li><?php echo anchor("login/out", "Atsijungti"); ?></li>
	<?php endif; ?>
	<?php if($adm == 1) : ?>
				<li><?php echo ($controler == "category") ? anchor("category", "Įrašai", array('class'=>'current')) : anchor("category", "Įrašai"); ?></li>
				<li></li>
				<li><?php echo ($controler == "confirm") ? anchor("confirm", "Patvirtinti", array('class'=>'current')) : anchor("confirm", "Patvirtinti"); ?></li>
				<li></li>
				<li><?php if(isset($usrid)){ 
							if(isset($segment2) && $segment2 == 'user_view') {echo anchor("users/user_view/".$usrid, "Vartotojas", array('class'=>'current'));} 
													else {echo anchor("users/user_view/".$usrid, "Vartotojas");} } ?></li>
				<li><?php echo anchor("login/out", "Atsijungti"); ?></li>
	<?php endif; ?>	
	<?php if(($adm != 1) && ($adm != 2)) : ?>
				<li><?php echo ($controler == "category") ? anchor("category", "Įrašai", array('class'=>'current')) : anchor("category", "Įrašai"); ?></li>
				<li></li>
				<li></li>
				<li></li>
				<li><?php if(isset($usrid)){ 
							if(isset($segment2) && $segment2 == 'user_view') {echo anchor("users/user_view/".$usrid, "Vartotojas", array('class'=>'current'));} 
													else {echo anchor("users/user_view/".$usrid, "Vartotojas");} } ?></li>
				<li><?php echo anchor("login/out", "Atsijungti"); ?></li>
	<?php endif; ?>
			</ul>
		</nav>
	 <?php // if(($adm != 1) && ($adm != 2)) echo "<div class='points'>Turimų taškų skaičius: ". $points->trust."</div>";?>
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