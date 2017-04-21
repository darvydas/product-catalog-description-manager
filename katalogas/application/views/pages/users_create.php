<h2 class="pageH2"><?php if($usr->id == 0) {echo 'Naujas ';} else { echo 'Redaguojamas ';} ?><span>vartotojas:</span></h2>
	<?php echo validation_errors(); ?>
	<?php if($usr->id > 0) {echo form_open('users/edit/'.$usr->id);} else { echo form_open('users/create');} ?>
	
	<?php echo form_hidden('id', $usr->id); ?>
	<table>
		<tr>
			<td><strong>Vartotojo vardas:</strong></td>
			<td><input type="text" name="login_name" value="<?php echo $usr->login; ?>"/></td>
		</tr>
		<tr>
			<td><strong>Slaptažodis:</strong></td>
			<td><input type="password" name="password" /></td>
		</tr>
		<tr>
			<td><strong>Pakartokite slaptažodį:</strong></td>
			<td><input type="password" name="password2" /></td>
		</tr>
		<tr>
			<td><strong>El. paštas:</strong></td>
			<td><input type="text" name="mail" value="<?php echo $usr->mail; ?>" /></td>
		</tr>
		<?php if ($adm > 1) { echo '<tr>
			<td><strong>Aktyvuoti vartotoją</strong></td>
			<td><input type="checkbox" name="active" value="1"'; if($usr->active) { echo 'checked="checked"';} echo '/></td>
		</tr> ';} ?>		
		<?php if ($adm > 1) { echo '<tr><td><strong>Tipas</strong></td>
			<td><select id="privilege_id" name="privilege_id">
					<option value="0" '; if(isset ($usr->privilege_id) && $usr->privilege_id == 0) echo 'selected="selected"'; echo '>Vartotojas</option>
					<option value="1" '; if(isset ($usr->privilege_id) && $usr->privilege_id == 1) echo 'selected="selected"'; echo '>Valdytojas</option>
					<option value="2" '; if(isset ($usr->privilege_id) && $usr->privilege_id == 2) echo 'selected="selected"'; echo '>Administratorius</option>
				</select></td></tr> ';} ?>
		<tr>
			<td colspan="2"><input type="submit" name="submit" 
			<?php if($usr->id > 0) {echo 'value="Redaguoti"';} else { echo 'value="Kurti"';} ?>	/>
			</td>			
		</tr>
	</table>
	<?php echo form_close(); ?>