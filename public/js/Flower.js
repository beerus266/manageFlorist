function StoreFlower(dataStore) {
    return $.ajax({
        method  : 'get',
        url     : window.location.origin+'/flower/store',
        data    : dataStore,
        type    : 'json',
    });
}

//====== Active Navigation ================
$("nav").children("ul").children(" li:eq(1)").addClass("active");


//====== Show modal store =================
$("#createFlower").on('click',function(){
    $("#conventName").val('');
    $("#scientificName").val('');
    $("#supplier").val('');
    $('#modalCreateFlower').modal('show');
});
//====== Store flower ====================
$("#storeFlower").on('click',function(){
    let dataStore = {
        'flower_name' : $("#conventName").val(),
        'flower_code' : $("#scientificName").val(),
        'supplier' : $("#supplier").val(),
    }
    if ( dataStore.flower_code == "" || dataStore.flower_name == ""){
        if ( dataStore.flower_name == ""){
            $("#errConventName").show();
        } else {
            $("#errConventName").hide();
        }
        if ( dataStore.flower_code == ""){
            $("#errScientificName").show();
        } else {
            $("#errScientificName").hide();
        }
    } else {
        StoreFlower(dataStore).done(function(data){
            // console.log(data,data.data.created_at);

            $("#cardContainer").append(`
                <div class="col-sm-3">
                    <div class="profile-card-2 ">
                        <img src="https://d19m59y37dris4.cloudfront.net/university/1-1-1/img/teacher-4.jpg" class="img img-responsive">
                        <div class="profile-name-socially">`+data.data.flower_name+`</div>
                        <div class="profile-name-exactly">`+data.data.flower_code+`</div>
                    </div>
                </div>
            `);

            $('#modalCreateFlower').modal('hide');
        }).fail(function(e){
            console.log(e);
        });
    }

});