<script type="text/javascript">
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $(document).ready(function(){
        var provinceSel = $('#provDiv');
        var regionSel = $('#regDiv');
        $('#submit').hide();
        provinceSel.hide();
        regionSel.hide();

        $('#type').on('change', function(e){
            var type = e.target.value;
            $('select[name="province"]').empty();
            if(type==1){
                regionSel.show();
                provinceSel.hide();
            }else if(type==2){
                regionSel.hide();
                const element = document.querySelector('#region');
                const change = new Event("change");
                element.value = 13;
                element.dispatchEvent(change);
            }else if(type==0){
                const element = document.querySelector('#selectProvince');
                element.value = null;
                regionSel.hide();
                provinceSel.hide();
                $('#submit').show();
            }
        })
        $('#region').on('change', function(e){
            var cat_id = e.target.value;
            $.ajax({
                url:"{{route('subReg')}}",
                type: "GET",
                data:{
                    region_id: cat_id,
                },
                success : function(data){
                    provinceSel.show();
                    $('select[name="province"]').empty();
                    var id, type, nom;
                    for(var i = 0; i<data['provinces'].length; i++){
                        if(i==0){
                            $('#selectProvince').append('<option value="" selected disabled>No value available</option>');
                        }
                        id = data["provinces"][i]['id'];
                        type = data["provinces"][i]['t'];
                        nom = data["provinces"][i]['name'];
                        $('#selectProvince').append('<option value="'+id+'">'+type+' - '+nom+'</option>');
                    }
                }
            });
        });
        $('#selectProvince').on('change', function(e){
            $('#submit').show();
        })
    });
</script>