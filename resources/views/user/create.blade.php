@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Tambah Data User</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('user.store') }}" method="POST" class="mb-3" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="username" class="form-label-md-6">Username</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="username" id="username" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="email" class="form-label-md-6">Email</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="email" id="email" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="password" class="form-label-md-6">Password</label>
                        </div>
                        <div class="col-md-10">
                            <input type="password" name="password" id="password" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="gender" class="col-md-2 col-form-label text-md-start">Gender</label>
                        <div class="col-md-10 {{ $errors->has('gender') ? 'has-error' : '' }}">
                            <select name="gender" id="gender" class="form-control">
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="role" class="col-md-2 col-form-label text-md-start">Role</label>
                        <div class="col-md-10 {{ $errors->has('role') ? 'has-error' : '' }}">
                            <select name="role" id="role" class="form-control">
                                @foreach ($dtRole as $item)
                                    <option value="{{ $item->Role_id }}">{{ $item->Role_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="token" class="form-label-md-6">Token</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="token" id="token" class="form-control">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="photo" class="col-md-2 col-form-label text-md-start">Photo</label>
                        <div class="col-md-10">
                            <input type="file" name="photo" id="photo" class="form-control">
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
