<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>History Transaksi</title>
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

        #customer {
            background-color: #e6f7ff;
        }

        #produk {
            background-color: #f2e6ff;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="d-flex align-items-center mb-3">
            <div class="d-flex align-items-center">
                <div class="text-center">
                    <img src="{{ 'data:image/png;base64,' . base64_encode(file_get_contents(base_path('public/assets/images/logo.png'))) }}"
                        alt="image" width="80px"
                        style="display: inline-block; vertical-align: middle; margin-right: 10px;">
                    <h1 style="display: inline-block; vertical-align: middle; margin-right: 10px;">PT Satya Amarta Prima
                    </h1>
                    <h5 style="margin-bottom: 5px; margin-top: 2px">Jl. Villa Melati Mas Raya No.5 Blok B8-1, Jelupang,
                        Serpong Utara, South Tangerang City, Banten 15323</h5>
                    <hr class="my-1" style="height: 2px; background-color: black; width: 100%; margin: 5px 0;">
                    <hr class="my-1">
                </div>
            </div>
            <p>Tanggal: {{ $printedDate }}</p>
        </div>
        <h4>Histori Transaksi</h4>
        <div class="table-responsive">
            <table>
                <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            <th>Tanggal</th>
                                            <th>Transaksi kode</th>
                                            <th>Customer kode</th>
                                            <th>Kode Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Jumlah</th>
                                            <th>Satuan</th>
                                        </tr>
                                    </thead>
                <tbody>
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                            @foreach ($dtpesan as $item)
                                                    @php
                                                        $rowProduk = 1;
                                                    @endphp
                                                        <tr>
                                                            <td>{{ $rowNumber }}</td>
                                                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                                                            <td>{{ $item->transaksi_kode }}</td>
                                                            <td>{{ $item->customer_kode }}</td>
                                                            <td>{{ $item->produk_kode }}</td>
                                                            <td>{{ $item->produk->produk_nama }}</td>
                                                            <td>{{ $item->total_jumlah }}</td>
                                                            <td>{{ $item->satuan->satuan_nama }}</td>
                                                        </tr>
                                                        @php
                                                            $rowProduk++;
                                                        @endphp
                                                @php
                                                    $rowNumber++;
                                                @endphp
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
