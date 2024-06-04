@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Akses Depo</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('akses-depo.update', $dtaksesdepo->akses_depo_id ?? '') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="row mb-3">
                        <label for="user" class="col-md-2 col-form-label text-md-start">Nama User</label>
                        <div class="col-md-10 {{ $errors->has('user') ? 'has-error' : '' }}">
                            <select name="user" id="user" class="form-select">
                                <option value="{{ $dtaksesdepo->user_id }}">{{ $dtaksesdepo->user->User_name }}</option>
                                @foreach ($dtuser as $item)
                                    <option value="{{ $item->User_id }}">{{ $item->User_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="depo" class="col-md-2 col-form-label text-md-start">Nama Depo</label>
                        <div class="col-md-10 {{ $errors->has('depo') ? 'has-error' : '' }}">
                            <select name="depo" id="depo" class="form-select">
                                <option value="{{ $dtaksesdepo->depo_id }}">{{ $dtaksesdepo->depo->depo_nama }}</option>
                                @foreach ($dtdepo as $item)
                                    <option value="{{ $item->depo_id }}">{{ $item->depo_nama }}
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
