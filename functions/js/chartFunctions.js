function DrawChart(remoteFields, remoteData, remoteColors, remoteBorderColors) {
	var ctx = document.getElementById("myChart").getContext('2d');
	var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        //labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
		labels: remoteFields,
        datasets: [{
            label: 'Anzahl der Antworten',
			data: remoteData,
			/*
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
			*/
			backgroundColor: remoteColors,
			/*
            borderColor: [
                'rgba(255,99,132,1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
			*/
			borderColor: remoteBorderColors,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        },
		responsive: true,
		maintainAspectRatio: false
    }
});
}