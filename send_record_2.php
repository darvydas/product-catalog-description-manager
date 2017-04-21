<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-type" content="text/html" charset="utf-8" >
	<link rel="stylesheet" href="http://rude.su.lt/~silkus/katalogas/css/main.css" type="text/css" media="screen" />
	<title>Įrašo siuntimas</title>
	<h1>Įrašo siuntimas</h1>
	<div id="container"><script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
<script type="text/javascript">
//------- vaizduoti kategorijas ----------------
	function showCategories(){
		var jqxhr = $.getJSON("http://rude.su.lt/~silkus/katalogas/index.php/ajax/view_category_list", null, function(data) {	
			var gr = vaidzuotiMedi(data, "");
			$('#medis').html(gr);
		})
		.error(function() { 
		//ka daryt jei nera kategoriju
		})
	}

	function vaidzuotiMedi(medis, rez)
	{
		rez += "<ul>";
		 for (var x in medis)
			{ 
			rez += "<li><a href='#' onclick='showProducts("+medis[x].id+"); return false'>" +medis[x].label+ "</a>" /*+medis[x].parent+ " " +medis[x].sort*/;
			if (medis[x].childs != 'null'){ rez = vaidzuotiMedi(medis[x].childs, rez); }
			rez += "</li>"
			}
		rez += "</ul>";
		return rez;
	}
//--------- vaizduoti prekes --------------------------------
	function showProducts(id){
		$('#product').html('');
		var jqxhr = $.getJSON("http://rude.su.lt/~silkus/katalogas/index.php/ajax/view_select_products/"+id, null, function(data) {	
			$('#product').addItems(data);
		})
		.error(function() { 
		//ka daryt jei nera prekiu
		})
	}
	$.fn.addItems = function(data) {
				return this.each(function() {
					var list = this;
					$.each(data, function(index, itemData) {
						var option = new Option(itemData.name, itemData.id);						
						list.add(option);
					});
				});
			};
	
	
	function bandymas_submitinti(){
	//jei bent vienam lauke bus parasyta NEE tada ateis bus klaida, ktiaip grazins ka submitinai
		$.post(
			"http://rude.su.lt/~silkus/katalogas/index.php/ajax/submit",
			$("#forma").serialize(),
			function(data){
				if(data['status']=="OK"){
					alert("Jusu irasas iterptas (dabar reiketu isvalyti laukus)");
				}
				else{	
					alert("Yra klaidu:");
					for (var x in data){
						alert(data[x]);
					}
				}			
			},
			"json"
		);
	}
</script>

</head>
<body>
<h2>AJAX</h2>



 <form id="forma">
	 <table>
		 <tr>
			<a href="javascript:showCategories()" >Pasirinkite kategoriją</a>
			<div id="medis"></div>
		 <tr>		 
		 <tr>
			<td><label for = "product">Pasirinktite prekę</label></td>
			<td><select name='product' id="product"><option>---</option></select><br/></td>
		 <tr>
			<td>Įveskite aprašymo pavadinimą</td> 
			<td><input type="text" name="record_name"/></td>
		 </tr>
		 <tr>
			<td><input type="hidden" name="link" id="link" value="<?php echo $_SERVER['SCRIPT_URI'] ?>"/></td>
		 </tr>
		 <tr>
			<td>Įveskite aprašymą</td> 
			<td><input type="text" name="content"/></td>
		 </tr>
		 <tr>
			<td><input type="hidden" name="key" id="key" value = "q7wAVoh0DX5Sx4tBM5dY6F2ircp4S6GV"/></td>
		 </tr>
		 <tr>
			<td colspan="2"><input type="button" value="Siūsti" onclick="bandymas_submitinti()"/></td>
			<?php // print_r($_SERVER); ?>
		 </tr>
	 </table>
</form>
 
 
 
<strong>Katalogas &copy; 2012</strong>	
</body>
</html>
<?php /*
{"1":{"id":"1","label":" Home","parent":"0","sort":"0","childs":null},
"2":{"id":"2","label":"Code","parent":"0","sort":"0","childs":{
	"4":{"id":"4","label":" PHP","parent":"2","sort":"0","childs":{
		"7":{"id":"7","label":" Help","parent":"4","sort":"1","childs":null},
		"6":{"id":"6","label":" Scripts","parent":"4","sort":"2","childs":{
			"8":{"id":"8","label":" Archive","parent":"6","sort":"0","childs":{
				"9":{"id":"9","label":" Snippet","parent":"8","sort":"0","childs":null}
			}}
		}}
	}},
	"5":{"id":"5","label":" CSS","parent":"2","sort":"0","childs":null}
}},
"3":{"id":"3","label":" Contact","parent":"0","sort":"0","childs":null}} */?>