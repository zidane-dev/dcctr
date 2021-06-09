document.addEventListener('DOMContentLoaded',function(event) {
    var rh_v = <?php json_encode($rh_v) ?>;
    var sum = {!! json_encode($sum)!!};
    if(rh_v.length > 0){
        for (i = 0; i < rh_v.length ; i++) {
            var title = rh_v[i].qualite.qualite;
            if(rh_v[i].REALISATIONSD < rh_v[i].OBJECTIFSD) {
                var xvals = ["Ecart", "Realisation"];
                var ecart = rh_v[i].OBJECTIFSD - rh_v[i].REALISATIONSD;
                var yvals = [ecart*-1, rh_v[i].REALISATIONSD];
                var cols = ["#EA3232", "#2b5797"];
            } else{
                var xvals = ["Objectif", "Ecart"];
                var ecart = rh_v[i].OBJECTIFSD - rh_v[i].REALISATIONSD;
                var yvals = [rh_v[i].OBJECTIFSD, ecart*-1];
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