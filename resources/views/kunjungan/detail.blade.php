@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Detail Data Kunjungan</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <div class="row mb-3">
                    <div class="col-md-4 ">
                        <label for="simpleinput" class="form-label">Tanggal Kunjungan</label>
                    </div>
                    <div class="col-md-8">
                        <label for="simpleinput" class="form-label">:
                            {{ \Carbon\Carbon::parse($kunjungan->kunjungan_tanggal)->format('d-m-Y') }}</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 ">
                        <label for="simpleinput" class="form-label">User</label>
                    </div>
                    <div class="col-md-8">
                        <label for="simpleinput" class="form-label">: {{ $kunjungan->user->User_name }}</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 ">
                        <label for="simpleinput" class="form-label">Rute</label>
                    </div>
                    <div class="col-md-8">
                        <label for="simpleinput" class="form-label">: {{ $kunjungan->rute->rute_nama }}</label>
                    </div>
                </div>

                <div class="row">
                    <div class="mt-1 text-end">
                        <a class="btn btn-dark" href="javascript:void(0);" onclick="history.back();"><i
                                class=" ri-arrow-go-back-fill"></i> Kembali</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="content bg-white border mt-3">
            <h4 class="text-center mt-5">{{ $kunjungan->rute->rute_nama }}</h4>
            <div class="m-5">
                <div class="table-responsive">
                    <table class="table table-centered w-100 table-nowrap mb-0" id="products-datatable">
                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th scope="col">Kode Customer</th>
                                <th scope="col">Nama CUstomer</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $rowNumber = 1;
                            @endphp
                            @foreach ($dtrute as $item)
                                <tr>
                                    <td>
                                        {{ $rowNumber }}
                                    </td>
                                    <td>
                                        {{ $item->customer_kode }}
                                    </td>
                                    <td>
                                        {{ $item->customer->customer_nama }}
                                    </td>
                                </tr>
                                @php
                                    $rowNumber++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
