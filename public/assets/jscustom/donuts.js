document.addEventListener('DOMContentLoaded',function(event) {

    var rh_v = $('#myPhpValue').val();
    console.log(rh_v);
    var sumObj=0, sumReal=0;
    if(rh_v.length > 0){
        for (i = 0; i < rh_v.length ; i++) {
            console.log('id '+i+' : '+rh_v[i].id+' ,'+rh_v[i].REALISATIONSD+'/'+rh_v[i].OBJECTIFSD);
            sumObj = sumObj + parseInt(rh_v[i].OBJECTIFSD);
            sumReal = sumReal + parseInt(rh_v[i].REALISATIONSD);
            console.log('Iteration '+i+'REAL: '+sumReal+'OBJ: '+sumObj);
            var title = rh_v[i].qualite.qualite;
            if(rh_v[i].REALISATIONSD < rh_v[i].OBJECTIFSD) {
                var xvals = ["Ecart", "Realisation"];
                var ecart = rh_v[i].OBJECTIFSD - rh_v[i].REALISATIONSD;
                var yvals = [ecart*-1, rh_v[i].REALISATIONSD];
                var cols = ["#EA3232", "#2b5797"];
            } else{
                var xvals = ["Realisation", "Ecart"];
                var ecart = rh_v[i].OBJECTIFSD - rh_v[i].REALISATIONSD;
                var yvals = [rh_v[i].REALISATIONSD, ecart*-1];
                var cols = ["#2b5797", "#32EA8E"];
            }
            
            new Chart(document.getElementById("donut_"+[i+1]), {
                type: "doughnut",
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
        if(sumReal < sumObj) {
            var xvals = ["Ecart", "Realisation"];
            var ecart = sumObj - sumReal;
            var yvals = [ecart*-1, sumReal];
            var cols = ["#EA3232", "#2b5797"];
        } else{
            var xvals = ["Realisation", "Ecart"];
            var ecart = sumObj - sumReal;
            var yvals = [sumReal, ecart*-1];
            var cols = ["#2b5797", "#32EA8E"];
        } 
        title = "Somme"
        new Chart(document.getElementById("donut_sum"), {
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
});