@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Kategori Customer</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('kategori_customer.update', Crypt::encryptString($dtkategori->kategori_customer_id)) }}" method="POST"
                    class="mb-3">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Kategori</label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ $dtkategori->kategori_customer_nama }}">
                    </div>

                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                            <button class="btn btn-warning" id="submit" type="submit">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
