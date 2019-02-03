<button id="mymodal_module" class="btn btn-info" data-toggle="modal" data-target="#myModal_module">Créer un module</button>
<button id="mymodal_matiere" class="btn btn-info" data-toggle="modal" data-target="#myModal_matiere">Créer une matiére</button>

<div class="modal fade" id="myModal_module" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	  	<div class="modal-content">
			<div class="modal-header">
				<h5 id="myModalLabel_module">Création d'un module</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
			<form action="service/CreateModule.php" method="post">
                Nom du Module : <input type='text' id='nom_module' name='nom_module' placeholder='Nom Module'  class='form-control'/>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
				<input type="submit" class="btn btn-primary"/>
				</div>
			</form>
			</div>
			
	 	</div>
	</div>
</div>

<div class="modal fade" id="myModal_matiere" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	  	<div class="modal-content">
			<div class="modal-header">
				<h5 id="myModalLabel_matiere">Création d'une matière</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
            <form id='form_create_mat' action="service/CreateMatiere.php" method="post">
                <div id="colorSelector"><div style="background-color: #0000ff"></div></div>
                <label for="sel1">Selection du module rataché :</label>
				<select class="form-control" id="select_module">
					<option>Module</option>
				</select>
				<label for="sel1" style="display:none;" id="label_matiere">Nom de la Matière:</label>
                <input type='text' id='nom_matiere' name='nom_matiere' class='form-control' placeholder='Nom Matière' style="display:none;"/>
                <label for="sel1" style="display:none;" id="label_label">Label de la Matière:</label>
				<input type='text' id='lab_matiere' name='lab_matiere' class='form-control' placeholder='Label Matière' style="display:none;"/>
                <br><br><br>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
				<input type="submit" class="btn btn-primary"/>
				</div>
			</form>
			</div>
			
	 	</div>
	</div>
</div>