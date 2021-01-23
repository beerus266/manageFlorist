@extends('welcome')

@push('CssFile')
    <link href="{{ asset('css/cssFlower.css')}}"  rel="stylesheet" >
@endpush
@section('body-page')

	<div class="title-content">
		Các loại hoa
	</div>
	{{-- <div class="action">
		<div class="row">
			<button type="button" class="btn btn-primary" id="createFlower">Thêm hoa</button>
		</div>
	</div> --}}
	{{-- Button Create  --}}
	  <div class="bg"></div>
	  <div class="button" id="createFlower"><i class="fas fa-pencil-alt fa-2x"></i></div>
  	{{-- -------------------------------------------------- --}}
	<div class="container-card">
			<div class="row" style="margin-left:0px; margin-right:0px" id="cardContainer">
				@foreach ($allFlower as $flower)
					<div class="col-sm-3">
						<div class="profile-card-2 ">
							<img src="{{ asset('img/iconLily.jpg')}}" class="img img-responsive">
							<div class="profile-name-socially">{{$flower->flower_name}}</div>
							<div class="profile-name-exactly">{{$flower->flower_code}}</div>
						</div>
					</div>
				@endforeach
			</div>
	</div>
	{{-- ======================================================================================= --}}
	{{-- Modal create  --}}
	<div class="modal fade" id="modalCreateFlower" tabindex="-2" role="dialog" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-title">Thêm loại hoa</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="">Tên hoa gọi thường:</label>
						<span id="errConventName" style="color: red; display:none"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
						<input type="text" class="form-control" placeholder="VD: Lắc" id="conventName" required>
					</div>
					<div class="form-group" style="display:none">
						<label for="">Tên hoa khoa học:</label>
						<span id="errScientificName" style="color: red; display:none"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
						<input type="text" class="form-control" placeholder="VD: Lake Carry" id="scientificName">
					</div>
					<div class="form-group" style="display:none">
						<label for="">Quốc gia bán củ</label>
						<input type="text" class="form-control" placeholder="VD: Hà Lan" id="supplier">
					</div>
					<!-- <div class="form-group">
						<label for="">Ảnh mẫu</label>
						<input type="file"  id="img">
					</div> -->
				</div>
				<div class="modal-footer">
        			<button type="button" class="btn btn-primary" id="storeFlower"><i class="fas fa-save"></i> {{__('Lưu')}}</button>    
				</div>
			</div>
		</div>
	</div>
		{{-- ======================================================================================= --}}
        {{-- Modal Error  --}}
        <div class="modal" id="modalErr" tabindex="-2" role="dialog" disabled >
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #d52727;">
                        <h2 class="modal-title" style=" color: #ceabab"><i class="fas fa-exclamation-triangle"></i> Gặp lỗi khi đang xử lý !!!!</h2>
                        <button type="button" data-dismiss="close" class="close" aria-label="Close">
                            <span aria-hidden="true">x</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background-color: #e74343">
                        <h4>Hãy chụp lại màn hình và gọi Hải (0393755766) để xử lý.</h4>
                        <p>Có vấn đề khi thực hiện thao tác này....</p>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('JsFile')
    <script src="{{ asset('js/Flower.js') }}"></script>
@endpush
