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
//====== Store flower ====================
$("#storeCustomer").on('click',function(){
    let dataStore = {
        'name' : $("#customerName").val(),
        'address' : $("#address").val(),
        'phone' : $("#telNum").val(),
        'account_bank' : $("#accountBank").val(),
    }
    if ( dataStore.name == "" ){
        if ( dataStore.name == ""){
            $("#errName").show();
        } else {
            $("#errName").hide();
        }
        // if ( dataStore.phone == ""){
        //     $("#errPhone").show();
        // } else {
        //     $("#errPhone").hide();
        // }
    } else {
        StoreCustomer(dataStore).done(function(data){
            // console.log(data);
            $(".alert").show().fadeOut(5000);
            table.row.add([
                table.rows().count()+1,
                data.data.name,
                data.data.phone,
                data.data.address,
                data.data.account_bank,
            ]).draw(false);

            $('#modalCreateCustomer').modal('hide');
        }).fail(function(e){
            console.log(e);
        });
    }

});