<button id="mymodal_module" class="btn btn-info" data-toggle="modal" data-target="#myModal_module">Créer un module</button>
<button id="mymodal_matiere" class="btn btn-info" data-toggle="modal" data-target="#myModal_matiere">Créer une matiére</button>

<div class="modal fade" id="myModal_module" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	<div class="modal-dialog" role="document">
	  	<div class="modal-content">
			<div class="modal-header">
				<h5 id="myModalLabel">Création d'un module</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
			<form action="service/CreateModule.php" method="post">
				Nom du Module : <input type='text' id='nom_module' name='nom_module' class='form-control'/>
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
				<h5 id="myModalLabel">Création d'un module</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
			<form action="service/CreateMatiere.php" method="post">
				Nom du Module : <input type='text' id='nom_module' name='nom_module' class='form-control'/>
				<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
				<input type="submit" class="btn btn-primary"/>
				</div>
			</form>
			</div>
			
	 	</div>
	</div>
</div>