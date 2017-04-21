<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6" lang="lt"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" lang="lt"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" lang="lt"> <![endif]-->
<!--[if gt IE 8]><!-- <html class="no-js" lang="lt"> <!--<![endif]-->
<html lang="lt">
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8" >
	<title>Katalogas::<?php echo $title ?></title>
	<link rel="stylesheet" href="<?php echo base_url();?>css/reset.css" type="text/css" media="all">
	<link rel="stylesheet" href="<?php echo base_url();?>css/style.css" type="text/css" media="all">
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.8.3.min.js" ></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/cufon-yui.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>fonts/Sansation_Light_300-Sansation_700-Sansation_Light_italic_300-Sansation_italic_700.font.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/cufon-replace.js"></script>
	<!--[if lt IE 7]>
	<link rel="stylesheet" href="<?php echo base_url();?>css/ie6.css" type="text/css" media="all">
	<![endif]-->
	<!--[if lt IE 9]>
	<script type="text/javascript" src="<?php echo base_url();?>js/html5.js"></script>
	<script type="text/javascript" src="<?php echo base_url();?>js/IE9.js"></script>
	<![endif]-->
	<script type="text/javascript" src="<?php echo base_url();?>js/jquery.ias.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
	//------------------ puslapiavimas -------------------
		jQuery.ias({
			container : '#content',
			item: '.iraso_eilute',
			pagination: '.puslapiavimas',
			next: '.sekantis a',
			loader: '<img src="<?php echo base_url();?>images/loader.gif"/>',
			triggerPageThreshold: 100,
		});
	//----------------------------- button to top ----------------------------
	// http://gazpo.com/2012/02/scrolltop/
		$(window).scroll(function(){
			if ($(this).scrollTop() > 50) {
				$('.scrollup').fadeIn();
			} else {
				$('.scrollup').fadeOut();
			}
		}); 

		$('.scrollup').click(function(){
			$("html, body").animate({ scrollTop: 0 }, 600);
			return false;
		});
	//-----------------------------------------------------------------------
	});	</script>
<script type="text/javascript">
	//-------------- "record_create.php" select product -------------------------------
	function showProductsByCategory(product, id){
	//alert(id);
		if(id == null){
			id = $('#categorija').val();
		}
		//alert(id);
		$('#produktai').html('');
		if(product==null){
			product = $('#product_id').val();
		}
		//alert(product);
		var jqxhr = $.getJSON(
		"http://rude.su.lt/~silkus/katalogas/index.php/category/view_select_products/"+id
		//"http://localhost/web/katalogas/index.php/category/view_select_products/"+id
		, null, function(data) {	
			//alert(product);
			$("#produktai").addItems(data, product);
		})
		.error(function() { 
		//ka daryt jei nera prekiu
			alert('produktų sąrašas negautas');
		})
	}
	$.fn.addItems = function(data, product) {
				return this.each(function() {
					var list = this;
					$.each(data, function(index, itemData) {
						if(itemData.pre_id == product){
							var option = new Option(itemData.name, itemData.pre_id, false, true);
						}else{
							var option = new Option(itemData.name, itemData.pre_id);
						}
						list.add(option);
					});
				});
			};
	//--------------------------------------------------------------------
	</script>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/ddsmoothmenu.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>css/ddsmoothmenu-v.css" />	
<script type="text/javascript" src="<?php echo base_url();?>js/menu/ddsmoothmenu.js">
	/***********************************************
	* Smooth Navigational Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
	* This notice MUST stay intact for legal use
	* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
	***********************************************/</script>	
<script type="text/javascript">
	/*ddsmoothmenu.init({
		mainmenuid: "smoothmenu", //menu DIV id
		orientation: 'h', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu', //class added to menu's outer DIV
		//customtheme: ["#1c5a80", "#18374a"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	})*/
	ddsmoothmenu.init({
		mainmenuid: "smoothmenu", //Menu DIV id
		orientation: 'v', //Horizontal or vertical menu: Set to "h" or "v"
		classname: 'ddsmoothmenu-v', //class added to menu's outer DIV
		method: 'toggle', // set to 'hover' (default) or 'toggle'
		arrowswap: true, // enable rollover effect on menu arrow images?
		//customtheme: ["#804000", "#482400"],
		contentsource: "markup" //"markup" or ["container_id", "path_to_menu_file"]
	})	</script>
</head>