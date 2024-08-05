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
                                <li class="breadcrumb-item active">Rute</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Rute</h4>
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
                                    <a href="{{ route('rute.create') }}" class="btn btn-warning mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Rute</a>
                                </div>
                                <div class="col-sm-7">
                                    <div style="display: flex; justify-content: flex-end;">
                                        <form action="{{ route('rute.import') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div style="display: flex; align-items: center;">
                                                <input type="file" name="file" accept=".xlsx, .csv"
                                                    class="form-control" style="flex: 1; max-width: 200px;">
                                                <button type="submit" class="btn btn-success"
                                                    style="margin-left: 10px;">Import</button>
                                            </div>
                                        </form>
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
                                        <tr>
                                            @foreach ($dtrute as $rute)
                                                <td>{{ $rowNumber }}</td>
                                                <td>
                                                    {{ $rute->rute_nama }}
                                                </td>
                                                <td>
                                                    @foreach ($rute->detail as $namacustomer)
                                                        {{ $namacustomer->customer->customer_nama }}
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="table-action">
                                                    <a href="{{ route('rute.edit', Crypt::encryptString($rute->rute_id)) }}" class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-icon"
                                                        onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $rute->rute_id }}').submit();">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $rute->rute_id }}"
                                                        action="{{ route('rute.destroy', Crypt::encryptString($rute->rute_id)) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>

                                        </tr>
                                        @php
                                            $rowNumber++;
                                        @endphp
                                        @endforeach

                                        {{-- @php
                                            $groupedData = collect($dtdetailrute)->groupBy('rute_id');
                                            $rowNumber = 1;
                                        @endphp

                                        @foreach ($groupedData as $ruteId => $group)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                <td>{{ $group->first()->rute->rute_nama ?? ''}}</td>
                                                <td>
                                                    @foreach ($group as $item)
                                                        {{ $item->customer->customer_nama }}
                                                        @if (!$loop->last)
                                                            ,
                                                        @endif
                                                    @endforeach
                                                </td>
                                                <td class="table-action">
                                                    <a href="{{ route('rute.edit', $group->first()->rute_id) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-icon"
                                                        onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $group->first()->rute_id }}').submit();">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $group->first()->rute_id }}"
                                                        action="{{ route('rute.destroy', $group->first()->rute_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>

                                        @endforeach --}}
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
