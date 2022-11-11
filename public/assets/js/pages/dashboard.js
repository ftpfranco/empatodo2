var optionsProfileVisit = {
	annotations: {
		position: 'back'
	},
	dataLabels: {
		enabled:false
	},
	chart: {
		type: 'bar',
		height: 300
	},
	fill: {
		opacity:1
	},
	plotOptions: {
	},
	series: [{
		name: 'sales',
		data: [9,20,30,20,10,20,30,20,10,20,30,20]
	}],
	colors: '#435ebe',
	xaxis: {
		categories: ["Jan","Feb","Mar","Apr","May","Jun","Jul", "Aug","Sep","Oct","Nov","Dec"],
	},
}
let optionsVisitorsProfile  = {
	series: [70, 30],
	labels: ['Male', 'Female'],
	colors: ['#435ebe','#55c6e8'],
	chart: {
		type: 'donut',
		width: '100%',
		height:'350px'
	},
	legend: {
		position: 'bottom'
	},
	plotOptions: {
		pie: {
			donut: {
				size: '30%'
			}
		}
	}
}

let optionsMetodosPago  = {
	series: [60, 20,10,10,0],
	labels: ['Efectivo', 'Debito', 'Credito','Cheque','Otro'],
	colors: ['#435ebe','#55c6e8','#12a8e8','#ffc6ff','#55c600'],
	chart: {
		type: 'donut',
		width: '100%',
		height:'350px'
	},
	legend: {
		position: 'bottom'
	},
	plotOptions: {
		pie: {
			donut: {
				size: '30%'
			}
		}
	}
}


var optionsEurope = {
	series: [{
		name: 'series1',
		data: [310, 800, 600, 430, 540, 340, 605, 805,430, 540, 340, 605]
	}],
	chart: {
		height: 80,
		type: 'area',
		toolbar: {
			show:false,
		},
	},
	colors: ['#5350e9'],
	stroke: {
		width: 2,
	},
	grid: {
		show:false,
	},
	dataLabels: {
		enabled: false
	},
	xaxis: {
		type: 'datetime',
		categories: ["2018-09-19T00:00:00.000Z", "2018-09-19T01:30:00.000Z", "2018-09-19T02:30:00.000Z", "2018-09-19T03:30:00.000Z", "2018-09-19T04:30:00.000Z", "2018-09-19T05:30:00.000Z", "2018-09-19T06:30:00.000Z","2018-09-19T07:30:00.000Z","2018-09-19T08:30:00.000Z","2018-09-19T09:30:00.000Z","2018-09-19T10:30:00.000Z","2018-09-19T11:30:00.000Z"],
		axisBorder: {
			show:false
		},
		axisTicks: {
			show:false
		},
		labels: {
			show:false,
		}
	},
	show:false,
	yaxis: {
		labels: {
			show:false,
		},
	},
	tooltip: {
		x: {
			format: 'dd/MM/yy HH:mm'
		},
	},
};

let optionsAmerica = {
	...optionsEurope,
	colors: ['#008b75'],
}
let optionsIndonesia = {
	...optionsEurope,
	colors: ['#dc3545'],
}




var areaVentas= {
	series: [
	  {
		name: "Cant de Ventas",
		data: [11, 32, 45, 32, 34, 52, 41],
	  },
	],
	chart: {
	  height: 350,
	  type: "area",
	},
	dataLabels: {
	  enabled: false,
	},
	stroke: {
	  curve: "smooth",
	},
	xaxis: {
	  type: "datetime",
	  categories: [
		"2018-09-10",
		"2018-09-11",
		"2018-09-12",
		"2018-09-13",
		"2018-09-14",
		"2018-09-15",
		"2018-09-16",
	  ],
	},
	tooltip: {
	  x: {
		format: "dd/MM/yy HH:mm",
	  },
	},
  };





var chartProfileVisit = new ApexCharts(document.querySelector("#chart-profile-visit"), optionsProfileVisit);
// var chartVisitorsProfile = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsVisitorsProfile)
var chartVisitorsProfile = new ApexCharts(document.getElementById('chart-visitors-profile'), optionsMetodosPago)
var chartEurope = new ApexCharts(document.querySelector("#chart-europe"), optionsEurope);
var chartAmerica = new ApexCharts(document.querySelector("#chart-america"), optionsAmerica);
var chartIndonesia = new ApexCharts(document.querySelector("#chart-indonesia"), optionsIndonesia);

chartIndonesia.render();
chartAmerica.render();
chartEurope.render();
chartProfileVisit.render();
chartVisitorsProfile.render()



var area = new ApexCharts(document.querySelector("#area"), areaVentas);

area.render();


