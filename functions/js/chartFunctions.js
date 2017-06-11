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

function DrawComparisonChart(canvasID, remoteFields, remoteData, remoteColors, remoteBorderColors, remoteLabel) {
	var ctx = document.getElementById(canvasID).getContext('2d');

	console.log(remoteData);
	console.log(remoteData[0]);

	var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
		labels: remoteFields,
        datasets: [
				{
					label: remoteLabel["class1"],
					data: remoteData["class1"],
					backgroundColor: remoteColors["class1"],
					borderColor: remoteBorderColors["class1"],
          borderWidth: 1
        },{
					label: remoteLabel["class2"],
					data: remoteData["class2"],
					backgroundColor: remoteColors["class2"],
					borderColor: remoteBorderColors["class2"],
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
