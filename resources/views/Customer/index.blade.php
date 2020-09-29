@extends('welcome')

@push('CssFile')
    {{-- <link href="{{ asset('css/cssCustomer.css')}}"  rel="stylesheet" > --}}
@endpush
@section('body-page')

	<div class="title-content">
		Khách hàng dan
	</div>
	{{-- Button Create  --}}
		<div class="bg"></div>
		<div class="button" id="createCustomer"><i class="fa fa-pencil fa-2x" aria-hidden="true"></i></div>
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
        			<button type="button" class="btn btn-primary" id="storeCustomer"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Lưu')}}</button>    
				</div>
			</div>
		</div>
	</div>
@endsection

@push('JsFile')
    <script src="{{ asset('js/Customer.js') }}"></script>
@endpush
