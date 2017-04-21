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
			echo anchor("category/edit/".$kategorijos_id."/".$produkto_id."/".$iraso_id, "redaguoti");
			break;
		}		
	}?>
<script type="text/javascript">
    function confirmDelete(id)
    {
        var link = document.getElementById(id);
        if(confirm("Ar tikrai norite šalinti šį vartotoją?"))
            return true;
        else
            return false;
    }
</script>
	<h2 class="pageH2">Vartotojo peržiūra</h2>
		<?php if(isset($usr)) : ?>
		<div id="user">					
			<h3>Vartotojo duomenys:</h3>
			<ul class="contacts">
				<li><strong>Vardas:</strong><?php echo $usr->login; ?></li>
				<li><strong>Taškai:</strong><?php echo $points->trust == NULL ? "---" : $points->trust; ?></li>
				<li><strong>El. paštas:</strong><?php echo $usr->mail; ?></li>
				<li><strong>Būsena:</strong><?php echo $usr->active == 1 ? "aktyvus" : "neaktyvus"; ?></li>
				<li><?php echo anchor("users/edit/".$usr->id, "Redaguoti vartotoją"); ?>
					<?php echo anchor("users/delete/".$usr->id, "Ištrinti vartotoją", array('id'=>'del_'+$usr->id, 'onclick'=>'return confirmDelete(this.id)')); ?></li>
			</ul>			
		</div>
		<?php endif; ?>
		<?php if(isset($usr_rec)) : ?>
		<div id="records">
		<h3>Vartotojo įrašai:</h3>		
			<table class="records">
				<tr class="headers"><th>ID</th><th>Pavadinimas</th><th>Produktas</th><th>Statusas</th><th>Data</th>
									<th>Redagavimas</th><th>Šalinimas</th><th>Siūlyti</th><th>Sutapimas</th></tr>
				<?php foreach($usr_rec as $record) : ?>
				<tr class="iraso_eilute"><td><?php echo $record->id; ?></td>
					<td><?php echo anchor ('confirm/record_view/'.$record->cat_id.'/'.$record->product_id.'/'.$record->id, $record->name); ?></td>
					<td><?php echo $record->prod_name; ?></td><td><?php echo $record->stat_name; ?></td><td><?php echo $record->date?></td>
					<td><?php isset($record->stat_edit) ? displayEdit($record->stat_name, $record->stat_edit, $record->cat_id, $record->product_id, $record->id) : klaida ?></td>
					<td><?php if($record->stat_delete > 0) {echo anchor("category/delete/".$record->id, "trinti", array('id'=>'del_'+$record->id, 'onclick'=>'return confirmDelete(this.id)'));}else {echo "negalima";}?></td>
					<td><?php if($record->stat_name == "draft") echo anchor("category/submit/".$record->id, "pasiūlyti", array('id'=>'del_'+$record->id, 'onclick'=>'return confirmSubmit(this.id)')); else echo 'negalima'; ?></td>
					<td><?php if(isset($record->plagijatas)) echo round ($record->plagijatas, 2)."% su ID = ".$record->plag_record; ?></td>
				</tr>
				<?php endforeach; ?>
			</table>
			<p class="puslapiavimas"><?php // echo $links; ?></p>
		</div>
		<?php endif; ?>