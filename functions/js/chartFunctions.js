function DrawChart(canvasID, remoteFields, remoteData, remoteColors, remoteBorderColors) {
	var ctx = document.getElementById(canvasID).getContext('2d');

	var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
		labels: remoteFields,
        datasets: [{
			data: remoteData,
			backgroundColor: remoteColors,
			borderColor: remoteBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
					xAxes: [{
            ticks: {
               callback: function(t) {
                  var maxLabelLength = 25;
                  if (t.length > maxLabelLength) return t.substr(0, maxLabelLength) + '...';
                  else return t;
               }
            }
         }],
            yAxes: [{
                ticks: {
                    beginAtZero:true,
										stepSize: 1
                }
            }]
        },
		responsive: true,
		maintainAspectRatio: false,
		legend: {
        display: false
    },
		tooltips: {
         callbacks: {
            title: function(t, d) {
               return d.labels[t[0].index];
            }
         }
      }
    }
});
}
