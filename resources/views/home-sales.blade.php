@extends('main')
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <form class="d-flex">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-light" id="dash-daterange">
                                    <span class="input-group-text bg-primary border-primary text-white">
                                        <i class="mdi mdi-calendar-range font-13"></i>
                                    </span>
                                </div>
                            </form>
                        </div>
                        <h4 class="page-title">Dashboard</h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12 col-lg-6">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <a href="{{route('list-kunjungan')}}">
                                        <div class="float-end">
                                            <i class="mdi mdi-account-multiple widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Kunjungan hari ini">
                                            Kunjungan Hari Ini</h5>
                                        <h3 class="mt-3 mb-3">{{$kunjungan}}</h3>
                                    </a>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <a href="{{route('list-kunjungan')}}">
                                        <div class="float-end">
                                            <i class="mdi mdi-home-analytics widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Jumlah toko tutup">Toko Tutup
                                        </h5>
                                        <h3 class="mt-3 mb-3">{{$tokoTutup}}</h3>
                                    </a>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <a href="{{route('list-kunjungan')}}">
                                        <div class="float-end">
                                            <i class="mdi mdi-shopping-outline widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Jumlah Pesanan">Pesanan
                                        </h5>
                                        <h3 class="mt-3 mb-3">{{$pesanan}}</h3>
                                    </a>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <a href="{{route('list-kunjungan')}}">
                                        <div class="float-end">
                                            <i class="ri ri-bank-card-fill widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Jumlah Transaksi Selesai">Transaksi</h5>
                                        <h3 class="mt-3 mb-3">{{$transaksiSelesai}}</h3>
                                    </a>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div> <!-- end row -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end row -->
    </div>
    <!-- container -->
    </div>
@endsection
@section('script')
    <script type="text/javascript"></script>
@endsection
