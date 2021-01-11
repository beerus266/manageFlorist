@extends('welcome')

@push('CssFile')
    <link href="{{ asset('css/cssCustomer.css')}}"  rel="stylesheet" > 
@endpush
@section('body-page')

	<div class="title-content">
		Khách hàng
	</div>
	{{-- Button Create  --}}
		<div class="bg"></div>
		<div class="button" id="createCustomer"><i class="fas fa-pencil-alt fa-2x"></i></div>
	{{-- -------------------------------------------------- --}}
	{{-- Alert --}}
        <div class="alert alert_success" style="display:none"> <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> <strong>Xuất hàng thành công ! Xem ở đầu bảng</strong> </div>
    {{-- -----------------------------------------  --}}
	<table class="table table-striped table-bordered" id="customerTable">
        <thead>
            <th>STT</th>
            <th>Tên</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Tài khoản ngân hàng</th>
        </thead>
        <tbody>
			@foreach ($allCustomer as $cus)
				<tr>
					<td>{{$loop->index+1}}</td>
					<td>{{$cus->name}}</td>
					<td>{{$cus->address}}</td>
					<td>{{$cus->phone}}</td>
					<td>{{$cus->account_bank}}</td>
				</tr>
			@endforeach
        </tbody>
    </table>
	{{-- ======================================================================================= --}}
	{{-- Modal create  --}}
	<div class="modal fade" id="modalCreateCustomer" tabindex="-2" role="dialog" >
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="modal-title">Thêm khách hàng</div>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="">Tên khách hàng</label>
						<span id="errName" style="color: red; display:none"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
						<input type="text" class="form-control"  id="customerName" required>
					</div>
					<div class="form-group">
						<label for="">Địa chỉ</label>
						<input type="text" class="form-control" id="address">
					</div>
					<div class="form-group">
						<label for=""> Số điện thoại</label>
						<span id="errPhone" style="color: red; display:none"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
						<input type="text" class="form-control"  id="telNum">
					</div>
					<div class="form-group">
						<label for="">Tài khoản ngân hàng</label>
						<input type="text" class="form-control"  id="accountBank">
					</div>
				</div>
				<div class="modal-footer">
        			<button type="button" class="btn btn-primary" id="storeCustomer"><i class="fas fa-save"></i> {{__('Lưu')}}</button>    
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
                        <h4>Yêu cầu gọi Hải (0393755766) để xử lý</h4>
                        <p>Hiện giờ phần mềm này KHÔNG còn đúng nữa....</p>
                    </div>
                </div>
            </div>
        </div>
@endsection

@push('JsFile')
    <script src="{{ asset('js/Customer.js') }}"></script>
@endpush
