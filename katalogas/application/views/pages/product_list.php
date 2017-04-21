<script>
	function filtruoti(){
		var laukas = $("#l_s").val();
		var kryptis = $("#l_k").val();
		var filtras = $("#l_f").val();
		var kategorija = $("#category_id").val();

			var n = $(".headers th").length;
			if (n == 4) {
				// rude.su.lt:
				window.location.href = "http://rude.su.lt/~silkus/katalogas/index.php/category/index/0/"+laukas+"/"+kryptis+"/"+filtras;
				//http://rude.su.lt/~silkus/katalogas/index.php/category/index/20/author/desc/321%20asd
				
				//localhost
				//window.location.href = "http://localhost/web/katalogas/index.php/category/index/0/"+laukas+"/"+kryptis+"/"+filtras;
			}
			else {
				//rude.su.lt
				window.location.href = "http://rude.su.lt/~silkus/katalogas/index.php/category/view/"+kategorija+"/0/"+laukas+"/"+kryptis+"/"+filtras;
				
				//localhost
				//window.location.href = "http://localhost/web/katalogas/index.php/category/view/"+kategorija+"/0/"+laukas+"/"+kryptis+"/"+filtras;
			}
	}
</script>
<?php	//funkcija kategoriju medzio atvaizdavimui
	function output_childs($mas, $anchor){
		if(!empty($mas)){
			echo "<ul>";
			foreach($mas as $ob){
				switch ($anchor){
					case "confirm":
						echo "<li>".(anchor("confirm/view/".$ob->pgs_id, $ob->label, array('id'=>'view_products/'+$ob->pgs_id, 'onclick'=>'return showProducts(this.id)'))); //."</li>";	
						//echo "<li><a href='javascript: void(0)' onclick='showProducts($ob->id)'>$ob->label</a></li>";
						//echo '<div id="txtHint"></div>';
						if(isset($ob->childs)){
							output_childs($ob->childs, $anchor);
						}
						echo "</li>";
					break;
					
					case "category":
					if ($ob->kiek_p >= 1) {
						echo "<li>".(anchor("category/view/".$ob->pgs_id, $ob->label, array('id'=>'view_products/'+$ob->pgs_id, 'onclick'=>'return showProducts(this.id)')));
					}else {
						echo "<li>".$ob->label;
					}
						if(isset($ob->childs)){
							output_childs($ob->childs, $anchor);
						}
						echo "</li>";
					break;
				}
			}
			echo "</ul>";
		}
	}
?>	
<div class="wrapper">
<?php //sugeneruoto kategoriju medzio atvaizdavimas
	if(isset($meniu2)):	?>
		<aside>
		  <div id="smoothmenu" class="ddsmoothmenu">		
			<?php output_childs($meniu2, $controler);  ?>
		  </div>
		</aside>
<?php endif;  ?>
 <section id="content">
  <div class ="path"> 
	<?php echo anchor($controler, 'Titulinis'); ?> >
	<?php if (isset($heading)) { echo $heading; }//if (isset($categ_id)) { echo anchor($controler.'/view/'.$categ_id, $categ_name); } ?>
  </div>
  <article>
	<h2 class="pageH2">Produktų sąrašas: <span><?php echo $heading?></span></h2>
	<?php if(isset($products)) : ?>
	<?php if(isset($heading) && isset($categ_id)) {echo "<input type='hidden' id = 'category_id' value = '$categ_id'>"; }?>
	<div class="sort-filter">
		Rikiuoti pagal <select id="l_s" name="laukas">
			<option value="prekes_id">Prekės ID</option>
			<option value="pav">Pavadinimas</option>
			<?php if($heading == "Visi") {echo "<option value='kategorija'>Kategorija</option>";}?>
			<option value="aprasymas">Trumpas aprašymas</option>
		</select>   
		<select id="l_k" name="kryptis">
			<option value="asc">Didėjimo tvarka</option>
			<option value="desc">Mažėjimo tvarka</option>
		</select></br>
		Įveskite filtrą: <input id="l_f" type="text" name="filtras"/>
		<input type="button" id="l_m" value="Ieškoti" onclick="filtruoti()"/>
	</div>
	<table class="products">
		<thead>
			<tr class="headers">
				<th>Prekės ID</th>
				<th>Pavadinimas</th>
				<?php if($heading == "Visi") {echo "<th>Kategorija</th>";}?>
				<th>Trumpas aprašymas</th>
			</tr>	
		</thead>
		<tbody>
		<?php foreach($products as $product) : ?>
			<tr class="iraso_eilute"><td><?php echo $product->pre_id; ?></td>
				<td><?php echo anchor($controler.'/view_records/'.$product->pre_id, $product->name); ?></td>
				<?php if($heading == "Visi") {echo "<td class='category_field'>$product->cat_name</td>";}?>
				<td class="describe_field"><?php echo $product->describe; ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<p class="puslapiavimas"><?php echo $links; ?></p>
	<?php endif; ?>
  </article>
 </section>
</div>