@extends('parametres.3.rhsds.index')

@section('css')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script> --}}
@endsection

@section('chart_div')
    {{-- @can('view-chart-js')
        <div id="data_view" class="card mg-b-20 text-center">
            <div class="card-header">
                <h3>@lang('parametre.vue graphique')</h3>
            </div>
            <div class="card-body">
                @if($rh_v->count() > 0)
                <div class="card-title">Réalisations de votre {{Auth::user()->domaine->type}}</div>
                <div class="container mb-5">
                    <div class="row justify-content-center">
                        @foreach($rh_v as $rh)
                            <div class="col-4-md mb-2">
                                <canvas width="400px" height="250px" id="donut_{{$loop->iteration}}" class="donut-pie"></canvas>
                            </div>
                        @endforeach
                    </div>
                </div>
                @else
                    <div class="text-muted">@lang('rhsd.no valid data')</div>
                @endif
            </div>
                @unless($rh_sum->count() > 0)
                    <div class="card-footer ">
                        <div class="card-text">@lang('parametre.moyenne')</div>
                        <div class="row justify-content-center">
                            @foreach($rh_sum as $rh_year)
                                <div id="canvasDiv" class="col-4-md mb-2">
                            <!-- THIS EFD UP sizes !! -->
                                    <canvas width="400px" height="250px" id="donut_sum_{{$loop->iteration}}" class="donut-pie mb-5"></canvas>
                                    <h4>{{$rh_year->first()->ANNEE}}</h4>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endunless
            
            <div class="row justify-content-center">
                    <div class="col-4-md mb-2" id="canvasDiv2">
                        <!-- <canvas width="400px" height="250px" id="donut_{{$loop->iteration}}" class="donut-pie"></canvas> -->
                    </div>
            </div>
        </div>
    @endcan --}}
@endsection

@section('chart_script')
    {{-- <!-- charts -->
        @can('view-province')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded',function(event) {
                var rh_v = {!! json_encode($rh_v) !!};
                var sum = {!! json_encode($sum)!!};
                if(rh_v.length > 0){
                    for (i = 0; i < rh_v.length ; i++) {
                        var real=0, obj=0;
                        var title = rh_v[i].qualite.qualite;
                        real = rh_v[i].REALISATION;
                        obj = rh_v[i].OBJECTIF
                        var ecart = real - obj;
                        if(ecart < 0) {
                            var xvals = ["Ecart", "Realisation"];
                            var yvals = [ecart, rh_v[i].REALISATION];
                            var cols = ["#EA3232", "#2b5797"];
                        } else{
                            var xvals = ["Objectif", "Ecart"];
                            var yvals = [rh_v[i].OBJECTIF, ecart*-1];
                            var cols = ["#2b5797", "#32EA8E"];
                        }
                        
                        new Chart(document.getElementById("donut_"+[(i+1)]), {
                            type: "doughnut",
                            data:{
                                labels: xvals,
                                datasets: [{
                                    backgroundColor: cols,
                                    data: yvals
                                }]
                            },
                            options:{
                                title:{
                                    display: true,
                                    text: title
                                }
                            }
                        });
                    }
                    if(sum[0].length == sum[1].length && sum[1].length > 0){ //sum[0]:REAL,sum[1]:OBJ
                        var length = sum[0].length;
                        for(j=0; j<length; j++){
                            var percent = ((sum[0][j]/sum[1][j])*100).toFixed(2)
                            title = ''+percent+'%';
                            if(sum[0][j] < sum[1][j]) {
                                var xvals = ["Ecart", "Realisation"];
                                var ecart = sum[0][j]- sum[1][j];
                                var yvals = [ecart, sum[0][j]];
                                var cols = ["#EA3232", "#2b5797"];
                            } else{
                                var xvals = ["Objectif", "Ecart"];
                                var ecart = sum[1][j] - sum[0][j];
                                var yvals = [sum[1][j], ecart*-1];
                                var cols = ["#2b5797", "#32EA8E"];
                            }
                            new Chart(document.getElementById("donut_sum_"+[(j+1)]), {
                                type: "pie",
                                data:{
                                    labels: xvals,
                                    datasets: [{
                                        backgroundColor: cols,
                                        data: yvals
                                    }]
                                },
                                options:{
                                    title: {
                                        display: true,
                                        text: title
                                    }
                                }
                            }); 
                        }
                    }
                } else{
                    var container = document.getElementById("data_view");
                    container.hide();
                }
            });
            
        </script>
        @endcan
        {{-- ,'view-select' --}}
        {{-- @can('view-region')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded',function(event) {
                var rh_v = {!! json_encode($rh_v) !!};
                var rh_sum = {!! json_encode($rh_sum) !!};
                var testtest = {!! json_encode($testtest) !!};
                console.log(testtest);
                for(year in testtest){
                    console.log('YEAR IN TESTTEST: '+year)
                    var annee = testtest[year]
                    $('#canvasDiv2').append("<div ><h3>"+year+"</h3>");
                    for(domaine in annee){
                        $('#canvasDiv2').append("<div ><h4>"+domaine+"</h4>");
                        console.log('DOMAINE:'+domaine)
                        var domaine = annee[domaine]
                            for(realisations in domaine){
                                $('#canvasDiv2').append("<div >");
                                var qualite = domaine[realisations].id_qualite 
                                var realisation = domaine[realisations].REALISATION
                                var objectif = domaine[realisations].OBJECTIF   
                                console.log(domaine[realisations].id_qualite)
                                console.log(domaine[realisations].REALISATION)
                                console.log(domaine[realisations].OBJECTIF)

                                $('#canvasDiv2').append("<ul>");
                                $('#canvasDiv2').append("<li>"+qualite+"</li>");
                                $('#canvasDiv2').append("<li>"+realisation+"</li>");
                                $('#canvasDiv2').append("<li>"+objectif+"</li>");
                                $('#canvasDiv2').append("</ul>");
                                $('#canvasDiv2').append("</div>");
                            }
                        $('#canvasDiv2').append("</div>");
                    }
                    $('#canvasDiv2').append("</div>");
                }
                var sum = {!! json_encode($sum)!!};
                var t, d, domaine, id;
                if(rh_v.length > 0){
                    for (i = 0; i < rh_v.length ; i++) {
                        t = (rh_v[i].domaine.t).toString();
                        d = (rh_v[i].domaine.domaine).toString()
                        id = (rh_v[i].domaine.id).toString()

                        // $('#canvasDiv2').append("<div><p>"+t+"-"+d+"</p></div>");
                    }
                }
                if(rh_v.length > 0){
                    for (i = 0; i < rh_v.length ; i++) {
                        var real=0, obj=0;
                        var title = rh_v[i].qualite.qualite;
                        real = rh_v[i].REALISATION;
                        obj = rh_v[i].OBJECTIF
                        var ecart = real - obj;
                        if(ecart < 0) {
                            var xvals = ["Ecart", "Réalisation"];
                            var yvals = [ecart, rh_v[i].REALISATION];
                            var cols = ["#EA3232", "#2b5797"];
                        } else{
                            var xvals = ["Objectif", "Ecart"];
                            var yvals = [rh_v[i].OBJECTIF, ecart*-1];
                            var cols = ["#2b5797", "#32EA8E"];
                        }
                        
                        new Chart(document.getElementById("donut_"+[(i+1)]), {
                            type: "doughnut",
                            data:{
                                labels: xvals,
                                datasets: [{
                                    backgroundColor: cols,
                                    data: yvals
                                }]
                            },
                            options:{
                                title:{
                                    display: true,
                                    text: title
                                }
                            }
                        });
                    }
                    if(sum[0].length == sum[1].length && sum[1].length > 0){ //sum[0]:REAL,sum[1]:OBJ
                        var length = sum[0].length;
                        for(j=0; j<length; j++){
                            var percent = ((sum[0][j]/sum[1][j])*100).toFixed(2)
                            title = ''+percent+'%';
                            if(sum[0][j] < sum[1][j]) {
                                var xvals = ["Ecart", "Réalisation"];
                                var ecart = sum[0][j]- sum[1][j];
                                var yvals = [ecart, sum[0][j]];
                                var cols = ["#EA3232", "#2b5797"];
                            } else{
                                var xvals = ["Objectif", "Ecart"];
                                var ecart = sum[1][j] - sum[0][j];
                                var yvals = [sum[1][j], ecart*-1];
                                var cols = ["#2b5797", "#32EA8E"];
                            }
                            new Chart(document.getElementById("donut_sum_"+[(j+1)]), {
                                type: "pie",
                                data:{
                                    labels: xvals,
                                    datasets: [{
                                        backgroundColor: cols,
                                        data: yvals
                                    }]
                                },
                                options:{
                                    title: {
                                        display: true,
                                        text: title
                                    }
                                }
                            }); 
                        }
                    }
                } else{
                    var container = document.getElementById("data_view");
                    container.hide();
                }
            });
            
            </script>
        @endcan
    <!-- end charts --> --}}
@endsection