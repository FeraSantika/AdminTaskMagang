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
                                <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-warning">Hyper</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-warning">Data Master</a></li>
                                <li class="breadcrumb-item active">Depo</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Depo</h4>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
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
                                    <a href="{{ route('depo.create') }}" class="btn btn-warning mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Depo</a>
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
                                            <th>Nama Depo</th>
                                            <th>Nama Distributor</th>
                                            <th style="width: 95px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($dtDepo as $item)
                                            <tr>
                                                <td>
                                                    {{ $rowNumber }}
                                                </td>
                                                <td>
                                                    {{ $item->depo_nama }}
                                                </td>
                                                <td>
                                                    {{ $item->distributor->distributor_nama }}
                                                </td>
                                                <td class="table-action">
                                                    <a href="{{ route('depo.edit', Crypt::encryptString($item->depo_id)) }}" class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-icon"
                                                        onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $item->depo_id }}').submit();">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $item->depo_id }}"
                                                        action="{{ route('depo.destroy', Crypt::encryptString($item->depo_id)) }}" method="POST">
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
