@extends('welcome')

@push('CssFile')
	<!-- <link href="{{ asset('css/cssHome.css')}}"  rel="stylesheet" > -->
	 <!-- Theme style -->
	<!-- <link rel="stylesheet" href="dist/css/adminlte.min.css"> -->
	<link rel="stylesheet" href="{{ asset('plugins/AdminLTE-3.1.0-rc/dist/css/adminlte.min.css') }}">
	<!-- Ionicons -->
	<!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
@endpush
@section('body-page')
		<div class="row">
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{$countFlower}}</h3>

                <p>Loại hoa</p>
              </div>
              <div class="icon">
                <i class="fas fa-seedling"></i>
              </div>
              <a href="{{ route('flower.index')}}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$countCustomer}}</h3>

                <p>Khách hàng</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-friends"></i>
              </div>
              <a href="{{ route('customer.index')}}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$amountImportAMonth->totalAMonth}}</h3>

                <p>Tiền nhập hoa tháng {{$amountImportAMonth->month}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-truck-loading"></i>
              </div>
              <a href="{{ route('importFlower.index')}}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$amountExportAMonth->totalAMonth}}</h3>

                <p>Tiền xuất hoa tháng {{$amountExportAMonth->month}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-dolly"></i>
              </div>
              <a href="{{ route('exportFlower.index')}}" class="small-box-footer">Xem chi tiết <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
		</div>   
		
		   <!-- BAR CHART -->
		   <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Bar Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <div class="chart">
                  <canvas id="barChart" style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
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
	<!-- ChartJS -->
	<!-- <script src="../../plugins/chart.js/Chart.min.js"></script> -->
	<script src="{{ asset('plugins/AdminLTE-3.1.0-rc/plugins/chart.js/Chart.min.js') }}"></script>
	<script src="{{ asset('js/Home.js') }}"></script>
@endpush
