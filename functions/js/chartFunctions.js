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
           label: function(tooltipItem) {
                  return tooltipItem.yLabel;
           }
        }
    }
    }
});
}
