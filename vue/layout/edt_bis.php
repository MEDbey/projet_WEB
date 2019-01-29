<!doctype html>
<html lang="fr">
<!-- HEADER -->

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Application - Emploi du temps</title>
	<link rel="stylesheet" type="text/css" href="./vue/styleCSS/style.css" />
	<link rel="stylesheet" type="text/css" href="./vue/styleCSS/bootstrap.css" />
	<link rel="stylesheet" type="text/css" href="./vue/styleCSS/normalize.css" />
	<script src="./vue/scripts/jquery-3.3.1.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	<script src="./vue/scripts/bootstrap.js"></script>
</head>
<!-- BODY -->

<body>
    
	<div class="row">
		<div class="col-md-6 offset-md-2">
			<div class="row">
				<div class="zone col-md-6" id="btns">
                <div class='draggable'> test </div>
					<button class="btn btn-info" id="ajout_creneau">Ajouter un créneau</button>
					<button id="mymodal" class="btn btn-info" data-toggle="modal" data-target="#myModal">Créer un module</button>
					<button class="btn btn-info" id="create_matiere">Créer une matiére</button>
				</div>
				<div class="col-md-4">
					<div class="form-group row">
						<div class="col-md-12" style="display:none;" id="select_form">
							<label for="sel1">Select Module:</label>
							<select class="form-control" id="select_module" style="display:none;">
								<option>Module</option>
							</select>
							<label for="sel1" style="display:none;" id="label_matiere">Select Matiere:</label>
							<select class="form-control" id="select_matiere" style="display:none;">
								<option>Matiere</option>
							</select>

							<label for="sel1" style="display:none;" id="label_prof">Select Prof:</label>
							<select class="form-control" id="select_prof" style="display:none;">
								<option>Prof</option>
							</select>
							<input id='stock_prof' hidden/>
							<label for="sel1" style="display:none;" id="label_periode">Select Période:</label>
							<select class="form-control" id="select_periode" style="display:none;">
								<option>Période</option>
							</select>
							<button class="btn btn-success" id="validate" style="display:none;">Valider</button>
							<button class="btn btn-info" id="reload_page" style="display:none;" hidden>Ajouter une nouvelle matière</button>
						</div>
					</div>
				</div>
				<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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

                    <div class="modal fade" id="modalAjoutCreneau" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
					<div class="modal-dialog" role="document">
					  	<div class="modal-content">
							<div class="modal-header">
								<h5 id="myModalLabel">Ajouter un Créneau</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</div>
							<div class="modal-body">
							<form action="" method="post">
							    nombre d'heure : <input type='number' id='bn_heure' class='form-control'/>
								<div class="modal-footer">
								<button type="button" class="btn btn-default" data-dismiss="modal">Annuler</button>
								<input type="submit" class="btn btn-primary"/>
								</div>
							</form>
							</div>
							
					 	</div>
					</div>
				</div>
			</div>
			<div class="zone" id="edt">
				<div class="row" id="H">
					<div class="cellules titre silver" id="titre">
						<p class="barre"></p>
						<p class="hautD">période</p>
						<p class="basG">modules</p>
					</div>
				</div>
				<div class="row cptV" id="total_periode">
					<div class="cellules silver" id="titre_total_periode">
						<p><b>Total par Période</b></p>
					</div>
				</div>
			</div>
		</div>
	</div>
    <div class="dropmomo supri"> momo</div>
	<script>
		$(document).ready(function(){

       
            var baseurl = window.location.origin + window.location.pathname;
            if (baseurl.charAt(baseurl.length - 1) == "/") {
                baseurl = baseurl.slice(0, -1);
            }

            /*
        * Handler sur click sur le bouton "Générer EDT"
        */
            var nb_col = 0;
            //Récupération des périodes
            $.get(baseurl + "?controle=PeriodeController&action=index", function(data, status) {
                var object = JSON.parse(data);
                var cpt = object.length;
                nb_col = cpt + 1;
                var id_tot = cpt + 1;
                //Insertion de la colonne des totaux par module
                $('<div class="cellules total silver" id=titretotm-' + (cpt + 1) + '><p><b>Total par Module</b></p></div>').insertAfter($('#titre'));
                for (var o in object) {
                    var item = object[o];
                    $('<div class="cellules titre lime" id=' + cpt + '>' + item.periode + ' (' + item.diff + ' sem)</div>').insertAfter($('#titre'))
                    //Insertion de la ligne pour les totaux par période
                    $('<div class="cellules total silver text-center" id=tot-' + cpt + '>0</div>').insertAfter($('#titre_total_periode'))
                    cpt = cpt - 1;
                }
            })
            //Récupération des modules
            $.get(baseurl + "?controle=ModuleController&action=index", function(data, status) {
                var object = JSON.parse(data);
                for (var o in object) {
                    var item = object[o];
                    //Insertion des modules dans le tableau
                    $('<div class="row edt" id= row' + item.id + '>' +'<div class="cellules cell_clickable titre droppable silver" id=' + item.id + '>' + item.nom + '</div>').insertAfter($('#H'));
                    //Insertion de la colonne des totaux par module
                    for (var i = 1; i < nb_col; i++) {
                        $('#row' + item.id).append('<div class="cellules titre droppable silver" id=' + item.id + '-' + i + '></div>');
                    }
                    $('#row' + item.id).append('<div class="cellules total silver text-center" id=totm-' + item.id + ' >0</div>');
                }
                ////////////////////////////////////////
               ///génération des modules et matières///
              ////////////////////////////////////////
                $('.cell_clickable').click(function(){
                    var id_module_cell = $(this).attr('id');
                    $.get(baseurl + "?controle=MatiereController&action=showByModule&id=" + id_module_cell, function(data, status) {
                        var object = JSON.parse(data);
                        for (var o in object) {
                            var item = object[o];
                            $('<div class="row edt" id= "row' + item.id + '_matiere">' + '<div class="cellules cellule_matiere_' + item.id + ' titre droppable " id=' + item.id + '>' + item.nom + '</div>').insertAfter($('#row' +id_module_cell));
                            for (var i = 1; i < nb_col; i++) {
                                $('#row' + item.id + '_matiere').append('<div class="cellules cell_mat cellule_matiere_' + item.id + ' titre droppable" id=' + item.id + '-' + i + '></div>');
                            }
                            $('#row' + item.id + '_matiere').append('<div class="cellules silver total text-center" id=totm-'+id_module_cell+'-'+item.id + '>0</div>');
                            // alert(item.couleur);
                            // $('.cellule_matiere_' + item.id).css('background-color' , item.couleur);
                            $('.cellule_matiere_' + item.id).on('click',function(){
                                $(this).html('<div class=" container_nb_heure container_heure_'+ item.id +' drag" style="background-color:'+item.couleur+'; width:100px; height:25px;">'+item.nbHeure+'</div>');
                                $('.cell_mat').droppable();
                                $('.drag').draggable({
                                    drop : function( event, ui){
                                        //ui.draggable.appendTo($(this));
                                        // console.log();
                                        // console.log($(this));
                                        // event.target.append(ui.draggable element)
                                        // (this).append(element);
                                       // $
                                    }
                                });
                                var cpt_tot_m = 0;
                                cpt_tot_m = item.nbHeure ;
                                $('#totm-'+id_module_cell+'-'+item.id).html(cpt_tot_m);
                                $('.supri').droppable({
                                    drop : function( event, ui){
                                        console.log();              ////////////MOMOMOMO
                                        console.log($(this));
                                        console.log(event.target);
                                       // $(this).append(element);
                                       ui.draggable.remove();
                                    }
                                });
                            });
                        }
                    });
                });
                $('.cell_clickable').trigger('click');
            });
        
        

        $('#ajout_creneau').on('click', function(){
            $('#select_form').css("display", "block");
            $("#select_module").css("display", "block");
        });
        $('#select_module').change(function() {
            var id = $(this).children(":selected").attr("id");
            $.get(baseurl + "?controle=MatiereController&action=showByModule&id=" + id, function(data, status) {
                var object = JSON.parse(data);
                $('#label_matiere').css("display", "block");
                $("#select_matiere").css("display", "block");
                for (var o in object) {
                    var item = object[o];
                    $('#select_matiere').append('<option id=' + item.id + '>' + item.nom + '</option>');
                }
                $('#select_module').prop('disabled', 'disabled');
            });
        });

        /*
        * Handler du select matiere
        */
        $('#select_matiere').change(function() {
            //Récupération des périodes
            $.get(baseurl + "?controle=ProfController&action=showProf", function(data, status) {
                var object = JSON.parse(data);
                $('#label_prof').css("display", "block");
                $("#select_prof").css("display", "block");
                for (var o in object) {
                    var item = object[o];
                    $('#select_prof').append('<option id=' + item.id + '>' + item.nom + '</option>');
                }
                $('#select_matiere').prop('disabled', 'disabled');
                $('#select_prof').removeAttr('disabled');
            });
        });

        /*
        * Handler du select prof
        */
        $('#select_prof').change(function() {
            $('#stock_prof').val('' + $('#select_prof').find(":selected").text() + '');
            
            //Récupération des périodes
            $.get(baseurl + "?controle=PeriodeController&action=index", function(data, status) {
                var object = JSON.parse(data);
                $('#label_periode').css("display", "block");
                $("#select_periode").css("display", "block");
                for (var o in object) {
                    var item = object[o];
                    $('#select_periode').append('<option id=' + item.id + '>' + item.periode + '(' + item.diff + 'sem)</option>');
                }
                $('#select_prof').prop('disabled', 'disabled');
                $('#select_periode').removeAttr('disabled');
            });
        });

        /*
        * Handler du select periode
        */
        $('#select_periode').change(function() {
            $('#select_periode').prop('disabled', 'disabled');
            $("#validate").css("display", "block");

        });
        $('#edt').on('click', '.para', function() {
            let id_matiere = $(this).attr('id').split('-')[1];
            let parent = $(this).parent().closest('div').attr('id');
            alert(parent);
            $.get(baseurl + "?controle=MatiereController&action=show&id=" + id_matiere, function(data, status) {
                var item = JSON.parse(data);
                let nbheure = item.nbHeure;
                minusTotalM(parent.split('-')[0], nbheure);
                minusTotal(parent.split('-')[1], nbheure);
            });
            $(this).remove();
        });
        /*
        * Handler sur bouton de validation
        */
        $('#validate').click(function() {
            id_module = $('#select_module').children(":selected").attr("id");
            id_matiere = $('#select_matiere').children(":selected").attr("id");
            id_periode = $('#select_periode').children(":selected").attr("id");
            $.get(baseurl + "?controle=MatiereController&action=show&id=" + id_matiere, function(data, status) {
                var item = JSON.parse(data);
                var nom_prof = $('#stock_prof').val();
                

                /*
                * Cette partie est assez compliqué j'ai donc mit un fichier .txt pour expliquer mon algorithme.
                */

                    //Si on veut ajouter à la première case
                    if (id_periode == 1) {
                        //Si la div est vide mais existe
                        if ($('#' + id_module + '-' + id_periode).is(':empty')) {
                            $('#' + id_module + '-' + id_periode).html('<p id="matiere">'+item.label+' ' + nom_prof + '</p>');
                            calculateTotal(id_periode,item.nbHeure);
                            calculateTotalM(id_module,item.nbHeure);
                        }
                        //La div existe mais n'est pas vide, on doit donc concaténer le texte
                        else if ($('#' + id_module + '-' + id_periode).length) {
                            var old_text = $('#' + id_module + '-' + id_periode).html();
                            $('#' + id_module + '-' + id_periode).html(old_text + '<p id="matiere">'+item.label+' ' + nom_prof + '</p>');
                            calculateTotal(id_periode,item.nbHeure);
                            calculateTotalM(id_module,item.nbHeure);
                        }
                        //La div n'existe pas, on doit donc la créer				
                        else {
                            $('#row' + id_module).append('<div class="cellules titre droppable silver" id=' + id_module + '-' + id_periode + '>' +'<p id="matiere">'+item.label + ' ' + nom_prof + '</p></div>');
                            calculateTotal(id_periode,item.nbHeure);
                            calculateTotalM(id_module,item.nbHeure);
                        }
                    }
                    else {
                        for (var i = 1; i < id_periode; i++) {
                            //Si la div n'existe pas on la créer 
                            if ($('#' + id_module + '-' + i).length == 0) {
                                $('#row' + id_module).append('<div class="cellules titre droppable silver" id=' + id_module + '-' + i + '></div>');
                            }
                        }
                        //Si la div est vide mais existe
                        if ($('#' + id_module + '-' + i).is(':empty')) {
                            $('#' + id_module + '-' + id_periode).html('<p id="matiere">'+item.label+' ' + nom_prof + '</p>');
                            calculateTotal(id_periode,item.nbHeure);
                            calculateTotalM(id_module,item.nbHeure);
                        }
                        //La div existe mais n'est pas vide on doit donc concaténer le texte
                        else if ($('#' + id_module + '-' + id_periode).length) {
                            var old_text = $('#' + id_module + '-' + id_periode).html();
                            $('#' + id_module + '-' + id_periode).html(old_text + '<p id="matiere">'+item.label+' ' + nom_prof + '</p>');
                            calculateTotal(id_periode,item.nbHeure);
                            calculateTotalM(id_module,item.nbHeure);
                        }
                        //La div n'existe pas on doit donc créer la div
                        else {
                            $('#row' + id_module).append('<div class="cellules titre droppable silver" id=' + id_module + '-' + id_periode + '>' + '<p id="matiere">'+item.label +' ' + nom_prof + '</p>'+ '</div>');
                            calculateTotal(id_periode,item.nbHeure);
                            calculateTotalM(id_module,item.nbHeure);
                        }
                    }
                });
                /* ajout prof au planning*/
                
                $(this).css("display", "none");
                $("#reload_page").click();
            });
            /*
            * Handler du bouton d'ajout d'une nouvelle matière
            */
            $('#reload_page').click(function () {
                $('#label_matiere').css("display", "none");
                $('#select_matiere').removeAttr('disabled');
                $("#select_matiere").css("display", "none");
                $('#select_matiere').children('option:not(:first)').remove();
                $('#select_matiere option:contains("Matiere")').prop('selected', true);

                $('#label_prof').css("display", "none");
                $('#select_prof').css("display", "none");
                $('#select_prof').children('option:not(:first)').remove();

                $('#label_periode').css("display", "none");
                $('#select_periode').css("display", "none");
                $('#select_periode').children('option:not(:first)').remove();
                
                $(this).css("display", "none");
                $('#select_module').removeAttr('disabled');
                $('#select_module option:contains("Module")').prop('selected', true);
            });
            /*
            * Fonction permettant de mettre à jour le contenu du total correspondant à la période sélectionné
            */
            function calculateTotal(id_periode, nbHeure){
                var old_total  = $('#tot-'+id_periode).html();
                var old_total_int = parseInt(old_total);
                nbHeure = parseInt(nbHeure);
                var new_total = old_total_int + nbHeure;
                $('#tot-'+id_periode).empty();
                $('#tot-'+id_periode).html(new_total);
            }


     

            /*
            * Fonction permettant de mettre à jour le contenu du total correspondant au module sélectionné
            */
            function calculateTotalM(id_module,nbHeure){
                var old_total  = $('#totm-'+id_module).html();
                var old_total_int = parseInt(old_total);
                nbHeure = parseInt(nbHeure);
                var new_total = old_total_int + nbHeure;
                $('#totm-'+id_module).empty();
                $('#totm-'+id_module).html(new_total);
            }
            function getInfo(id_div){
                $(id_div).find('p').click(function(){
                    var label = $('p').text();
                    alert(label);
                    // $.get(baseurl + '?controle=MatiereController&action=showByLabel&id="'+label+'"', function (data, status) {
                    // 	var obj = JSON.parse(data);
                    // 	alert("Nom complet: "+obj.nom);
                    // });
                })
            }

        })
	</script>
</body>

</html>