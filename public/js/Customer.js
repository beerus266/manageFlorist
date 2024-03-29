function StoreCustomer(dataStore) {
    return $.ajax({
        method  : 'get',
        url     : window.location.origin+'/customer/store',
        data    : dataStore,
        type    : 'json',
    });
}


//====== Active Navigation ================
$(".list-unstyled").children(" li:eq(2)").addClass("active");

// DataTable
var table = $('#customerTable').DataTable({
    // ordering: true,
    // searching: true,
    paging: false,
    // "scrollX": true,
    // "scrollY": "100%",
});
    
//====== Show modal store =================
$("#createCustomer").on('click',function(){
    $("#customerName").val("");
    $("#address").val('');
    $("#telNum").val('');
    $("#accountBank").val('');
    $('#modalCreateCustomer').modal();
});
// console.log(Number("12"));
//====== Store customer ====================
$("#storeCustomer").on('click',function(){
    let dataStore = {
        'name' : $("#customerName").val(),
        'address' : $("#address").val(),
        'phone' : $("#telNum").val(),
        'isImporter' : $('input[name=exampleRadios]:checked').val(),
    }
    if ( dataStore.name == "" || dataStore.isImporter == undefined){
        if ( dataStore.name == ""){
            $("#errName").show();
        } else {
            $("#errName").hide();
        }
        if ( dataStore.isImporter == undefined){
            $("#errTypeCustomer").show();
        } else {
            $("#errTypeCustomer").hide();
        }
    } else {
        $("#errTypeCustomer").hide();
        $("#errName").hide();
        $(".btn-loading").show();
        StoreCustomer(dataStore).done(function(data){
            // console.log(data);
            $(".alert").show().fadeOut(5000);
            table.row.add([
                table.rows().count()+1,
                data.data.name,
                data.data.phone,
                data.data.address,
                data.data.isImporter == 1 ? "Khách nhập hàng" : "Khách mua hàng",
            ]).draw(false);

            $(".btn-loading").hide();
            $('#modalCreateCustomer').modal('hide');
        }).fail(function(e){
            $('#modalErr').modal({backdrop: 'static', keyboard: false})  ;
            // console.log(e);
        });
    }

});