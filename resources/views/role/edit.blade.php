@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Role</h3>
        <div class="content bg-white border">
            <div class="m-5">
                {{-- @foreach ($rolemenu as $role) --}}
                <form action="{{ route('role.update', $role->Role_id ?? '') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="name" class="form-label-md-6">Role Name</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" name="name" id="name" value="{{ $role->Role_name }}"
                                class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-2">
                            <label for="menu" class="form-label">Menu</label>
                        </div>
                        <div class="col-md-8">
                            @foreach ($menu as $item)
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="menu{{ $item->Menu_id }}"
                                        name="menu[]" value="{{ $item->Menu_id }}"
                                        @if (in_array($item->Menu_id, (array) $selectedMenuIds)) checked @endif>
                                    <label class="form-check-label"
                                        for="menu{{ $item->Menu_id }}">{{ $item->Menu_name }}</label>
                                </div>
                            @endforeach
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
