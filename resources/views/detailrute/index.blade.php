@extends('main')
@section('content')
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Hyper</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Data Master</a></li>
                                <li class="breadcrumb-item active">Detail Rute</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Detail Rute</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-5">
                                    <a href="{{ route('detail-rute.create') }}" class="btn btn-primary mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Detail Rute</a>
                                </div>
                                <div class="col-sm-7">
                                    <div class="text-sm-end">
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered w-100 dt-responsive nowrap" id="products-datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama Rute</th>
                                            <th>Nama Customer</th>
                                            <th style="width: 95px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($dtdetailrute as $item)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>{{ $item->rute->rute_nama }}</td>
                                                <td></td>
                                                {{-- <td>{{ $item->customer->customer_nama }}
                                                    @if (!$loop->last)
                                                        ,
                                                    @endif
                                                </td> --}}
                                                <td class="table-action">
                                                    <a href="{{ route('detail-rute.edit', $item->detail_rute_id) }}" class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-icon"
                                                        onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $item->detail_rute_id }}').submit();">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $item->detail_rute_id }}"
                                                        action="{{ route('detail-rute.destroy', $item->detail_rute_id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                            @php
                                                $rowNumber++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div>
@endsection
