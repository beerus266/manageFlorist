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
		
		   <!-- Finance BAR CHART -->
		   <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Tiền nhập/xuất 7 ngày gần nhất</h3>

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
					<!-- FLower BAR CHART -->
		<div class="card card-primary">
			<div class="card-header">
			<h3 class="card-title">Số lượng hoa nhập/xuất </h3>
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
				<div class="row">
					<div class="form-group col-sm-4">
						<div class="input-group">
							<span for="" style="font-weight: bold; margin: auto; margin-right:5%">Chọn ngày:</span>
							<div class="input-group-prepend">
							<span class="input-group-text">
								<i class="fa fa-calendar"></i>
							</span>
							</div>
							<input type="text" class="form-control float-right" name="date" id="date">
						</div>
					</div>
					<div class="col-sm-4">
						<button type="button" class="btn btn-primary" id="quantityFlowerBtn">Thống kê</button>
					</div>
				</div>
				<div class="chart">
					<canvas id="flowerBarChart" style="min-height: 250px; height: 400px; max-height: 400px; max-width: 100%;"></canvas>
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
                    <h4>Hãy chụp lại màn hình và gọi Hải (0393755766) để xử lý.</h4>
                    <p>Có vấn đề khi thực hiện thao tác này....</p>
                  </div>
              </div>
          </div>
      </div>

    <button class="btn btn-primary btn-loading" type="button" disabled >
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Xin chờ...
    </button>
@endsection

@push('JsFile')
	<!-- ChartJS -->
	<!-- <script src="../../plugins/chart.js/Chart.min.js"></script> -->
	<script src="{{ asset('plugins/AdminLTE-3.1.0-rc/plugins/chart.js/Chart.min.js') }}"></script>
	<script src="{{ asset('js/Home.js') }}"></script>
@endpush
