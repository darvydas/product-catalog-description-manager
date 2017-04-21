	<h2 class="pageH2">Įrašo peržiūra: <span><?php echo $heading?></span></h2>
	<div class ="path"> 
		<?php echo anchor($controler, 'Titulinis'); ?> >
		<?php if (isset($categ)) echo anchor($controler.'/view/'.$categ->pgs_id, $categ->label); ?> >
		<?php if (isset($produc_id)) echo anchor($controler.'/view_records/'.$produc_id, $produc_name); ?> > 
		<?php if (isset($produc_id)) echo anchor($controler.'/record_view/'.$categ->pgs_id.'/'.$produc_id.'/'.$record->id, $record->name); ?>
	</div>
		<?php if(isset($record)) { ?>
		<table class="record_view">
			<tr><td width="150">Įrašo pavadinimas:</td><td><?php echo $record->name; ?></td>
			<tr><td >Įrašo nuoroda:</td><td><?php echo $record->link; ?></td>
			<tr><td >Įrašo turinys:</td>
			<tr><td colspan="2"><p><?php echo $record->content; ?></p></td>
			<tr><td>Įrašo kelias:</td><td><?php echo $record->categories_name . ' > ' . $record->prod_name; ?></td>
			<tr><td>Įrašo busena:</td><td><?php echo $record->stat_name; ?></td>
			<tr><td>Įrašo kurėjas:</td><td><?php echo $record->author; ?></td>
		</table>
		<?php }else { echo "Įvyko klaida.";} ?>