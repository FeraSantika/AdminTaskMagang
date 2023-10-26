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
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Cek Kunjungan</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Cek Kunjungan</h4>
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
                                    <div class="col-md-2">
                                        <label for="pilihSales" class="form-label form-inline">Pilih User :</label>
                                        <select id="pilihSales" name="pilihSales" class="form-control">
                                            <option value="">Pilih User</option>
                                            @foreach ($dtsales as $item)
                                                <option value="{{ $item->User_id }}">{{ $item->User_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for=""></label>
                                        <button type="button" class="btn btn-success"
                                            onclick="tampilkanData()">Filter</button>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered w-100 table-nowrap mb-0" id="tabelkunjungan">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th scope="col">ID Kunjungan</th>
                                            <th scope="col">User</th>
                                            <th scope="col">Rute</th>
                                            <th scope="col">Tanggal kunjungan</th>
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
@section('script')
    <script>
        function tampilkanData() {
            const pilihSales = $("#pilihSales").val();

            const hasilData = document.getElementById('tabelkunjungan');
            hasilData.innerHTML = '';

            const url =
                `/admin/cek-kunjungan/get_data?pilihSales=${pilihSales}`;
            fetch(url)
                .then(response => response.json())
                .then(dataTerfilter => {
                    if (dataTerfilter.length > 0) {
                        let tableHTML = '<table class="table table-centered w-100 dt-responsive nowrap">';
                        tableHTML += '<thead>';
                        tableHTML += '<tr>';
                        tableHTML += '<th>ID Kunjungan</th>';
                        tableHTML += '<th>User</th>';
                        tableHTML += '<th>Rute</th>';
                        tableHTML += '<th>Tanggal Kunjungan</th>';
                        tableHTML += '</tr>';
                        tableHTML += '</thead>';
                        tableHTML += '<tbody>';

                        dataTerfilter.forEach(item => {
                            console.log(item)
                            tableHTML += '<tr>';
                            tableHTML += `<td>${item.kunjungan_id}</td>`;
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
    </script>
@endsection
