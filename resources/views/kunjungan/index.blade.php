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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Kunjungan</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Kunjungan</h4>
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
                                    <a href="{{ route('kunjungan.create') }}" class="btn btn-primary mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Kunjungan</a>
                                </div>
                                <div class="col-sm-7">
                                    <div class="text-sm-end">
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered w-100 table-nowrap mb-0" id="products-datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th scope="col">ID Kunjungan</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Rute</th>
                                            <th scope="col">Tanggal kunjungan</th>
                                            <th scope="col" style="width: 100px;" class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($dtkunjungan as $item)
                                            <tr>
                                                <td>
                                                    {{ $rowNumber }}
                                                </td>
                                                <td>
                                                    {{ $item->kunjungan_id }}
                                                </td>
                                                <td>
                                                    {{ $item->user->User_name }}
                                                </td>
                                                <td>
                                                    {{ $item->rute->rute_nama }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->kunjungan_tanggal)->format('d-m-Y') }}
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('kunjungan.detail', $item->kunjungan_id) }}"
                                                        class="action-icon">
                                                        <i class="uil-file-search-alt"></i>
                                                    </a>
                                                    <a href="{{ route('kunjungan.edit', $item->kunjungan_id) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-icon"
                                                        onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $item->kunjungan_id }}').submit();">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $item->kunjungan_id }}"
                                                        action="{{ route('kunjungan.destroy', $item->kunjungan_id) }}"
                                                        method="POST">
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
                    <div class="mt-3 text-center">
                        <div class="pagination"></div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div>
@endsection
