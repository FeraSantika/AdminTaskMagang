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
                                    <a href="">
                                        <div class="float-end">
                                            <i class="mdi mdi-account-multiple widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">
                                            Distributor</h5>
                                        <h3 class="mt-3 mb-3"></h3>
                                    </a>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <a href="">
                                        <div class="float-end">
                                            <i class="mdi mdi-doctor widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Depo
                                        </h5>
                                        <h3 class="mt-3 mb-3"></h3>
                                    </a>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <a href="">
                                        <div class="float-end">
                                            <i class="mdi mdi-pill widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Average Revenue">User
                                        </h5>
                                        <h3 class="mt-3 mb-3"></h3>
                                    </a>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col-sm-6">
                            <div class="card widget-flat">
                                <div class="card-body">
                                    <a href="">
                                        <div class="float-end">
                                            <i class="mdi mdi-hospital-building widget-icon"></i>
                                        </div>
                                        <h5 class="text-muted fw-normal mt-0" title="Growth">Menu</h5>
                                        <h3 class="mt-3 mb-3"></h3>
                                    </a>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div> <!-- end row -->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="d-flex card-header justify-content-between align-items-center">
                            <h4 class="header-title">Jumlah User</h4>
                        </div>
                        <div class="card-body pt-0">
                            <div class="chart-content-bg">
                                <div class="row text-center">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="">
                                                    <p class="text-muted mb-0 mt-3">User</p>
                                                    <h2 class="fw-normal mb-3">
                                                        <small
                                                            class="mdi mdi-checkbox-blank-circle text-primary align-middle me-1"></small>
                                                        <span></span>
                                                    </h2>
                                                </a>
                                            </div>
                                            <div class="col-sm-6 mt-3">
                                                <p class="text-start"><small
                                                        class="mdi mdi-checkbox-blank-circle text-info align-middle me-1"></small>User <b></b></p>
                                                <p class="text-start"><small
                                                        class="mdi mdi-checkbox-blank-circle text-danger align-middle me-1"></small>User <b></b></p>
                                                <p class="text-start"><small
                                                        class="mdi mdi-checkbox-blank-circle text-warning align-middle me-1"></small>User <b></b></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <a href="">
                                                    <p class="text-muted mb-0 mt-3">User</p>
                                                    <h2 class="fw-normal mb-3">
                                                        <small
                                                            class="mdi mdi-checkbox-blank-circle text-success align-middle me-1"></small>
                                                        <span></span>
                                                    </h2>
                                                </a>
                                            </div>
                                            <div class="col-sm-6 mt-3">
                                                <p class="text-start"><small
                                                        class="mdi mdi-checkbox-blank-circle text-info align-middle me-1"></small>User <b></b></p>
                                                <p class="text-start"><small
                                                        class="mdi mdi-checkbox-blank-circle text-danger align-middle me-1"></small>User <b></b></p>
                                                <p class="text-start"><small
                                                        class="mdi mdi-checkbox-blank-circle text-warning align-middle me-1"></small>User <b></b></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div dir="ltr">
                                <div id="chart" class="apex-charts mt-3" data-colors="#727cf5,#0acf97"></div>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
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