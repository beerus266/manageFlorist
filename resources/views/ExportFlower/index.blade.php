@extends('welcome')

@push('CssFile')
    <link rel="stylesheet" href="{{ asset('css/cssExport.css')}}">
@endpush
@section('body-page')

        <div class="title-content">
            XUẤT HÀNG
        </div>
        <!-- <form  action="{{ route('exportFlower.store')}}" enctype="multipart/form-data" method="post"> 
            {{ csrf_field() }} 
            @csrf
                    <div class="form-group">
						<label for="">Ảnh mẫu</label>
						<input type="file"  id="img" name="imgInvoice">
					</div>
            <button type="submit" class="btn btn-primary" id="upload"><i class="fa fa-floppy-o" aria-hidden="true"></i> {{__('Tai Anh')}}</button>    
        </form> -->

        {{-- <div class="action">
            <div class="row">
                <button type="button" class="btn btn-primary" id="createExport">Xuất hàng</button>
            </div>
        </div> --}}
        {{-- Button Create  --}}
            <div class="bg"></div>
            <div class="button" id="createExport"><i class="fas fa-pencil-alt fa-2x"></i></div>
        {{-- -------------------------------------------------- --}}
        <div class="action">
            <div class="row">
                <div class="form-group col-sm-5">
                    <label for="" style="font-weight: bold">Chọn ngày</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="fa fa-calendar"></i>
                          </span>
                        </div>
                        <input type="text" class="form-control float-right" name="statisticDate" id="statisticDate">
                    </div>
                </div>
                <div class="form-group col-sm-3">
                    <label for="" style="font-weight: bold">Chọn khách</label>
                    <select name="" class="form-control" id="statisticCustomer">
                        <option value="0">Tất cả</option>
                        @foreach ($dataAllCustomer as $cus)
                            <option value="{{$cus->id}}">{{$cus->name}}</option>
                        @endforeach
                    </select>
                </div>
                <button type="button" class="btn btn-primary" style="height: 30%; margin-top: 40px;" id="statisticBtn">Thống kê</button>
            </div>
        </div>
        <div class="row container-info-customer" >
            <div class="col-sm-6"  style="display:none">Tên khách hàng: <span id="statisticCustomerName"></span></div>
            <div class="col-sm-6" id="fromToDate"></div>
        </div>
        <button class="btn btn-primary btn-loading" type="button" disabled >
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Đang lưu...
        </button>
        <table class="table table-bordered table-striped" id="statisticTable" style="display:none">
            <thead>
                <th>Ngày</th>
                <th>Tên hoa</th>
                <th>Tai</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </thead>
            <tbody>
            </tbody>
        </table>
        {{-- Alert --}}
            <div class="alert alert_success" style="display:none"> <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> <strong>Xuất hàng thành công ! Xem ở đầu bảng</strong> </div>
        {{-- -----------------------------------------  --}}
        <table class="table table-striped table-bordered" id="exportFlowerTable" style="">
            <thead>
                <th>STT</th>
                <th>Ngày</th>
                <th>Tên khách hàng</th>
                <th>Tên hoa</th>
                <th>Số tai</th>
                <th>Số lượng</th>
                <th>Giá</th>
                <th>Thành tiền</th>
            </thead>
            <tbody>
                @foreach ( $dataAllExport as $export)
                    <tr>
                        <td>{{$loop->index+1}}</td>
                        <td>{{$export->date}}</td>
                        <td>{{$export->name}}</td>
                        <td>{{$export->flower_name}} {{$export->note}} </td>
                        <td>{{$export->tai}}T</td>
                        <td>{{$export->quantity}}</td>
                        <td>x {{$export->price}}</td>
                        <td> = {{$export->quantity * $export->price }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="row container-amount" >
            <div class="col-sm-6" >Tổng:</div>
            <div class="col-sm-6" id="totalAmount" ></div>
        </div>
        {{-- ======================================================================================= --}}
        {{-- Modal create  --}}
        <div class="modal fade" id="modalCreateExport" tabindex="-2" role="dialog" disabled>
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="modal-title">Xuất hàng</div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="">Chọn khách hàng</label>
                                <span id="errCus" style="color: red; display:none"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                <select type="text" class="form-control"  id="customerName" >
                                    <option value="0" >Chọn khách hàng</option>
                                    @foreach ($dataAllCustomer as $cus)
                                        <option value="{{$cus->id}}">{{$cus->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="">Chọn ngày</label>
                                <input type="text" name="date" class="form-control" id="date">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-sm-3">
                                <label for="">Chọn loại hoa</label>
                                <select type="text" class="form-control"  id="flowerName" >
                                    <option value="0" >Chọn loại hoa</option>
                                    @foreach ($dataAllFlower as $flo)
                                        <option value="{{$flo->id}}">{{$flo->flower_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group col-sm-1">
                                <label for=""> Tai </label>
                                <input type="text" class="form-control"  id="tai">
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="">Số bó hoa</label> 
                                <span id="errQuantity" style="color: red; display:none"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                <input type="text" class="form-control"  id="flowerQuantity">
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="">Giá</label>
                                <span id="errPrice" style="color: red; display:none"><i class="fa fa-times-circle" aria-hidden="true"></i></span>
                                <input type="text" class="form-control"  id="flowerPrice">
                            </div>
                            <div class="form-group col-sm-2">
                                <label for="">Ghi chú</label>
                                <input type="text" class="form-control"  id="note">
                            </div>
                            <div class=" col-sm-2">
                                <button type="button" class="btn btn-success " style="margin-top:26%; width:100%" id="addFlower">Thêm</button>
                            </div>
                        </div>
						<span id="errOmit" style="color: red; display:none"><i class="fa fa-times-circle" aria-hidden="true"></i> Điền chính xác thông tin</span>
                        <table class="table table-striped table-bordered" id="tableCreate">
                            <thead>
                                <th>Tên khách hàng</th>
                                <th>Tên hoa</th>
                                <th>Tai</th>
                                <th>Số lượng</th>
                                <th>Giá</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="storeExportFlower"><i class="fas fa-save"></i> {{__('Xuất')}}</button>    
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

        <ul id="addCompletelyAleart">       
        </ul>
    
@endsection

@push('JsFile')
    <script src="{{ asset('js/ExportFlower.js') }}"></script>
@endpush