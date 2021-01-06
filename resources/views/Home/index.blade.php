@extends('welcome')

@push('CssFile')
	<!-- <link href="{{ asset('css/cssHome.css')}}"  rel="stylesheet" > -->
	<link rel="stylesheet" href="{{ asset('plugins/AdminLTE-3.1.0-rc/plugins/fontawesome-free/css/all.min.css') }}">
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
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$countFlower}}</h3>

                <p>Loại hoa</p>
              </div>
              <div class="icon">
                <i class="fab fa-pagelines"></i>
              </div>
              <a href="{{ route('flower.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{$countCustomer}}</h3>

                <p>Khách hàng</p>
              </div>
              <div class="icon">
                <i class="fas fa-user-friends"></i>
              </div>
              <a href="{{ route('customer.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>0</h3>

                <p>Tiền nhập tháng</p>
              </div>
              <div class="icon">
                <i class="far fa-money-bill-alt"></i>
              </div>
              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{$amountAMonth->totalAMonth}}</h3>

                <p>Tiền xuất tháng {{$amountAMonth->month}}</p>
              </div>
              <div class="icon">
                <i class="fas fa-money-bill-alt"></i>
              </div>
              <a href="{{ route('exportFlower.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
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
@endsection

@push('JsFile')
	<!-- ChartJS -->
	<!-- <script src="../../plugins/chart.js/Chart.min.js"></script> -->
	<script src="{{ asset('plugins/AdminLTE-3.1.0-rc/plugins/chart.js/Chart.min.js') }}"></script>
	<script src="{{ asset('js/Home.js') }}"></script>
@endpush
