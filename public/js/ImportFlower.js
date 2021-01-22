// DataTable
var tableAdd = $('#tableCreate').DataTable({
    ordering: false,
    searching: false,
    paging: false,
    // "scrollX": true,
    // "scrollY": '100%'
});
var tableImport = $('#importFlowerTable').DataTable({
    ordering: false,
    searching: false,
    paging: false,
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

function StoreImportFlower(dataStore) {
    return $.ajax({
        method  : 'get',
        url     : window.location.origin+'/import-flower/store',
        data    : dataStore,
        type    : 'json',
    });
}
function StatisticImportFlower(dataStatistic) {
    return $.ajax({
        method  : 'get',
        url     : window.location.origin+'/import-flower/statistic',
        data    : dataStatistic,
        type    : 'json',
    });
}

//====== Active Navigation ================
$(".list-unstyled").children(" li:eq(3)").addClass("active");

//===== Date rang picker ==================
$('input[name="date"]').daterangepicker({
    timePicker: false,
    singleDatePicker: true,
    startDate: moment().subtract( 43,'days'),
    locale: {
      format: 'DD/MM/YYYY'
        // cancelLabel: 'Clear'
    }
  });
  $('input[name="statisticDate"]').daterangepicker({
    timePicker: false,
    singleDatePicker: false,
    startDate: moment().subtract( 43,'days').startOf('month'),
    endDate: moment().subtract( 43, 'days'),
    locale: {
      format: 'DD/MM/YYYY'
    }
  });
//====== Show modal store =================
$("#createImport").on('click',function(){
    dataStandStore = [];
    $("#errCus").hide();
    $("#errOmit").hide();
    $("#flowerName").val(0);
    $("#flowerQuantity").val("");
    $("#flowerPrice").val("");
    $("#tai").val("");
    $("#note").val("");
    $("#customerName").val(0);
    $("#date").prop('disabled',false);
    tableAdd.clear().draw();
    $("#storeImportFlower").prop("disabled",false);
    $('#modalCreateImport').modal();
    // $('#modalCreateImport').modal({backdrop: 'static', keyboard: false, show: true})  ;
});
//====== Add into tableCreate ============
function addIntoTable(){
    let dataAdd = {
        'customer'  : $("#customerName option:selected").text(),
        'flower'    : $("#flowerName option:selected").text(),
        'note'      : $("#note").val(),
        'tai'       : $("#tai").val(),
        'quantity'  : Number($("#flowerQuantity").val()),
        'price'     : Number($("#flowerPrice").val()),
    };
    // console.log(dataAdd);
    // check form input 
    if (  $("#flowerName").val() == 0 
            ||  dataAdd.tai == "" 
            ||  isNaN(dataAdd.quantity) 
            ||  dataAdd.quantity == "" 
            ||  isNaN(dataAdd.price) 
            ||  dataAdd.price == ""
            || $("#customerName").val() == 0
    ){
        if ( $("#customerName").val() == 0 ){
            $("#errCus").show();
        } else {
            $("#errCus").hide();
        }
        if (isNaN(dataAdd.quantity) ||  dataAdd.quantity == "" ) {
            $("#errQuantity").show();
        } else {
            $("#errQuantity").hide();
        }
        if (isNaN(dataAdd.price) ||  dataAdd.price == "" ) {
            $("#errPrice").show();
        } else {
            $("#errPrice").hide();
        }
        $("#errOmit").show();
    }else {
        $("#errOmit").hide();
        $("#sucOmit").hide();
        $("#errPrice").hide();
        $("#errQuantity").hide();
        $("#errCus").hide();
        $("#date").prop('disabled',true);

        let dataImport = {
            'customer_id' : $("#customerName").val(),
            'flower_id' : $("#flowerName").val(),
            'note'      : dataAdd.note,
            'tai'       : dataAdd.tai,
            'quantity'  : dataAdd.quantity,
            'price'     : dataAdd.price,
        }
        dataStandStore.push(dataImport);

        tableAdd.row.add([
            dataAdd.customer,
            dataAdd.flower +" "+ dataAdd.note,
            dataAdd.tai+"T",
            dataAdd.quantity,
            dataAdd.price,
            '<button type="button" class="btn btn-warning">Xóa</button>'
        ]).draw(false);

        $("#addCompletelyAleart").prepend("<li><p>"+dataAdd.customer
                                                +" : "+dataAdd.flower 
                                                +" "
                                                + dataAdd.note
                                                + " "+dataAdd.tai+"T"
                                                + " "+dataAdd.quantity
                                                + " x "+dataAdd.price
                                                +"</p></li>");

        
        if ( $("#addCompletelyAleart li").length > 7 ) {
            $("#addCompletelyAleart li:last-child").remove();
        }                                     

        $("#flowerQuantity").val("");
        $("#flowerPrice").val("");
        $("#tai").val("");
        $("#note").val("");
        $("#flowerName").focus();
    }
}

$("#addFlower").on('click',function(){
    addIntoTable();
});

$("#note").on('keyup',function(e){
    if (e.keyCode == 13){
        addIntoTable();
    }
})
//====== Store Import flower ====================
$("#storeImportFlower").on('click',function(){
    let dataStore = {
        '_token': $('meta[name="csrf-token"]').attr('content'),
        'date'          : moment($("#date").val(), 'DD-MM-YYYY').format('YYYY-MM-DD'),
        'importFlower'  : dataStandStore
    }
    // console.log(dataStore);
    $(this).prop("disabled",true);
    $(".btn-loading").show();
    StoreImportFlower(dataStore).done(function(data){
        console.log(data);
        $(".alert").show().fadeOut(15000);
        for ( i = 0; i < tableAdd.rows().count(); i++){
            tableImport.row.add([
                tableImport.rows().count() + 1,
                dataStore.date,
                tableAdd.cell( i, 0 ).data(),
                tableAdd.cell( i, 1 ).data(),
                tableAdd.cell( i, 2 ).data(),
                tableAdd.cell( i, 3 ).data(),
                "x "+tableAdd.cell( i, 4 ).data(),
                "= "+(tableAdd.cell( i, 3 ).data() * tableAdd.cell( i, 4 ).data()),
            ]).draw(true);
        }

        $("#addCompletelyAleart li").remove();
        $(".btn-loading").hide();
        $('#modalCreateImport').modal('hide');
        
    }).fail(function(e){
        $('#modalErr').modal({backdrop: 'static', keyboard: false})  ;
        console.log(e);
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
    //======== All Of the customers ===============
        StatisticImportFlower(dataStatistic).done(function(data){
           console.log(data);

           tableImport.clear().draw();

           let totalAmount = 0;

           let flagDate;
           let flagCustomer;
           for ( let item of data.data ){

               let formDate = moment(item.date, 'YYYY-MM-DD').format('DD/MM/YYYY');
               let customer = item.name;
               tableImport.row.add([
                   tableImport.rows().count()+1,
                   (formDate  != flagDate) || (customer != flagCustomer) ? formDate : "" ,
                   customer  == flagCustomer ? "" : customer ,
                   item.note != null ? (item.flower_name +" "+item.note) : item.flower_name,
                   item.tai+"T",
                   item.quantity,
                   "x "+item.price,
                   "= "+(item.quantity * item.price),
               ]).draw(false);

               flagDate =  formDate == flagDate ? flagDate : formDate;
               flagCustomer =  customer == flagCustomer ? flagCustomer : customer;

               totalAmount += item.quantity * item.price
           }

           $("#totalAmount").text(totalAmount);
       }).fail(function(e){
           $('#modalErr').modal({backdrop: 'static', keyboard: false})  ;
       });
    } else {
    //======== Just only 1 customer ===============
        console.log(dataStatistic);

        $("aside").css("display","none");
        $("section").css("width","100%");
        StatisticImportFlower(dataStatistic).done(function(data){
            // console.log(data);

            tableStatistic.clear().draw();

            let totalAmount = 0;
            $("#statisticTable").css("display","");
            tableImport['searching'] = false;

            $("#statisticCustomerName").text( $("#statisticCustomer option:selected").text());
            $("#statisticCustomerName").parent().css('display','');
            $("#fromToDate").text( "Thời gian từ : "
                                    + $("#statisticDate").val().split('-')[0].trim() 
                                    +" đến "
                                    + $("#statisticDate").val().split('-')[1].trim());
            $("#importFlowerTable").css("display","none");

            let flag;
            for ( let item of data.data ){

                let formDate = moment(item.date, 'YYYY-MM-DD').format('DD/MM/YYYY');
// console.log(flag);
                tableStatistic.row.add([
                    formDate  == flag
                    ? "" : formDate ,
                    item.note != null ? (item.flower_name +" "+item.note) : item.flower_name,
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
            $('#modalErr').modal({backdrop: 'static', keyboard: false, show: true})  ;
            console.log(e);
        });
    }
});

var tdWantToDelTableAdd;
//============= Delete Row Add Create Table =========================
$(document).on("click",".btn-warning", function(){
    tdWantToDelTableAdd = $(this).parent();
    let rowIndexTableAdd = tableAdd.row(tdWantToDelTableAdd).index();

    $("#modalConfirm").children().children().children(".modal-body").empty();
    $("#modalConfirm").children().children().children(".modal-body").prepend('<p>' 
                                        +tableAdd.cell(rowIndexTableAdd, 0).data()+':  '
                                        +tableAdd.cell(rowIndexTableAdd, 1).data()+'   '
                                        +tableAdd.cell(rowIndexTableAdd, 2).data()+'   '
                                        +tableAdd.cell(rowIndexTableAdd, 3).data()+' x  '
                                        +tableAdd.cell(rowIndexTableAdd, 4).data()+'   '
                                        +'</p>');
    $("#modalConfirm").modal();
});

$(".btn-danger").on("click",function(){
    // console.log(dataStandStore);
    dataStandStore.splice(tableAdd.row(tdWantToDelTableAdd).index(), 1);
    tableAdd.row(tdWantToDelTableAdd).remove().draw();
    // console.log(dataStandStore);
    $("#sucOmit").show();
    $("#modalConfirm").modal('hide');
});

//===================================================================

//---------------------------Listener onclick-----------------------------------------------
// $("#tableCreate tbody ").on("click","td",function(){
//     console.log(tableAdd.row(this).index());                   // get position row selected
//     console.log(tableAdd.cell(this).index().columnVisible); // get position column selected

//     // tableAdd.row(this).remove().draw();
//     // $(this).empty();
//     // $(this).prepend('<input type="text" value="123">');

//     console.log(dataStandStore);
// });



