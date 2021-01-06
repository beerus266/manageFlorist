function getBarChart(){
  return $.ajax({
    method : 'get',
    url: window.location.origin+"/home/get-bar-chart",
    data: {},
    dataType: 'json'
  });
}

var areaChartData = {
	labels: [],
    datasets: [
      {
        label               : 'Nhập hàng',
        backgroundColor     : 'rgba(188, 167, 89, 0.9)',
        borderColor         : 'rgba(60,141,188,0.8)',
        pointRadius          : false,
        pointColor          : '#3b8bba',
        pointStrokeColor    : 'rgba(60,141,188,1)',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(60,141,188,1)',
        data                : [0, 0, 0, 0, 0, 0, 0]
      },
      {
        label               : 'Xuất hàng',
        backgroundColor     : '#28a745',
        borderColor         : 'rgba(210, 214, 222, 1)',
        pointRadius         : false,
        pointColor          : 'rgba(210, 214, 222, 1)',
        pointStrokeColor    : '#c1c7d1',
        pointHighlightFill  : '#fff',
        pointHighlightStroke: 'rgba(220,220,220,1)',
        data                : []
      },
	],
  }

//====== Active Navigation ================
$(".list-unstyled").children(" li:eq(0)").addClass("active");

//========= Get Data Bar Chart ===============
getBarChart().done(function(data){
	//   console.log(data);
	  	data.data.map( (elem) => {
		  	areaChartData.labels.push(elem.date);
		  	areaChartData.datasets[1].data.push(elem.total);
		});
		// console.log(areaChartData);

  
    //-------------
    //- BAR CHART -
    //-------------
    var barChartCanvas = $('#barChart').get(0).getContext('2d')
    var barChartData = $.extend(true, {}, areaChartData)
    var temp0 = areaChartData.datasets[0]
    var temp1 = areaChartData.datasets[1]
    // barChartData.datasets[0] = temp1
    // barChartData.datasets[1] = temp0

    var barChartOptions = {
		responsive              : true,
		maintainAspectRatio     : false,
		datasetFill             : false,
		scales: {
            yAxes: [{
                ticks: {
                    // Include a dollar sign in the ticks
                    callback: function(value, index, values) {
						
						value = value.toString().split('').reverse();
						value.splice(3, 0, ",");
                        return value.reverse().join('');
                    }
                }
            }]
        }
    }

    var barChart = new Chart(barChartCanvas, {
      type: 'bar',
      data: barChartData,
      options: barChartOptions
	});
}).fail(function(e){console.log(e)});
