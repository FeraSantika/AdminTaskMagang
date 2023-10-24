@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Distributor</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('depo.update', $depo->depo_id ?? '') }}" method="POST"
                    class="mb-3">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="nama" class="form-label-md-6">Nama Depo</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="nama" id="nama" class="form-control" value="{{$depo->depo_nama}}">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="category" class="col-md-2 col-form-label text-md-start">Distributor</label>
                        <div class="col-md-10 {{ $errors->has('category') ? 'has-error' : '' }}">
                            <select name="distributor" id="distributor" class="form-control">
                                @foreach ($distributor as $item)
                                    <option value="{{ $item->distributor_id }}">{{ $item->distributor_nama }}
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
                {{-- @endforeach --}}
            </div>
        </div>
    </div>
@endsection
