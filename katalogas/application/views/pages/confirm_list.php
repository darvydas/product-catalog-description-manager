<script type="text/javascript">
function confirmDecline(id)
{
	var link = document.getElementById(id);
	if(confirm("Ar tikrai norite atšaukti šį įrašą?")){ 
		return true;
	}
	else
		return false;
}
function confirmAccept(id)
{
	var link = document.getElementById(id);
	if(confirm("Ar tikrai norite patvirtinti šį įrašą?"))
			
		//reikia atmesti kitus accepted irasus
		
		return true;
	else
		return false;
}
function confirmDelete(id)
{
	var link = document.getElementById(id);
	if(confirm("Ar tikrai norite šalinti šį įrašą?"))
		return true;
	else
		return false;
}    
	function filtruotiConfirm(){
		var laukas = $("#l_s").val();
		var kryptis = $("#l_k").val();
		var filtras = $("#l_f").val();
		var produktas = $("#product_id").val();
		window.location.href = "http://rude.su.lt/~silkus/katalogas/index.php/confirm/view_records/"+produktas+"/0/"+laukas+"/"+kryptis+"/"+filtras;
		//http://rude.su.lt/~silkus/katalogas/index.php/category/index/20/author/desc/321%20asd
	}
</script>
<?php
	function displayEdit ($status, $busena, $kategorijos_id, $produkto_id, $iraso_id) { //$status, $busena, $iraso_id){
		switch ($status) {
			case "accepted":
			if ($busena == 1) {echo anchor("confirm/edit/".$kategorijos_id."/".$produkto_id."/".$iraso_id, "redaguoti");} else {echo "negalima";}	
			break;			
			
			case "deleted": 
			if ($busena == 1) {echo anchor("confirm/edit/".$kategorijos_id."/".$produkto_id."/".$iraso_id, "redaguoti");} else {echo "negalima";}
			break;
			
			default:
			echo anchor("confirm/edit/".$kategorijos_id."/".$produkto_id."/".$iraso_id, "redaguoti");
			break;
		}		
	}
	function displayAcceptDecline ($status, $iraso_id){
		switch ($status) {
			case "accepted": 
			echo '<td>negalima</td>';
			echo '<td>'.anchor("confirm/decline/".$iraso_id, "atmesti", array('id'=>'dec_'+$iraso_id, 'onclick'=>'return confirmDecline(this.id)')).'</td></tr>';
		
			break;			
			
			case "deleted": 
			echo '<td>negalima</td>';
			echo '<td>negalima</td></tr>';
			break;
			
			case "submitted": 
			echo '<td>'.anchor("confirm/accept/".$iraso_id, "priimti", array('id'=>'acc_'+$iraso_id, 'onclick'=>'return confirmAccept(this.id)')).'</td>';
			echo '<td>'.anchor("confirm/decline/".$iraso_id, "atmesti", array('id'=>'dec_'+$iraso_id, 'onclick'=>'return confirmDecline(this.id)')).'</td></tr>';
			break;
			
			default:
			echo '<td>negalima</td>';
			echo '<td>negalima</td></tr>';
			break;
		}		
	}?>
<div class ="path"> 
	<?php echo anchor($controler, 'Titulinis'); ?> >
	<?php if (isset($categ)) echo anchor($controler.'/view/'.$categ->pgs_id, $categ->label); ?> >
	<?php if (isset($heading)) echo  $heading; ?>
</div>
<h2 class="pageH2">Įrašų sąrašas: <span><?php echo $heading?></span></h2>
<?php if(isset($heading) && isset($produc_id)) {echo "<input type='hidden' id = 'product_id' value = '$produc_id'>"; }?>
	<?php if(isset($records)) : ?>
	<div class="sort-filter">
		Rikiuoti pagal <select id="l_s" name="laukas">
			<option value="iraso_id">Įrašo ID</option>
			<option value="pav">Pavadinimas</option>
			<option value="stat">Statusas</option>
			<option value="savin">Savininkas</option>
			<option value="dat">Data</option>
			<!--option value="sutap">Sutapimas</option-->
		</select>   
		<select id="l_k" name="kryptis">
			<option value="asc">Didėjimo tvarka</option>
			<option value="desc">Mažėjimo tvarka</option>
		</select></br>
		Įveskite filtrą: <input id="l_f" type="text" name="filtras"/></br>
		<input type="button" id="l_m" value="Ieškoti" onclick="filtruotiConfirm()"/>
	</div>		
	<table  class="records_confirm">
		<tr class="headers"><th>ID</th><th>Pavadinimas</th><th>Statusas</th><th>Savininkas</th><th>Data</th>
			<th>Redagavimas</th><th>Šalinimas</th><th>Sutapimas</th><th>Patvirtinimas</th><th>Atmetimas</th></tr>
		<?php foreach($records as $record) : ?>
		<tr class="iraso_eilute"><td><?php echo $record->id; ?></td>
			<td><?php echo anchor ('confirm/record_view/'.$categ->pgs_id.'/'.$produc_id.'/'.$record->id, $record->name); ?></td>
			<td><?php echo $record->stat_name; ?></td><td><?php echo $record->author; ?></td><td><?php echo $record->date?></td>
			<td><?php isset($record->stat_edit) ? displayEdit($record->stat_name, $record->stat_edit, $record->cat_id, $record->product_id, $record->id) : klaida ?></td>
			<td><?php if($record->stat_delete > 0) {echo anchor("category/delete/".$record->id, "trinti", array('id'=>'del_'+$record->id, 'onclick'=>'return confirmDelete(this.id)'));}else {echo "negalima";}?></td>
			<td><?php if(isset($record->plagijatas)) echo round ($record->plagijatas, 2)."% su ID = ".$record->plag_record; ?></td>
			<?php isset($record->status_id) ? displayAcceptDecline($record->stat_name, $record->id) : klaida ?>
		</tr>
		<?php endforeach; ?>
	</table>
	<p class="puslapiavimas"><?php echo $links; ?></p>
	<?php endif; ?>