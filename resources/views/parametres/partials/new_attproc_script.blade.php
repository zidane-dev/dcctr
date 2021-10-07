<script type="text/javascript">
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        var secteurSel = $('#secDiv');
        var attribSel = $('#attDiv');
        var actionSel = $('#actDiv');
        attribSel.hide();
        actionSel.hide();
        $('#selectSecteur').on('change', function(e){
            var secteur_id = e.target.value;
            $.ajax({
                url:"{{route('subSec')}}",
                type: "GET",
                data:{
                    secteur_id: secteur_id,
                },
                success : function(data){
                    attribSel.show();
                    actionSel.show();

                    $('select[name="attribution"]').empty();
                    var id, type, nom;
                    for(var i = 0; i<data['attributions'].length; i++){
                        if(i==0){
                            $('#selectAttribution').append('<option value="" selected disabled>{{ trans("att_procs.choix-attribution") }}</option>');
                        }
                        id = data["attributions"][i]['id'];
                        
                        if(data["locale"] == "ar"){
                            nom = data["attributions"][i]['attribution_ar'];
                        }else{
                            nom = data["attributions"][i]['attribution_fr'];
                        }
                        $('#selectAttribution').append('<option value="'+ id +'">'+ nom +'</option>');
                    }
                }
            });
        });
    });
</script>