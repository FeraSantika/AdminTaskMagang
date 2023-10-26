@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Kunjungan</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('kunjungan.update', $kunjungan->kunjungan_id) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-4 ">
                            <label for="simpleinput" class="form-label">Tanggal Kunjungan</label>
                        </div>
                        <div class="col-md-8">
                            <input type="date" name="tanggal" id="tanggal" class=" form-control"
                                value="{{ $kunjungan->kunjungan_tanggal }}">
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        <label for="user" class="col-md-4 col-form-label text-md-start">User</label>
                        <div class="col-md-8 {{ $errors->has('user') ? 'has-error' : '' }}">
                            <select name="user" id="user" class="form-select">
                                @foreach ($dtuser as $user)
                                    <option value="{{ $user->User_id }}"
                                        {{ $user->User_id == $kunjungan->user_id ? 'selected' : '' }}>
                                        {{ $user->User_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row form-group mb-3">
                        <label for="rute" class="col-md-4 col-form-label text-md-start">Rute</label>
                        <div class="col-md-8 {{ $errors->has('rute') ? 'has-error' : '' }}">
                            <select name="rute" id="rute" class="form-select">
                                @foreach ($dtrute as $rute)
                                    <option value="{{ $rute->rute_id }}"
                                        {{ $rute->rute_id == $kunjungan->rute_id ? 'selected' : '' }}>
                                        {{ $rute->rute_nama }}
                                    </option>
                                @endforeach
                            </select>
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
@section('style')
    <style>
        @if ($kunjungan->kunjungan_category == 'Sub kunjungan')
            #hidden_div {
                display: block;
            }
        @else
            #hidden_div {
                display: none;
            }
        @endif
    </style>
@endsection
@section('script')
    <script>
        function showDiv(divId, element) {
            document.getElementById(divId).style.display = element.value == 'Sub kunjungan' ? 'block' : 'none';
        }
    </script>
@endsection
