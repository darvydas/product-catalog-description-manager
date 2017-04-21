	
		<?php 
		switch ($update_who) {		
			case "grupes":	
				echo '<h2 class="pageH2">Kategorijų <span>sąrašai</span></h2>';
				echo '<h3 class="pageh3">Naujos grupės:</h3><br/>';
				if(isset($naujos_grupes) && !empty($naujos_grupes)) : ?>				
				<table>
					<tr><th>Grupės ID</th><th>Label</th><th>Parent</th></tr>
					<?php foreach($naujos_grupes as $cat) : ?>
					<tr><td><?php echo $cat->pgs_id; ?></td><td><?php echo $cat->name; ?></td>
					<td><?php echo $cat->tev_id; ?></td></tr>
					<?php endforeach; ?>
				</table><br>
				<?php endif;  ?>
				<?php  if(!isset($naujos_grupes) || empty($naujos_grupes)) : ?>
				<p>Nebuvo įterpta nei viena nauja grupė.</p><br>
				<?php endif;  ?>
				
				<h3 class="pageh3">Atnaujintos grupės:</h3><br/>
				<?php  if(isset($atnaujintos_grupes) && !empty($atnaujintos_grupes)) : ?>				
				<table>
					<tr><th>Grupės ID</th><th>Label</th><th>Parent</th></tr>
					<?php foreach($atnaujintos_grupes as $cat) : ?>
					<tr><td><?php echo $cat->pgs_id; ?></td><td><?php echo $cat->name; ?></td>
					<td><?php echo $cat->tev_id; ?></td></tr>
					<?php endforeach; ?>
				</table><br>
				<?php endif;  ?>	
				<?php  if(!isset($atnaujintos_grupes) || empty($atnaujintos_grupes)) : ?>
				<p>Nebuvo atnaujinta nei viena grupė.</p><br>
				<?php endif;  		
			break;
			
			case "prekes":	
				echo '<h2 class="pageH2">Produktų <span>sąrašai</span></h2>';		 
				echo '<h3 class="pageh3">Naujos prekės:</h3><br/>';		 
				if(isset($naujos_prekes) && !empty($naujos_prekes)) : ?>				
				<table>
					<tr><th>Prekės ID</th><th>Name</th><th>Category ID</th><th>Description</th></tr>
					<?php foreach($naujos_prekes as $prod) : ?>
					<tr><td><?php echo $prod->pre_id; ?></td><td><?php echo $prod->name; ?></td>
					<td><?php echo $prod->pgs_id; ?></td><td><?php echo $prod->short_description; ?></td></tr>
					<?php endforeach; ?>
				</table><br>
				<?php endif;  ?>
				<?php  if(!isset($naujos_prekes) || empty($naujos_prekes)) : ?>
				<p>Nebuvo įterpta nei viena nauja prekė.</p><br>
				<?php endif;  ?>		
				
				<h3 class="pageh3">Atnaujintos prekės:</h3><br/>
				<?php  if(isset($atnaujintos_prekes) && !empty($atnaujintos_prekes)) : ?>				
				<table>
					<tr><th>Prekės ID</th><th>Name</th><th>Category ID</th><th>Description</th></tr>
					<?php foreach($atnaujintos_prekes as $prod) : ?>
					<tr><td><?php echo $prod->pre_id; ?></td><td><?php echo $prod->name; ?></td>
					<td><?php echo $prod->pgs_id; ?></td><td><?php echo $prod->short_description; ?></td></tr>
					<?php endforeach; ?>
				</table><br>
				<?php endif;  ?>	
				<?php  if(!isset($atnaujintos_prekes) || empty($atnaujintos_prekes)) : ?>
				<p>Nebuvo atnaujinta nei viena prekė.</p><br>
				<?php endif; 			
			break;
			
			default: ?>
				<p>Duomenys nebuvo gauti.</p><br>
			<?php break;
		} ?>