// DataTable
var tableAdd = $('#tableCreate').DataTable({
    ordering: false,
    searching: false,
    paging: false,
    // "scrollX": true,
    // "scrollY": '100%'
});
var tableExport = $('#exportFlowerTable').DataTable({
    ordering: false,
    searching: false,
    paging: true,
    // "scrollX": true,
    "info": false,
});
var tableStatistic = $('#statisticTable').DataTable({
    ordering: false,
    searching: false,
    paging: false,
    "info": false,
    // "scrollX": true,

});
// Variable
var dataStandStore = [];

function StoreExportFlower(dataStore) {
    return $.ajax({
        method  : 'get',
        url     : window.location.origin+'/export-flower/store',
        data    : dataStore,
        type    : 'json',
    });
}
function StatisticExportFlower(dataStatistic) {
    return $.ajax({
        method  : 'get',
        url     : window.location.origin+'/export-flower/statistic',
        data    : dataStatistic,
        type    : 'json',
    });
}

//====== Active Navigation ================
$("nav").children("ul").children(" li:eq(4)").addClass("active");

//===== Date rang picker ==================
$('input[name="date"]').daterangepicker({
    timePicker: false,
    singleDatePicker: true,
    startDate: moment().subtract( 47,'days'),
    locale: {
      format: 'DD/MM/YYYY'
        // cancelLabel: 'Clear'
    }
  });
  $('input[name="statisticDate"]').daterangepicker({
    timePicker: false,
    singleDatePicker: false,
    startDate: moment().subtract( 47,'days').startOf('month'),
    endDate: moment().subtract( 47, 'days'),
    locale: {
      format: 'DD/MM/YYYY'
    }
  });
//====== Show modal store =================
$("#createExport").on('click',function(){
    dataStandStore = [];
    $("#errCus").hide();
    $("#errOmit").hide();
    $("#flowerName").val(0);
    $("#flowerQuantity").val("");
    $("#flowerPrice").val("");
    $("#tai").val("");
    $("#customerName").val(0);
    $("#date").prop('disabled',false);
    tableAdd.clear().draw();
    $('#modalCreateExport').modal();
});
//====== Add into tableCreate ============
function addIntoTable(){
    let dataAdd = {
        'customer'    : $("#customerName option:selected").text(),
        'flower'    : $("#flowerName option:selected").text(),
        'tai'       : $("#tai").val(),
        'quantity'  : Number($("#flowerQuantity").val()),
        'price'     : Number($("#flowerPrice").val()),
    };
    console.log(dataAdd);
    // check form input 
    if (  $("#flowerName").val() == 0 
            ||  dataAdd.tai == "" 
            ||  typeof dataAdd.quantity != 'number'
            ||  dataAdd.quantity == "" 
            ||  typeof dataAdd.price != 'number'
            ||  dataAdd.price == ""
            || $("#customerName").val() == 0
    ){
        if ( $("#customerName").val() == 0 ){
            $("#errCus").show();
        } else {
            $("#errCus").hide();
        }
        $("#errOmit").show();
    }else {
        $("#errOmit").hide();
        $("#date").prop('disabled',true);

        let dataExport = {
            'customer_id' : $("#customerName").val(),
            'flower_id' : $("#flowerName").val(),
            'tai'       : dataAdd.tai,
            'quantity'  : dataAdd.quantity,
            'price'     : dataAdd.price,
        }
        dataStandStore.push(dataExport);

        tableAdd.row.add([
            dataAdd.customer,
            dataAdd.flower,
            dataAdd.tai+"T",
            dataAdd.quantity,
            dataAdd.price,
        ]).draw(false);
    }
}

$("#addFlower").on('click',function(){
    addIntoTable();
});

$("#flowerPrice").on('keyup',function(e){
    if (e.keyCode == 13){
        addIntoTable();
    }
})
//====== Store export flower ====================
$("#storeExportFlower").on('click',function(){
    let dataStore = {
        'date'          : moment($("#date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD'),
        'exportFlower'  : dataStandStore
    }
    // console.log(dataStore);
    StoreExportFlower(dataStore).done(function(data){
        console.log(data);
        $(".alert").show().fadeOut(5000);
        for ( i = 0; i < tableAdd.rows().count(); i++){
            tableExport.row.add([
                tableExport.rows().count() + 1,
                dataStore.date,
                tableAdd.cell( i, 0 ).data(),
                tableAdd.cell( i, 1 ).data(),
                tableAdd.cell( i, 2 ).data(),
                tableAdd.cell( i, 3 ).data(),
                tableAdd.cell( i, 4 ).data(),
                "= "+(tableAdd.cell( i, 3 ).data() * tableAdd.cell( i, 4 ).data()),
            ]).draw(true);
        }

        $('#modalCreateExport').modal('hide');
        
    }).fail(function(e){
        console.log(e)
    });
});

//============= Statistic Button ===================
$("#statisticBtn").on('click',function(){
    let dataStatistic = {
        'customer_id'   : $("#statisticCustomer").val(),
        'from'          : moment($("#statisticDate").val().split('-')[0].trim(),'DD/MM/YYYY').format('YYYY-MM-DD'),
        'to'            : moment($("#statisticDate").val().split('-')[1].trim(),'DD/MM/YYYY').format('YYYY-MM-DD'),
    }

    if ( dataStatistic.customer_id == 0 ){

    } else {
        // console.log(dataStatistic);

        StatisticExportFlower(dataStatistic).done(function(data){
            console.log(data);

            tableStatistic.clear().draw();

            let totalAmount = 0;
            $("#statisticTable").css("display","");
            tableExport['searching'] = false;

            $("#statisticCustomerName").text( $("#statisticCustomer option:selected").text());
            $("#statisticCustomerName").parent().css('display','');
            $("#fromToDate").text( "Thời gian từ : "
                                    + $("#statisticDate").val().split('-')[0].trim() 
                                    +" đến "
                                    + $("#statisticDate").val().split('-')[1].trim());
            $("#exportFlowerTable").css("display","none");

            let flag;
            for ( let item of data.data ){

                let formDate = moment(item.date, 'YYYY-MM-DD').format('DD/MM/YYYY');
// console.log(flag);
                tableStatistic.row.add([
                    formDate  == flag
                    ? "" : formDate ,
                    item.flower_name,
                    item.tai+"T",
                    item.quantity,
                    "x "+item.price,
                    "= "+(item.quantity * item.price),
                ]).draw(false);

                flag =  formDate == flag ? flag : formDate;

                totalAmount += item.quantity * item.price
            }

            $("#totalAmount").text(totalAmount);
        }).fail(function(e){
            console.log(e)
        });
    }
});
//============= Adjust =====================
// $('#exportFlowerTable').parent().parent().css('margin-right','0px');
// $('#exportFlowerTable').parent().parent().css('margin-left','0px');


