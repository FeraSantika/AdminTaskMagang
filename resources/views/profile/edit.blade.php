@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Profile</h3>
        <div class="content bg-white border">
            <div class="m-5">

                <form action="{{ route('profile.update') }}" method="POST" class="mb-3" enctype="multipart/form-data"
                    id="form-id" name="form-edit-user">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="username" class="form-label-md-6">Username</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="username" id="username" class="form-control"
                                value="{{ $dtUser->User_name }}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="email" class="form-label-md-6">Email</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="email" id="email" class="form-control"
                                value="{{ $dtUser->User_email }}">
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="gender" class="col-md-2 col-form-label text-md-start">Gender</label>
                        <div class="col-md-10 {{ $errors->has('gender') ? 'has-error' : '' }}">
                            <select name="gender" id="gender" class="form-control">
                                <option value="Male" {{ $dtUser->User_gender == 'Male' ? 'selected' : '' }}>Male
                                </option>
                                <option value="Female" {{ $dtUser->User_gender == 'Female' ? 'selected' : '' }}>Female
                                </option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group row mb-3">
                        <label for="photo" class="col-md-2 col-form-label text-md-start">Photo</label>
                        <div class="col-md-10">
                            <input type="file" name="photo" id="photo" class="form-control-file">
                            @if ($dtUser->User_photo)
                                <img src="{{ asset($dtUser->User_photo) }}" width="100px">
                            @endif
                        </div>
                    </div>

                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                            <button class="btn btn-primary" id="submit" type="submit">Edit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
