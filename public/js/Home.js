//======== Define Variable ===============================================================
var now = moment().subtract( 43,'days');
var flowerBarChartCanvas = $('#flowerBarChart').get(0).getContext('2d');
var flowerBarChartData ;
var flowerBarChartOptions = {
		responsive              : true,
		maintainAspectRatio     : false,
		datasetFill             : false,
		scales: {
			xAxes: [{
				ticks: {
					fontSize: 20,
					fontColor: '#000'
				},
			}],
            yAxes: [{
                ticks: {
                    callback: function(value, index, values) {
                        return value + " bó";
					},
					fontSize: 15,
				},
			}],
		},
	}
var flowerChartData = {
	labels: [],
	datasets: [
		{
		  label               : 'Nhập hàng',
		  backgroundColor     : '#ffc107',
		  borderColor         : 'rgba(60,141,188,0.8)',
		  pointRadius          : false,
		  pointColor          : '#3b8bba',
		  pointStrokeColor    : 'rgba(60,141,188,1)',
		  pointHighlightFill  : '#fff',
		  pointHighlightStroke: 'rgba(60,141,188,1)',
		  data                : []
		},
		{
		  label               : 'Xuất hàng',
		  backgroundColor     : '#17a2b8',
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
var flowerBarChart = new Chart(flowerBarChartCanvas, {
	type: 'bar',
	data: flowerBarChartData,
	options: flowerBarChartOptions
});
//==================================================================================================

function getBarChart(){
  return $.ajax({
    method : 'get',
    url: window.location.origin+"/home/get-bar-chart",
    data: {},
    dataType: 'json'
  });
}

function getQuantityEachKindOfFlower(data){
	return $.ajax({
	  method : 'get',
	  url: window.location.origin+"/home/get-quantity-flower",
	  data: data,
	  dataType: 'json'
	});
}

function drawFlowerQuantityChart(){
	let dateQuantityFlower = {
		'date': moment($("#date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD')
	};
	// console.log(dateQuantityFlower);
	$(".btn-loading").show();
	getQuantityEachKindOfFlower(dateQuantityFlower).done(function(data){
		// console.log(data);
		
		data.data.map(function(elem){
		elem.quantityIm = elem.quantityIm == null ? 0 : Number(elem.quantityIm) ;
		elem.quantityEx = elem.quantityEx == null ? 0 : Number(elem.quantityEx) ;
		});
		
		flowerChartData.labels = [];
		flowerChartData.datasets[0].data = [];
		flowerChartData.datasets[1].data = [];

		data.data.map(function(elem){
			flowerChartData.labels.push(elem.flower_name);
			flowerChartData.datasets[0].data.push(elem.quantityIm);
			flowerChartData.datasets[1].data.push(elem.quantityEx);
		});

		//-------------
		//- Flower BAR CHART -
		//------------
		flowerBarChartData = $.extend(true, {}, flowerChartData);

		flowerBarChart = new Chart(flowerBarChartCanvas, {
			type: 'bar',
			data: flowerBarChartData,
			options: flowerBarChartOptions
		});
		$(".btn-loading").hide();
	}).fail(function(e){
		$('#modalErr').modal({backdrop: 'static', keyboard: false})  ;
		// console.log(e);
	});
}

//===== Date rang picker ==================
$('input[name="date"]').daterangepicker({
    timePicker: false,
    singleDatePicker: true,
    startDate: moment().subtract( 46,'days'),
    locale: {
      format: 'DD/MM/YYYY'
        // cancelLabel: 'Clear'
    }
});

//========= Lunar Calendar ============

var areaChartData = {
	labels: [],
    datasets: [
      {
        label               : 'Nhập hàng',
        backgroundColor     : '#dc3545',
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
        data                : [0, 0, 0, 0, 0, 0, 0]
      },
	],
}

for (let i = 6; i >= 0; i--){
	areaChartData.labels.push(moment().subtract( 43,'days').subtract( i,'days').format("YYYY-MM-DD"));
}
//====== Active Navigation ================
$(".list-unstyled").children(" li:eq(0)").addClass("active");

//========= Get Data Bar Chart ===============
getBarChart().done(function(data){
	  	// console.log(data);
		data.dataIm.map( (elem) => {
			if(areaChartData.labels.indexOf(elem.date) != -1){
				areaChartData.datasets[0].data[areaChartData.labels.indexOf(elem.date)] = elem.total;
			}
		});
	  	data.dataEx.map( (elem) => {
			if(areaChartData.labels.indexOf(elem.date) != -1){
				areaChartData.datasets[1].data[areaChartData.labels.indexOf(elem.date)] = elem.total;
			}
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
}).fail(function(e){
  $('#modalErr').modal({backdrop: 'static', keyboard: false})  ;
});

//================= Quantity Flower Bar Chart ===============================
$("#quantityFlowerBtn").on("click",function(){
	flowerBarChart.destroy();
    drawFlowerQuantityChart();
});

$("#quantityFlowerBtn").click();

