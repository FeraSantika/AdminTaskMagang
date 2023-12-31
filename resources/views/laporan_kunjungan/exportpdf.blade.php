<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Laporan Kunjungan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
            margin: 0;
            padding: 0;
        }

        .container {
            margin: 20px;
        }

        .card-title {
            font-size: 20px;
        }

        h4 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            text-align: center;
        }

        tfoot td {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="d-flex align-items-center mb-3">
            <div class="d-flex align-items-center">
                <div class="text-center">
                    {{-- <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents($rs->logo_rumahsakit)) }}"
                        alt="image" width="35px"
                        style="display: inline-block; vertical-align: middle; margin-right: 10px;"> --}}
                    <h1 style="display: inline-block; vertical-align: middle; margin-right: 10px;"></h1>
                    <h5 style="margin-bottom: 5px; margin-top: 2px"></h5>
                    <hr class="my-1" style="height: 2px; background-color: black; width: 100%; margin: 5px 0;">
                    <hr class="my-1">
                </div>
            </div>
            <p>Rentang Tanggal:
                @if ($tglAwal && $tglAkhir)
                    {{ \Carbon\Carbon::parse($tglAwal)->format('d-m-Y') }} hingga
                    {{ \Carbon\Carbon::parse($tglAkhir)->format('d-m-Y') }}
                @else
                    Data tanggal tidak diinputkan
                @endif
            </p>
            <p>Status Kunjungan:
                @if ($pilihStatus)
                    {{ $pilihStatus }}
                @else
                    Semua Status Kunjungan
                @endif
            </p>
        </div>
        <h4>Laporan Kunjungan</h4>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Kode Customer</th>
                        <th scope="col">Nama Customer</th>
                        <th scope="col">Alamat Customer</th>
                        <th scope="col">Status</th>
                    </tr>
                    @if ($dtkunjungan->isEmpty())
                        <tr>
                            <th style="border-top: 1px solid #fff; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @if ($dtkunjungan->isEmpty())
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @foreach ($dtkunjungan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->kunjungan_tanggal }}</td>
                            <td>{{ $item->customer_kode }}</td>
                            <td>{{ $item->customer->customer_nama }}</td>
                            <td>{{ $item->customer->customer_alamat }}</td>
                            <td>{{ $item->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p id="printDate" class="mb-0"></p>
        </div>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentDate = new Date();
            var options = {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            var formattedDate = currentDate.toLocaleDateString('id-ID', options);
            document.getElementById("printDate").innerHTML = formattedDate;
        });
    </script>
</body>

</html>
