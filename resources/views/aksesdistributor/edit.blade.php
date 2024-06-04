@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Distributor</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('akses-distributor.update', $dtaksesdistributor->akses_distributor_id ?? '') }}"
                    method="POST" class="mb-3">
                    @csrf
                    <div class="row mb-3">
                        <label for="user" class="col-md-2 form-label-md-6">Nama User</label>
                        <div class="col-md-10 {{ $errors->has('category') ? 'has-error' : '' }}">
                            <select name="user" id="user" class="form-select">
                                <option value="{{ $dtaksesdistributor->user_id }}">{{ $dtaksesdistributor->user->User_name }}</option>
                                @foreach ($dtuser as $item)
                                    <option value="{{ $item->User_id }}">{{ $item->User_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="distributor" class="col-md-2 col-form-label text-md-start">Nama Distributor</label>
                        <div class="col-md-10 {{ $errors->has('category') ? 'has-error' : '' }}">
                            <select name="distributor" id="distributor" class="form-select">
                                @foreach ($dtdistributor as $item)
                                    <option value="{{ $item->distributor_id }}">{{ $item->distributor_nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mt-3 text-center">
                            <a class="btn btn-danger" href="javascript:void(0);" onclick="history.back();">Kembali</a>
                            <button class="btn btn-warning" id="submit" type="submit">Edit</button>
                        </div>
                    </div>
                </form>
                {{-- @endforeach --}}
            </div>
        </div>
    </div>
@endsection
