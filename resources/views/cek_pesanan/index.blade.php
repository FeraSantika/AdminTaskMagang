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
                                <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-warning">Cek Pesanan</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Cek Pesanan</h4>
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
                                <div class="row mb-2 align-items-end">
                                    <div class="col-sm-2 mt-3">
                                        <a href="#" type="submit" class="btn btn-light mb-2 me-1"
                                            onclick="exportExcel()"><i class="uil-print"></i>
                                            Excel</a>
                                        <a href="#" class="btn btn-primary mb-2 me-1"
                                            onclick="exportPDFWithDates()"><i class="uil-print"></i> PDF</a>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered w-100 table-nowrap mb-0" id="tabelkunjungan">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Depo ID</th>
                                            <th scope="col">Kode Customer</th>
                                            <th scope="col">Nama Customer</th>
                                            <th scope="col">Alamat Customer</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @if ($dtkunjungan->count() > 0)
                                            @foreach ($dtkunjungan as $item)
                                                <tr>
                                                    <td>{{ $rowNumber }}</td>
                                                    <td>{{ $item->customer->depo_id }}</td>
                                                    <td>{{ $item->customer_kode }}</td>
                                                    <td>{{ $item->customer->customer_nama }}</td>
                                                    <td>{{ $item->customer->customer_alamat }}</td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                                @if ($dtpesan->count() > 0 && $dtpesan->where('customer_kode', $item->customer_kode)->count() > 0)
                                                    <tr>
                                                        <th></th>
                                                        <th>No.</th>
                                                        <th>Tanggal transaksi</th>
                                                        <th>Transaksi kode</th>
                                                        <th>Kode Produk</th>
                                                        <th>Nama Produk</th>
                                                        <th>Jumlah</th>
                                                        <th>Satuan</th>
                                                    </tr>
                                                    @php
                                                        $rowProduk = 1;
                                                    @endphp
                                                    @foreach ($dtpesan->where('customer_kode', $item->customer_kode) as $pesan)
                                                        <tr>
                                                            <td></td>
                                                            <td>{{ $rowProduk }}</td>
                                                            <td>{{ $pesan->created_at->format('d-m-Y') }}</td>
                                                            <td>{{ $pesan->transaksi_kode }}</td>
                                                            <td>{{ $pesan->produk_kode }}</td>
                                                            <td>{{ $pesan->produk->produk_nama }}</td>
                                                            <td>{{ $pesan->total_jumlah }}</td>
                                                            <td>{{ $pesan->satuan->satuan_nama }}</td>
                                                        </tr>
                                                        @php
                                                            $rowProduk++;
                                                        @endphp
                                                    @endforeach
                                                @endif
                                                @php
                                                    $rowNumber++;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="8">Tidak ada data kunjungan untuk hari ini</td>
                                            </tr>
                                        @endif
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
@section('script')
    <script>
        function formatDate(dateString) {
            const formattedDate = new Date(dateString).toLocaleDateString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            });
            return formattedDate.split('-').join('-');
        }

        function exportPDFWithDates() {
            var pdfURL = "{{ route('cek-pesanan.export-pdf') }}";

            window.location.href = pdfURL;
        }

        function exportExcel() {

            var excelURL = "{{ route('cek-pesanan.export-excel') }}";

            window.location.href = excelURL;
        }
    </script>
@endsection
