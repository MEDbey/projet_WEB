<script>
    
    var baseurl = window.location.origin + window.location.pathname;
            if (baseurl.charAt(baseurl.length - 1) == "/") {
                baseurl = baseurl.slice(0, -1);
            }
    $.get(baseurl + "?controle=moduleController&action=index", function(data, status) {
        var object = JSON.parse(data);
        for (var o in object) {
            var item = object[o];
            $('#select_module').append('<option id=' + item.id + '>' + item.nom + '</option>');
        }
    });

    $('#select_module').on('change',function(){
        var id = $(this).children(":selected").attr("id");
        $('#label_matiere').css("display", "block");
        $("#nom_matiere").css("display", "block");
        $('#label_label').css("display", "block");
        $("#lab_matiere").css("display", "block");
        $('#form_create_mat').append("<input name='id_mod' value='" + id + "' hidden />");
        var hexa = Math.floor( Math.random() * 0xFFFFFF );
        var result_hexa = "#" + hexa.toString(16);
        $('#form_create_mat').append("<input name='color_mat' value='" + result_hexa + "' hidden />");
    });

    

</script>