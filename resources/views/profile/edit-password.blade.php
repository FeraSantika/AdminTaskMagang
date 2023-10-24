@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Password</h3>
        <div class="content bg-white border">
            <div class="m-5">

                <form action="{{ route('profile.update-password') }}" method="post">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="current_password" class="form-label-md-6">Current Password:</label>
                        </div>
                        <div class="col-md-10">
                            <input type="password" name="current_password" id="current_password" class="form-control"
                                value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="new_password" class="form-label-md-6">New Password:</label>
                        </div>
                        <div class="col-md-10">
                            <input type="password" name="new_password" id="new_password" class="form-control"
                                value="">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="new_password_confirmation" class="form-label-md-6">Confirm New Password:</label>
                        </div>
                        <div class="col-md-10">
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control"
                                value="">
                        </div>
                    </div>
                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                            <button class="btn btn-primary" id="submit" type="submit">Edit Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
