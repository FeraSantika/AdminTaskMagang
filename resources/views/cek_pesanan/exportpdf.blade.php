<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>Laporan Pesanan</title>
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
                    <h1 style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                        Nama Perusahaan</h1>
                    <h5 style="margin-bottom: 5px; margin-top: 2px">Alamat Perusahaan ||
                        Nomor Telepon ||
                        Kode Pos</h5>
                    <hr class="my-1" style="height: 2px; background-color: black; width: 100%; margin: 5px 0;">
                    <hr class="my-1">
                </div>
            </div>
            <p>Tanggal: {{ $printedDate }}</p>
        </div>
        <h4>Laporan Pesanan</h4>
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th scope="col">Kode Customer</th>
                        <th scope="col">Nama Customer</th>
                        <th scope="col">Alamat Customer</th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                    @if ($dtkunjungan->isEmpty())
                        <tr>
                            <th style="border-top: 1px solid #fff; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                            <th style="border-top: 1px solid #000; border-bottom: 1px solid #fff;"></th>
                        </tr>
                    @endif
                </thead>
                <tbody>
                    @php
                        $rowNumber = 1;
                    @endphp
                    @if ($dtkunjungan->isEmpty())
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @endif
                    @if ($dtkunjungan->count() > 0)
                        @foreach ($dtkunjungan as $item)
                            <tr>
                                <td>{{ $rowNumber }}</td>
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
                            <td colspan="4">Tidak ada data kunjungan untuk hari ini</td>
                        </tr>
                    @endif
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
