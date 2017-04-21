<script type="text/javascript">
    function confirmDelete(id)
    {
        var link = document.getElementById(id);
        if(confirm("Ar tikrai norite šalinti šį vartotoją?"))
            return true;
        else
            return false;
    }
	function vardasSearch(){
		var laukas = $("#l_s").val();
		var kryptis = $("#l_k").val();
		var vardas = $("#l_f").val();
		window.location.href = "http://rude.su.lt/~silkus/katalogas/index.php/users/index/0/"+laukas+"/"+kryptis+"/"+filtras;
		//http://rude.su.lt/~silkus/katalogas/index.php/category/index/20/author/desc/321%20asd
	}
</script>
<div class="wrapper">
  <section id="content">
	<h2 class="pageH2">Vartotojų <span>sąrašas:</span></h1>
		<!--div class="sort-filter">
			Rikiuoti pagal <select id="l_s" name="laukas">
				<option value="user_id">Vartotojo ID</option>
				<option value="name">Vartotojo vardą</option>
				<option value="point">Taškus</option>
				<option value="activ">Aktyvumą</option>
			</select>   
			<select id="l_k" name="kryptis">
				<option value="asc">Didėjimo tvarka</option>
				<option value="desc">Mažėjimo tvarka</option>
			</select></br>
			Ieškoti vartotojo: <input id="l_f" type="text" name="vardas"/></br>
			<input type="button" id="l_m" value="Ieškoti" onclick="vardasSearch()"/>
		</div-->
		<?php echo anchor("users/create", "Kuri naują vartotoją"); ?>
		<?php if(isset($users)) : ?>
		<table class="users_list">
			<tr class="headers"><th>ID</th><th>Vartotojo vardas</th><th>Patikimumo taskai</th><th>Aktyvus</th><th>Redagavimas</th><th>Šalinimas</th></tr>
			<?php foreach($users as $user) : ?>
			<tr class="iraso_eilute">
				<td><?php echo $user->id; ?></td>
				<td><?php echo anchor("users/user_view/".$user->id, $user->login, array('title'=>'Peržiūrėti '.$user->login)); ?></td>
				<td><?php echo $user->trust == NULL ? "---" : $user->trust;?></td>
				<td><?php echo $user->active == 1 ? "taip" : "ne"; ?></td>
				<td><?php echo anchor("users/edit/".$user->id, "redaguoti"); ?></td>
				<td><?php echo anchor("users/delete/".$user->id, "ištrinti", array('id'=>'del_'+$user->id, 'onclick'=>'return confirmDelete(this.id)')); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<p class="puslapiavimas"><?php echo $links; ?></p>
		<?php endif; ?>
  </section>
</div>