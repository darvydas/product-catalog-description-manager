<script type="text/javascript">
<!--
window.onload=function() {
	showProductsByCategory(<?php echo isset($rec->product_id)?$rec->product_id:1; ?>);

	/*var myselect=document.getElementById("produktai")
	for (var i=0; i<myselect.options.length; i++){
		if (myselect.options[i].value == product_id){
			myselect.options[i].selected==true
			alert("Selected Option's index: "+i)
			break
		}
	}*/
 }
//-->
</script>

<h2 class="pageH2"><?php echo $heading ?>:</h2>
	<?php echo validation_errors();?>
	<?php 
	switch ($controler) {
		case "category":
		if($rec->id > 0) {echo form_open('category/edit/'.$rec_kat.'/'.$rec_prod.'/'.$rec->id);} else { echo form_open('category/create/'.$rec_kat.'/'.$rec_prod);}
		break;
		
		case "confirm":
		if($rec->id > 0) {echo form_open('confirm/edit/'.$rec_kat.'/'.$rec_prod.'/'.$rec->id);} else { echo form_open('confirm/create/'.$rec_kat.'/'.$rec_prod);}
		break;
	} ?>

	<table>
		<tr>
			<td><label for="record_name"><strong>Įrašo pavadinimas:</strong></label></td>
			<td><?php 
					if($this->input->post('record_name') == '') {
						$record_name = array('type' => 'text', 'name' => 'record_name', 'size' => '100', 'value' => $rec->name); 
					}else {$record_name = array('type' => 'text', 'name' => 'record_name', 'size' => '100', 'value' => set_value('record_name'));}
					echo form_input($record_name); ?>
			</td> 
		</tr>
		<tr>
			<td><label for="link"><strong>Įrašo nuoroda:</strong></label></td>			
			<td><?php 
				if($this->input->post('link') == '') {
					$link = array('type' => 'text', 'name' => 'link', 'size' => '100', 'value' => $rec->link);
				}else {$link = array('type' => 'text', 
									'name' => 'link', 
									'size' => '100', 
									'value' => set_value('link'));}
				echo form_input($link); ?>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<?php 
				if($this->input->post('content') == '') {
					$content = array('id' => 'content', 'name' => 'content', 'value' => $rec->content);
				}else {$content = array(
										'id' => 'content', 
									  'name' => 'content', 
									 'value' => set_value('content'));}
				echo form_textarea($content); ?>
			</td>
		</tr>
		<tr>
			<td><label for="categorija"><strong>Kategorija:</strong></label></td>
			<td>
			<?php
			/*print_r($rec_kat);
			echo "<br/>";
			print_r($rec_prod);*/
//print_r($rec);			
			?>
			<select name='categorija' id='categorija' onchange='showProductsByCategory()'>
			<?php 	if(isset($meniu2)){	select_category($meniu2, $rec_kat, "");	}?>
			</select>
			</td>
		</tr>
		<tr>
			<td><label for="product"><strong>Prekė:</strong></label></td>
			<?php //reikia kintamojo javascriptui kad pazymetu esama producta
			if(isset($rec->product_id)) echo "<input type='hidden' id = 'product_id' value = '$rec->product_id' onload='showProductsByCategory(".$rec_prod.", ".$rec_kat.")'>"; ?>
			<td><select name='product' id="produktai"><option>---</option></select></td>
		</tr>
		<?php if($rec->author != "") :?> 				
			<tr>
				<td><label><strong>Autorius:</strong></label></td>
				<td><label><?php echo $rec->author; ?></label></td>
			</tr>
		<?php endif; ?>
		<?php if($rec->status_id > 0) :?> 	
			<tr>
				<td><label><strong>Statusas:</strong></label></td>
				<td><label><?php echo $rec->stat_name; ?></label></td>
			</tr>
		<?php endif; ?>
		<tr>
			<td colspan="2"><input type="submit" name="submit" 
			<?php 
			if (($rec->stat_name == "accepted") || ($rec->id == 0)) {echo 'value="Kurti"';} else{echo 'value="Redaguoti"';} 
			?>/>
			</td>
		</tr>
	</table>
	<?php echo form_close(); ?>
</form>
<?php echo display_ckeditor(); ?>
<?php 	
	function select_category($mas, $sel = 0, $space=""){
		if(!empty($mas)){	
			foreach($mas as $ob){
				if(($ob->kiek_p >= 1 && $ob->kateg != NULL) || isset($ob->childs)){
					echo "<option  value ='".$ob->pgs_id."'";
					if($ob->pgs_id == $sel) { echo " selected='selected'";}
					if($ob->kateg == NULL){
						echo " disabled='disabled'";
					}
					echo ">".$space.$ob->label."</option>";
					if(isset($ob->childs)){
						select_category($ob->childs, $sel, $space."&nbsp;");
					}
				}
			}
		}
	}
?>