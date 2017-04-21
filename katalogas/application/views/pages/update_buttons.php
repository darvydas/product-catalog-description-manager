	<h2 class="pageH2">Kategorijų, produktų ir prekių <span>aprašymų importavimas iš e-shop</span></h2>
	<?php echo form_open('receivers/update_categories'); ?>
	<?php echo form_submit('grupes', 'Atnaujinti kategorijas'); ?>
	<?php echo form_close(); ?>	
	
	<?php echo form_open('receivers/update_products'); ?>
	<?php echo form_submit('prekes', 'Atnaujinti prekes'); ?>
	<?php echo form_close(); ?>