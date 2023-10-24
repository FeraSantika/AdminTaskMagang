@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Tambah Data Menu</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('menu.store') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="mb-3">
                        <label for="simpleinput" class="form-label">Nama</label>
                        <input type="text" name="name" id="name" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="category" class="col-md-4 col-form-label text-md-start">Category</label>
                        <div class="col-md-8 {{ $errors->has('category') ? 'has-error' : '' }}">
                            <select name="category" id="category" class="form-control"
                                onchange="showDiv('hidden_div', this)">
                                <option value="Master Menu">Master Menu</option>
                                <option value="Sub Menu">Sub Menu</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-3" id="hidden_div">
                        <label for="submenu" class="col-md-4 col-form-label text-md-start">Sub Menu</label>
                        <div class="col-md-8 {{ $errors->has('submenu') ? 'has-error' : '' }}">
                            <select name="submenu" id="submenu" class="form-control">
                                @foreach ($dtMenu as $item)
                                    <option value="{{ $item->Menu_id }}">{{ $item->Menu_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" name="link" id="link" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" name="position" id="position" class="form-control">
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
@section('style')
    <style>
        #hidden_div {
            display: none;
        }
    </style>
@endsection
@section('script')
    <script>
        function showDiv(divId, element) {
            document.getElementById(divId).style.display = element.value == 'Sub Menu' ? 'block' : 'none';
        }
    </script>
@endsection
