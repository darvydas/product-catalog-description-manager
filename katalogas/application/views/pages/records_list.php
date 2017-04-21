<script type="text/javascript">
    function confirmDelete(id)
    {
        var link = document.getElementById(id);
        if(confirm("Ar tikrai norite šalinti šį įrašą?"))
            return true;
        else
            return false;
    }    
	function confirmSubmit(id)
    {
        var link = document.getElementById(id);
        if(confirm("Ar tikrai norite pasiūlyti šį įrašą?"))
            return true;
        else
            return false;
    }

	function filtruoti(){
		var laukas = $("#l_s").val();
		var kryptis = $("#l_k").val();
		var filtras = $("#l_f").val();
		var produktas = $("#product_id").val();
		window.location.href = "http://rude.su.lt/~silkus/katalogas/index.php/category/view_records/"+produktas+"/0/"+laukas+"/"+kryptis+"/"+filtras;
		//http://rude.su.lt/~silkus/katalogas/index.php/category/index/20/author/desc/321%20asd
	}
</script>
<?php
	function displayEdit ($status, $busena, $kategorijos_id, $produkto_id, $iraso_id){
		switch ($status) {
			case "accepted":
			if ($busena == 1) {echo anchor("category/edit/".$kategorijos_id."/".$produkto_id."/".$iraso_id, "redaguoti");} else {echo "negalima";}	
			break;			
			
			case "deleted": 
			if ($busena == 1) {echo anchor("category/edit/".$kategorijos_id."/".$produkto_id."/".$iraso_id, "redaguoti");} else {echo "negalima";}
			break;
			
			default:
			echo anchor("category/edit/".$kategorijos_id."/".$produkto_id."/".$iraso_id, "redaguoti");
			break;
		}		
	}?>
<div class ="path"> 
	<?php echo anchor($controler, 'Įrašai'); ?> >
	<?php if (isset($categ)) echo anchor($controler.'/view/'.$categ->pgs_id, $categ->label); ?> >
	<?php if (isset($heading)) echo  $heading;//if (isset($produc_id)) echo anchor($controler.'/view_records/'.$produc_id, $produc_name); ?>
</div>
<h2 class="pageH2">Įrašų sąrašas: <span><?php echo $heading?></span></h2>
<?php if(isset($heading) && isset($produc_id)) {echo "<input type='hidden' id = 'product_id' value = '$produc_id'>"; }?>

<?php echo anchor("category/create/".$categ->pgs_id."/".$produc_id, "Kuri naują įrašą"); ?>
<?php if(isset($records)) : ?>
<div class="sort-filter">
	Rikiuoti pagal <select id="l_s" name="laukas">
		<option value="iraso_id">Įrašo ID</option>
		<option value="pav">Pavadinimas</option>
		<option value="stat">Statusas</option>
		<option value="savin">Savininkas</option>
		<option value="dat">Data</option>
		<!--option value="red">Redaguoti</option>
		<option value="sal">Salinti</option>
		<option value="pasiul">Pasiūlyti</option>
		<option value="sutap">Sutapimas</option-->
	</select>   
	<select id="l_k" name="kryptis">
		<option value="asc">Didėjimo tvarka</option>
		<option value="desc">Mažėjimo tvarka</option>
	</select></br>
	Įveskite filtrą: <input id="l_f" type="text" name="filtras"/>
	<input type="button" id="l_m" value="Ieškoti" onclick="filtruoti()"/>
</div>		
<table class="records">
	<thead>
	<tr class="headers"><th>ID</th><th>Pavadinimas</th><th>Statusas</th><th>Savininkas</th><th>Data</th>
		<th>Redagavimas</th><th>Šalinimas</th><th>Siūlyti</th><th>Sutapimas</th></tr>
	</thead>
	<tbody>
	<?php foreach($records as $record) : ?>
	<tr class="iraso_eilute"><td><?php echo $record->id; ?></td>
		<td><?php echo anchor ('category/record_view/'.$categ->pgs_id.'/'.$produc_id.'/'.$record->id, $record->name); ?></td>
		<td><?php echo $record->stat_name; ?></td><td><?php echo $record->author; ?></td><td><?php echo $record->date?></td>
		<td><?php if(isset($record->stat_edit) && ($record->author_id == $usrid)) { echo displayEdit($record->stat_name, $record->stat_edit, $record->cat_id, $record->product_id, $record->id);} else echo 'negalima'; ?></td>
		<td><?php if(($record->stat_delete > 0) && ($record->author_id == $usrid)) {
			echo anchor("category/delete/".$record->id, "trinti", array('id'=>'del_'+$record->id, 'onclick'=>'return confirmDelete(this.id)'));
		}else {echo "negalima";}?></td>
		<td><?php if($record->stat_name == "draft" && $record->author_id == $usrid) echo anchor("category/submit/".$record->id, "pasiūlyti", array('id'=>'del_'+$record->id, 'onclick'=>'return confirmSubmit(this.id)')); else echo 'negalima'; ?></td>
		<td><?php if(isset($record->plagijatas) && ($record->author_id == $usrid)) echo round ($record->plagijatas, 2)."% su ID = ".$record->plag_record; ?></td>
	</tr>
	<?php endforeach; ?>
	</tbody>
</table>
<p class="puslapiavimas"><?php echo $links; ?></p>
<?php endif; ?>