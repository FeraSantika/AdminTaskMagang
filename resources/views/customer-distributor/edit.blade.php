@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Customer</h3>
        <div class="content bg-white border">
            <div class="m-5">

                <form action="{{ route('customer-distributor.update', Crypt::encryptString($dtcustomer->customer_id)) }}" method="POST" class="mb-3"
                    id="customer-form" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="kode" class="form-label-md-6">Kode customer</label>
                        </div>
                        <div class="col-md-4">
                            <input type="text" name="kode" id="kode" class="form-control"
                                value="{{ $dtcustomer->customer_kode }}" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="distributor" class="col-form-label text-md-start">Distributor</label>
                                <div class="col-md-12 {{ $errors->has('distributor') ? 'has-error' : '' }}">
                                    <select name="distributor" id="distributor" class="form-select">
                                        <option value="{{$dtcustomer->distributor_id}}">{{$dtcustomer->distributor->distributor_nama ?? ''}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label-md-6">Nama</label>
                                <input type="text" name="nama" id="nama" class="form-control"
                                    value="{{ $dtcustomer->customer_nama }}">
                            </div>
                            <div class="mb-3">
                                <label for="kategori" class="col-form-label text-md-start">Kategori</label>
                                <div class="col-md-12 {{ $errors->has('kategori') ? 'has-error' : '' }}">
                                    <select name="kategori" id="kategori" class="form-select">
                                        <option value="{{ $dtcustomer->kategori_customer_id }}" selected>
                                            {{ $dtcustomer->kategori->kategori_customer_nama }}
                                        </option>
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
                                <input type="text" name="latitude" id="latitude" class="form-control"
                                    value="{{ $dtcustomer->latitude }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="depo" class="form-label-md-6">Depo</label>
                                <select name="depo" id="depo" class="form-select">
                                    <option value="{{$dtcustomer->depo_id}}">{{$dtcustomer->depo->depo_nama ?? ''}}</option>
                                </select>
                                <input type="hidden" name="depo_id" id="depo_id">
                            </div>
                            <div class="mb-3">
                                <label for="alamat" class="form-label-md-6">Alamat</label>
                                <input type="text" name="alamat" id="alamat" class="form-control"
                                    value="{{ $dtcustomer->customer_alamat }}">
                            </div>
                            <div class="mb-3">
                                <label for="nomor_hp" class="form-label-md-6">Nomor HP</label>
                                <input type="text" name="nomor_hp" id="nomor_hp" class="form-control"
                                    value="{{ $dtcustomer->customer_nomor_hp }}">
                            </div>
                            <div class="mb-3">
                                <label for="longtitude" class="form-label-md-6">Longtitude</label>
                                <input type="text" name="longtitude" id="longtitude" class="form-control"
                                    value="{{ $dtcustomer->longtitude }}">
                            </div>
                        </div>
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
@section('script')
    <script>
    </script>
@endsection
