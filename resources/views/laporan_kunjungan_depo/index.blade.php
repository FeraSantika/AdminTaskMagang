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
                                <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-warning">Laporan Kunjungan</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Laporan Kunjungan</h4>
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
                                    <div class="col">
                                        <label for="tanggalAwal" class="form-label form-inline">Tanggal Awal :</label>
                                        <input type="date" id="tanggalAwal" name="tanggalAwal" class="form-control">
                                    </div>
                                    <div class="col">
                                        <label for="tanggalAkhir" class="form-label form-inline">Tanggal Akhir :</label>
                                        <input type="date" id="tanggalAkhir" name="tanggalAkhir" class="form-control">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="status" class="form-label form-inline">Status :</label>
                                        <select id="pilihStatus" name="status" class="form-control">
                                            <option value="" selected disabled>Pilih Status</option>
                                            <option value="Selesai">Selesai</option>
                                            <option value="Toko Tutup">Toko Tutup</option>
                                            <option value="Pesan">Pesan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for=""></label>
                                        <button type="button" class="btn btn-success"
                                            onclick="tampilkanData()">Filter</button>
                                    </div>
                                    <input type="hidden" id="depo" value="{{ $depo_id }}">
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
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Kode Customer</th>
                                            <th scope="col">Nama Customer</th>
                                            <th scope="col">Alamat Customer</th>
                                            <th scope="col">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @if ($customerDepo->count() > 0)
                                            @foreach ($customerDepo as $item)
                                                <tr>
                                                    <td>
                                                        {{ $rowNumber }}
                                                    </td>
                                                    <td>{{ $item->kunjungan_tanggal }}</td>
                                                    <td>{{ $item->customer_kode }}</td>
                                                    <td>{{ $item->customer_nama }}</td>
                                                    <td>{{ $item->customer_alamat }}</td>
                                                    <td>{{ $item->status }}</td>
                                                </tr>
                                                @php
                                                    $rowNumber++;
                                                @endphp
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4">Tidak ada data kunjungan untuk hari ini</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="mt-3 text-center">
                        <div class="pagination">{{ $customerDepo->links('pagination::bootstrap-4') }}</div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div>
@endsection
@section('script')
    <script>
        function tampilkanData() {
            const pilihStatus = $("#pilihStatus").val();
            const tanggalAwal = $("#tanggalAwal").val();
            const tanggalAkhir = $("#tanggalAkhir").val();
            const depo = $("#depo").val();

            const hasilData = document.getElementById('tabelkunjungan');
            hasilData.innerHTML = '';

            const url =
                `/admin/laporan-kunjungan-depo/get_data?pilihStatus=${pilihStatus}&tanggalAwal=${tanggalAwal}&tanggalAkhir=${tanggalAkhir}&depo=${depo}`;
            fetch(url)
                .then(response => response.json())
                .then(dataTerfilter => {
                    if (dataTerfilter.length > 0) {
                        let tableHTML = '<table class="table table-centered w-100 dt-responsive nowrap">';
                        tableHTML += '<thead>';
                        tableHTML += '<tr>';
                        tableHTML += '<th>Tanggal</th>';
                        tableHTML += '<th>Kode Customer</th>';
                        tableHTML += '<th>Nama Customer</th>';
                        tableHTML += '<th>Alamat Customer</th>';
                        tableHTML += '<th>Status</th>';
                        tableHTML += '</tr>';
                        tableHTML += '</thead>';
                        tableHTML += '<tbody>';

                        dataTerfilter.forEach(item => {
                            console.log(item)
                            tableHTML += '<tr>';
                            tableHTML += `<td>${item.kunjungan_tanggal}</td>`;
                            tableHTML += `<td>${item.customer_kode}</td>`;
                            tableHTML += `<td>${item.customer_nama}</td>`;
                            tableHTML += `<td>${item.customer_alamat}</td>`;
                            tableHTML += `<td>${item.status}</td>`;
                            tableHTML += '</tr>';
                        });

                        tableHTML += '</tbody> </table>';
                        hasilData.innerHTML = tableHTML;
                    } else {
                        hasilData.innerHTML = 'Tidak ada data pada rentang tanggal yang dipilih.';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    hasilData.innerHTML = 'Terjadi kesalahan saat memuat data.';
                });
        }

        function formatDate(dateString) {
            const formattedDate = new Date(dateString).toLocaleDateString('en-GB', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
            });
            return formattedDate.split('-').join('-');
        }

        function exportPDFWithDates() {
            var tanggalAwal = document.getElementById('tanggalAwal').value;
            var tanggalAkhir = document.getElementById('tanggalAkhir').value;
            var pilihStatus = document.getElementById('pilihStatus').value;

            var pdfURL = "{{ route('laporan-kunjungan-depo.export-pdf') }}" + "?tanggalAwal=" + tanggalAwal +
                "&tanggalAkhir=" + tanggalAkhir + "&pilihStatus=" + pilihStatus; // Remove $ sign here

            window.location.href = pdfURL;
        }

        function exportExcel() {
            var tanggalAwal = document.getElementById('tanggalAwal').value;
            var tanggalAkhir = document.getElementById('tanggalAkhir').value;
            var pilihStatus = document.getElementById('pilihStatus').value;

            var excelURL = "{{ route('laporan-kunjungan-depo.export-excel') }}" + "?tanggalAwal=" + tanggalAwal +
                "&tanggalAkhir=" + tanggalAkhir + "&pilihStatus=" + pilihStatus; // Remove $ sign here

            window.location.href = excelURL;
        }
    </script>
@endsection
