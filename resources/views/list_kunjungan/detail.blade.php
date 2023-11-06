@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Detail Data Kunjungan</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <div class="row mb-3">
                    <div class="col-md-4 ">
                        <label for="simpleinput" class="form-label"> Kode Customer </label>
                    </div>
                    <div class="col-md-8">
                        <label for="simpleinput" class="form-label">: {{ $dtkunjungan->customer_kode }}</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 ">
                        <label for="simpleinput" class="form-label">Nama Customer </label>
                    </div>
                    <div class="col-md-8">
                        <label for="simpleinput" class="form-label">: {{ $dtkunjungan->customer->customer_nama }}</label>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4 ">
                        <label for="simpleinput" class="form-label">Alamat Customer </label>
                    </div>
                    <div class="col-md-8">
                        <label for="simpleinput" class="form-label">: {{ $dtkunjungan->customer->customer_alamat }}</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="m-3 mb-3 text-start">
                    <a class="btn btn-dark" href="javascript:void(0);" onclick="history.back();"><i
                            class=" ri-logout-box-line"></i> Kembali</a>
                </div>
            </div>
        </div>


        <div class="content bg-white border mt-3">
            <ul class="nav nav-pills bg-nav-pills nav-justified mb-3" id="tab-navigasi">
                <li class="nav-item">
                    <a href="#today" data-bs-toggle="tab" aria-expanded="true" class="nav-link rounded-0 active"
                        style="font-size: larger;">
                        Pesanan Hari Ini
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#previous" data-bs-toggle="tab" aria-expanded="false" class="nav-link rounded-0"
                        style="font-size: larger;">
                        Pesanan Sebelumnya
                    </a>
                </li>
            </ul>
            <div class="tab-content mb-3">
                <div class="tab-pane show active" id="today">
                    <h4 class="text-center mt-5">Pilih Produk</h4>
                    <div class="m-5">
                        <div class="row mb-3">
                            <div class="col-sm-4">
                                <div class="text-end mb-3">
                                    <div class="input-group">
                                        <input type="text" class="typeahead form-control" name="search" id="search"
                                            placeholder="Cari Produk">
                                        <button class="input-group-text btn btn-primary btn-sm" type="button"
                                            id="add"><i class="mdi mdi-magnify search-icon"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="text-end mb-3">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="jumlah" placeholder="Jumlah" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <select name="satuan" id="satuan" class="form-select">
                                    <option value="">PIlih Satuan</option>
                                    @foreach ($dtsatuan as $item)
                                        <option value="{{ $item->satuan_id }}">{{ $item->satuan_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <a href="" class="btn btn-primary mb-2" id="submit-produk"><i
                                        class="mdi mdi-plus-circle me-2"></i> Tambah</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-centered w-100 table-nowrap mb-0" id="tabelkunjungan">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Produk</th>
                                        <th scope="col">Nama Produk</th>
                                        <th scope="col">Jumlah</th>
                                        <th scope="col">Satuan</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="list-produk">
                                    @foreach ($dtlistproduk as $produk)
                                        <tr id="row-{{ $produk->list_id }}">
                                            <td>{{ $produk->produk->produk_kode ?? '' }}</td>
                                            <td>{{ $produk->produk->produk_nama ?? '' }}</td>
                                            <td>{{ $produk->jumlah ?? '' }}</td>
                                            <td>{{ $produk->satuan->satuan_nama ?? '' }}</td>
                                            <td>
                                                <a href="javascript:void(0)" onclick="hapuslist({{ $produk->list_id }})"
                                                    class="action-icon"><i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <form action="{{ route('list-kunjungan.store-list') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control" name="detail_rute_id" id="detail_rute_id"
                                value="{{ $dtkunjungan->detail_rute_id }}"readonly>
                            <input type="hidden" class="form-control" name="customer_kode" id="customer"
                                value="{{ $dtkunjungan->customer->customer_kode }}"readonly>
                            <input type="hidden" class="form-control" name="transaksi_kode" id="transaksi_kode"
                                value="{{ $transaksiCode }}" readonly>
                            <div class="row mt-3">
                                <div class="mt-1 text-end">
                                    <button type="submit" class="btn btn-danger" name="action" value="Toko Tutup">Toko
                                        Tutup</button>
                                    <button type="submit" class="btn btn-success" name="action"
                                        value="Selesai">Selesai</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane" id="previous">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h4 class="header-title">Pesanan Sebelumnya</h4>
                            </div>
                            <div class="inbox-widget">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Tanggal</th>
                                            <th>Kode Transaksi</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($dttransaksi->count() > 0)
                                            @foreach ($dttransaksi as $transaksi)
                                                <tr>
                                                    <td>{{ $transaksi->created_at->format('d-m-y') }}</td>
                                                    <td>{{ $transaksi->transaksi_kode }}</td>
                                                    <td>
                                                        <a href="#" class="btn btn-sm btn-soft-primary font-16"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#primary-header-modal-{{ $transaksi->transaksi_kode }}">
                                                            Detail
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="3" class="text-center">Belum Ada Transaksi</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div> <!-- end inbox-widget -->
                        </div> <!-- end card-body-->
                    </div>

                    <!-- Modal -->
                    @foreach ($dttransaksi as $transaksi)
                        <div id="primary-header-modal-{{ $transaksi->transaksi_kode ?? '' }}" class="modal fade"
                            tabindex="-1" role="dialog" aria-labelledby="primary-header-modalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary">
                                        <h4 class="modal-title text-white" id="standard-modalLabel">
                                            Detail Transaksi {{ $transaksi->transaksi_kode ?? '' }}</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-hidden="true"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="table-responsive">
                                            <table class="table table-centered w-100 table-nowrap mb-0"
                                                id="tabelkunjungan">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Kode Produk</th>
                                                        <th scope="col">Nama Produk</th>
                                                        <th scope="col">Jumlah</th>
                                                        <th scope="col">Satuan</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="list-produk">
                                                    @foreach ($transaksi->listproduk as $produk)
                                                        <tr id="row-">
                                                            <td>{{ $produk->produk_kode ?? '' }}</td>
                                                            <td>{{ $produk->produk->produk_nama ?? '' }}</td>
                                                            <td>{{ $produk->jumlah ?? '' }}</td>
                                                            <td>{{ $produk->satuan->satuan_nama ?? '' }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).on("click", ".btn-detail", function() {
            var kodeTransaksi = $(this).data("kode-transaksi");
            $("#detail-transaksi-title").text(kodeTransaksi);

            $.ajax({
                url: '/get-detail-transaksi',
                type: 'GET',
                data: {
                    kodeTransaksi: kodeTransaksi
                },
                success: function(data) {
                    $("#tabel-detail-transaksi tbody").html(data);
                },
                error: function() {
                    alert('Gagal mengambil data detail transaksi.');
                }
            });

            $("#detail-transaksi").show();
        });
        $(document).ready(function() {
            $("#search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('list-kunjungan.autocomplete') }}",
                        type: 'GET',
                        dataType: "json",
                        data: {
                            cari: request.term
                        },
                        success: function(data) {
                            console.log(data);
                            response(data);
                        }
                    });
                },
                select: function(event, ui) {
                    $('#search').val(ui.item.value);
                    console.log(ui.item);
                    return false;
                }
            });

            $("#submit-produk").click(function() {
                var listproduk = "{{ route('list-kunjungan.insert-list') }}";
                var kode = $("#search").val();
                var customer = $("#customer").val();
                var jumlah = $("#jumlah").val();
                var satuan = $("#satuan").val();
                let token = $("meta[name='csrf-token']").attr("content");

                $.ajax({
                    url: listproduk,
                    type: "POST",
                    cache: false,
                    data: {
                        "customer": customer,
                        "kode": kode,
                        "jumlah": jumlah,
                        "satuan": satuan,
                        "_token": token
                    },
                    dataType: "json",
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil disimpan',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(function() {
                                var newRow = `
                    <tr id="row-${response.data.list_id}">
                        <td>${response.data.produk_kode}</td>
                        <td>${response.data.produk_nama}</td>
                        <td>${response.data.jumlah}</td>
                        <td>${response.data.satuan}</td>
                        <td>
                            <a href="javascript:void(0)" onclick="hapuslist('${response.data.list_id}')" class="action-icon"><i class="mdi mdi-delete"></i></a>
                        </td>
                    </tr>
                `;
                                $("#list-produk").append(newRow);
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi kesalahan saat menyimpan data',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Terjadi kesalahan saat menyimpan data',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    }
                });
                return false;
            });
        });

        function hapuslist(list_id) {
            var url = "{{ route('list-kunjungan.destroy', ':list_id') }}".replace(':list_id', list_id);

            Swal.fire({
                title: "Yakin ingin menghapus data ini?",
                text: "Ketika data terhapus, anda tidak bisa mengembalikan data tersbut!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Ya, Hapus!"
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: url,
                        type: "get",
                        dataType: "JSON",
                        success: function(data) {
                            Swal.fire({
                                toast: true,
                                position: 'top-end',
                                icon: 'success',
                                title: 'Data berhasil dihapus',
                                showConfirmButton: false,
                                timer: 1500
                            });
                            console.log("berhasil hapus data");
                            $("#row-" + list_id).remove();
                            $("#row-" + $produk.list_id).remove();
                        }
                    })
                }
            })
        }
    </script>
@endsection
