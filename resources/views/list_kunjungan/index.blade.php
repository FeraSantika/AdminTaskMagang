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
                                <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-warning">Hyper</a>
                                </li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-warning">List
                                        Kunjungan</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">List Kunjungan</h4>
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
                                <div class="col-12">
                                    <div class="page-title-box">
                                        <div class="page-title-right">
                                            <form class="d-flex">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-light"
                                                        id="dash-daterange">
                                                    <span class="input-group-text bg-primary border-primary text-white">
                                                        <i class="mdi mdi-calendar-range font-13"></i>
                                                    </span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered w-100 table-nowrap mb-0" id="tabelkunjungan">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            {{-- <th>Depo ID</th> --}}
                                            <th scope="col">Kode Customer</th>
                                            <th scope="col">Nama Customer</th>
                                            <th scope="col">Alamat Customer</th>
                                            <th scope="col">Action</th>
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
                                                    {{-- <td>{{ $item->customer->depo_id }}</td> --}}
                                                    <td>{{ $item->customer_kode }}</td>
                                                    <td>{{ $item->customer->customer_nama }}</td>
                                                    <td>{{ $item->customer->customer_alamat }}</td>
                                                    <td>
                                                        <a href="{{ route('list-kunjungan.detail', Crypt::encryptString($item->customer_kode)) }}"
                                                            class="btn btn-soft-info">Detail</a>
                                                        {{-- @if ($item->status == 'Selesai')
                                                            <span class="badge bg-success">{{ $item->status }}</span>
                                                        @elseif ($item->status == 'Toko Tutup')
                                                            <span class="badge bg-danger">{{ $item->status }}</span>
                                                        @else
                                                            <a href="{{ route('list-kunjungan.detail', $item->detail_rute_id) }}"
                                                                class="btn btn-soft-info">Detail</a>
                                                        @endif --}}
                                                    </td>
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
        function tampilkanData() {
            const pilihSales = $("#pilihSales").val();
            const tanggalAwal = $("#tanggalAwal").val();
            const tanggalAkhir = $("#tanggalAkhir").val();

            const hasilData = document.getElementById('tabelkunjungan');
            hasilData.innerHTML = '';

            const url =
                `/admin/cek-kunjungan/get_data?pilihSales=${pilihSales}&tanggalAwal=${tanggalAwal}&tanggalAkhir=${tanggalAkhir}`;
            fetch(url)
                .then(response => response.json())
                .then(dataTerfilter => {
                    if (dataTerfilter.length > 0) {
                        let tableHTML = '<table class="table table-centered w-100 dt-responsive nowrap">';
                        tableHTML += '<thead>';
                        tableHTML += '<tr>';
                        tableHTML += '<th>User</th>';
                        tableHTML += '<th>Rute</th>';
                        tableHTML += '<th>Tanggal Kunjungan</th>';
                        tableHTML += '</tr>';
                        tableHTML += '</thead>';
                        tableHTML += '<tbody>';

                        dataTerfilter.forEach(item => {
                            console.log(item)
                            tableHTML += '<tr>';
                            tableHTML += `<td>${item.user.User_name}</td>`;
                            tableHTML += `<td>${item.rute.rute_nama}</td>`;
                            tableHTML += `<td>${formatDate(item.kunjungan_tanggal)}</td>`;
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
            var pilihSales = document.getElementById('pilihSales').value;

            var pdfURL = "{{ route('cek-kunjungan.export-pdf') }}" + "?tanggalAwal=" + tanggalAwal +
                "&tanggalAkhir=" +
                tanggalAkhir;

            if (pilihSales) {
                pdfURL += "&pilihSales=" + pilihSales;
            }

            window.location.href = pdfURL;
        }

        function exportExcel() {
            var tanggalAwal = document.getElementById('tanggalAwal').value;
            var tanggalAkhir = document.getElementById('tanggalAkhir').value;
            var pilihSales = document.getElementById('pilihSales').value;

            var excelURL = "{{ route('cek-kunjungan.export-excel') }}" + "?tanggalAwal=" + tanggalAwal +
                "&tanggalAkhir=" + tanggalAkhir;

            if (pilihSales) {
                excelURL += "&pilihSales=" + pilihSales;
            }

            window.location.href = excelURL;
        }
    </script>
@endsection
