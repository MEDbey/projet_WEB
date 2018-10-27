<html lang="fr">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<title>tableau de draggable-droppable clonable déplaçable</title>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
 
<script src="http://code.jquery.com/jquery-3.2.1.js"></script>
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>

<script type="text/javascript">

var szCell = 120; //largeur des cellule du tableau EDT 

</script>


<link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet"/>

<style>
* {border:0;padding:0;margin:0;}
/*body 	{ padding-top:50px; margin-left:2em}*/
.image-centree { display: block; margin-right: auto; margin-left: auto;  }

.couleur {	border: 4px solid #888; width: 10em; height:5em;
			margin:0;
			display:none;
			/*display:inline-block*/}

.zone {
	margin-bottom : 2em; ; /*border : 0.2em green solid;*/ 
	min-width : 164em; 
	clear:left
}
.row{
	margin:0;
}
.cellules {	border: 4px solid #888; 
			width: 10em; height:5em;
			float:left; 
			padding-top:1em}
	
.pos {display:none} /*  les div internes de position disparaissent*/

.debut {width: 5em; height:2em;}
.titre {font-weight: bold}


	
/*éviter les débordements de texte sur l'EDT*/
#edt {word-wrap: break-word}
/* et pas de débordement de cellules flottantes
   on a content="" sinon l'élément n'est pas généré. */
.cellules:after {
	content: ""; 
	display: table;
	clear: both;
	overflow:hidden;
}

/*première case : haut-gauche EDT*/
p.hautD {  position:relative; z-index:+3; top:-10px; right:-70px}
p.basG {  position:relative; z-index:+2; top:-10px; right:-5px}
p.barre {
  position:relative;
  top:0%; 
  width:100%;
  padding:0;
  margin:0;
  border:0;
  font-size:0;
  opacity:0.4;
}   

/*.container {min-with:300em}*/

.blue {background: blue;}
.red {background: red;}
.yellow {background: yellow;}
.gray {background: gray;}
.orange {background: orange;}
.gray {background: gray;}
.navy {background: navy;}
.purple {background: purple;}
.lime {background: lime;}
.olive {background: olive;}
.teal {background: teal;}
.silver {background: silver;}
.fuchsia {background: fuchsia;}
.aqua {background: aqua;}

</style>

</head>
<body>

<?php include "../includes/function_button.php"?>

<h1 class="text-center">Grille d'EDT modules/périodes</h1>

<div class="zone" id="btns">
<button class="btn" id="edt">sélection d'un edt</button>
<button class="btn" id="matiere">créer une matière dans l'edt</button>
<button class="btn" id="calculer">calculer les heures</button>
<div>

</div>


</div>  <!-- fin zone boutons-->

<div class="zone" id="clrs">
<div class="couleur draggable blue">0000</div>
<div class="couleur draggable red">0001</div>
<div class="couleur draggable yellow">0010</div>
<div class="couleur draggable orange">0011</div>
<div class="couleur draggable navy">0100</div>
<div class="couleur draggable lime">0101</div>
<div class="couleur draggable purple">0110</div>
<div class="couleur draggable teal">0111</div>
<div class="couleur draggable silver">1000</div>
<div class="couleur draggable gray">1011</div>
<div class="couleur draggable fuchsia">1011</div>
<div class="couleur draggable aqua">1011</div>
<div class="couleur draggable olive">1110</div>
</div>  <!-- fin zone de choix des couleurs-->


<div class="zone" id="edt" style='padding : 5% 10%;'>	
	<div class="row"  id="H">
		<div class="cellules titre silver">
				<p class="barre"></p>
				<p class="hautD">période</p> 
				<p class="basG">modules</p>  </div>
		<div class="cellules titre lime">sept-oct (3sem)</div>
		<div class="cellules titre lime">nov-dec (3sem)</div>
		<div class="cellules titre lime">janv-fev (3sem)</div>
		<div class="cellules titre lime">mars (2sem)</div>
		<div class="cellules titre lime">mai(3sem)</div>
		<div class="cellules titre lime">juin-juillet(3sem)</div>
		<div class="cellules total silver">total par module</div>
	</div>
	<div class="row edt">
		<div class="cellules titre draggable blue">
				<p class='mod'>M11</p><p class='pos'>1</p></div>
				<script>
					$(document).ready(function(){
						$('.draggable').draggable({
							connectToSortable: "#sortable",
							helper: "clone",
							revert: "invalid"
						});
					})
				</script>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules total silver"><p class='tot'>-</p></div>
	</div>
	<div class="row edt">
		<div class="cellules titre draggable purple">
				<p class='mod'>M12</p><p class='pos'>2</p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules droppable silver"><p class='pos'></p></div>
		<div class="cellules total silver"><p class='tot'>-</p></div>
	</div>
	<div class="row cptV">
		<div class="cellules silver"><p>total/période</p></div>
		<div class="cellules total silver"><p class='tot'>-</p></div>
		<div class="cellules total silver"><p class='tot'>-</p></div>
		<div class="cellules total silver"><p class='tot'>-</p></div>
		<div class="cellules total silver"><p class='tot'>-</p></div>
		<div class="cellules total silver"><p class='tot'>-</p></div>
		<div class="cellules total silver"><p class='tot'>-</p></div>
		<div class="cellules total silver"><p></p></div>
	</div>
  </div>  <!-- fin zone EDT-->
<?php
	//public function search($object, $criteria)
	//{ 
	//	$this->_object = $object;
	//	$query = $this->_generate_query(ACTION_SEARCH, $criteria);
	//	return $this->_execute_query($query, ACTION_SEARCH);
	//}
	//
	//public function create($object)
	//{
	//	$this->_object = $object;
	//	$query = $this->_generate_query(ACTION_CREATE, null);
	//	return $this->_execute_query($query, ACTION_CREATE);
	//}
	//
	//public function read($object)
	//{
	//	$this->_object = $object;
	//	$query = $this->_generate_query(ACTION_READ, null);
	//	return $this->_execute_query($query, ACTION_READ);
	//}
	//
	//public function update($object)
	//{
	//	$this->_object = $object;
	//	$query = $this->_generate_query(ACTION_UPDATE, null);
	//	$this->_execute_query($query, ACTION_UPDATE);
	//}
	//
	//public function delete($object)
	//{
	//	$this->_object = $object;
	//	$query = $this->_generate_query(ACTION_DELETE, null);
	//	$this->_execute_query($query, ACTION_DELETE);
	//}
	//
?>

</div>  <!-- fin container -->
</body>
</html>