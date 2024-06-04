@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Tambah Data Customer</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('customer-distributor.store') }}" method="POST" class="mb-3" id="customer-form"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="kode" class="form-label-md-6">Kode Customer</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="kode" id="kode" class="form-control"
                                value="{{ $customerCode }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="distributor" class="col-form-label text-md-start">Distributor</label>
                                <div class="col-md-12 {{ $errors->has('distributor') ? 'has-error' : '' }}">
                                    <select name="distributor" id="distributor" class="form-select">
                                        <option selected disabled>Pilih distributor</option>
                                        @foreach ($distributor as $item)
                                            <option value="{{ $item->distributor_id }}"> {{ $item->distributor->distributor_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label-md-6">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="col-form-label text-md-start">Kategori Customer</label>
                                <div class="col-md-12 {{ $errors->has('kategori') ? 'has-error' : '' }}">
                                    <select name="kategori" id="kategori" class="form-select">
                                        <option selected disabled>Pilih Kategori Customer</option>
                                        @foreach ($dtkategori as $kategori)
                                            <option value="{{ $kategori->kategori_customer_id }}">
                                                {{ $kategori->kategori_customer_nama }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="latitude" class="form-label-md-6">Latitude</label>
                                <input type="text" name="latitude" id="latitude" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="depo" class="form-label-md-6">Depo</label>
                                <select name="depo" id="depo" class="form-select">
                                    <option selected disabled>Pilih Depo</option>
                                    @foreach ($distributor as $item)
                                        <option value="{{ $item->depo->depo_id }}">
                                            {{ $item->depo->depo_nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label-md-6">Alamat</label>
                                <textarea name="alamat" id="alamat" class="form-control"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="nomor_hp" class="form-label-md-6">Nomor HP</label>
                                <input type="text" name="nomor_hp" id="nomor_hp" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label for="longtitude" class="form-label-md-6">Longtitude</label>
                                <input type="text" name="longtitude" id="longtitude" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-danger" href="javascript:void(0);"
                                onclick="window.history.back();">Kembali</a>
                            <button class="btn btn-warning" id="submit" type="submit">Tambah</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

        var simpan = "{{ route('customer-depo.store') }}";
        $('#submit').click(function(e) {
            e.preventDefault();
            let distributor = $('#distributor').val();
            let depo = $('#depo').val();
            let kodecustomer = $('#kode').val();
            let nama = $('#nama').val();
            let alamat = $('#alamat').val();
            let kategori = $('#kategori').val();
            let nomor_hp = $('#nomor_hp').val();
            let latitude = $('#latitude').val();
            let longtitude = $('#longtitude').val();
            let token = $("meta[name='csrf-token']").attr("content");

            $.ajax({
                url: simpan,
                type: "POST",
                cache: false,
                data: {
                    "depo": depo,
                    "distributor": distributor,
                    "kode": kodecustomer,
                    "nama": nama,
                    "alamat": alamat,
                    "kategori": kategori,
                    "nomor_hp": nomor_hp,
                    "latitude": latitude,
                    "longtitude": longtitude,
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
                            $('#depo').val('');
                            $('#distributor').val('');
                            $('#kode').val(newcustomerCode);
                            $('#nama').val('');
                            $('#alamat').val('');
                            $('#kategori').val('');
                            $('#nomor_hp').val('');
                            $('#latitude').val('');
                            $('#longtitude').val('');

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
