@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Tambah Data Produk</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('produk.store') }}" method="POST" class="mb-3">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="kode" class="form-label-md-6">Kode Produk</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="kode" id="kode" class="form-control"
                                value="{{ $produkCode }}" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="nama" class="form-label-md-6">Nama produk</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="nama" id="nama" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                            <button class="btn btn-primary" id="submit" type="submit">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        var simpan = "{{ route('produk.store') }}";
        $('#submit').click(function(e) {
            e.preventDefault();
            let kodeproduk = $('#kode').val();
            let nama = $('#nama').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: simpan,
                type: "POST",
                cache: false,
                data: {
                    "kode": kodeproduk,
                    "nama": nama,
                    "_token": token
                },
                success: function(response) {
                    if (response.error) {
                        swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Mohon gunakan data lain.',
                            showConfirmButton: true,
                        });
                    } else {
                        let newcustomerCode = response.new_kode;
                        if (typeof newcustomerCode !== 'undefined') {
                            $('#kode').val(newcustomerCode);
                            $('#nama').val('');

                            swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data berhasil disimpan.',
                                timer: 1500,
                                showConfirmButton: true,
                            });
                        } else {
                            swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: 'Mohon gunakan data lain.',
                                showConfirmButton: true,
                            });
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText);
                }
            });
        });
    </script>
@endsection
