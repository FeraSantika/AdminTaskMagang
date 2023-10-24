@extends('main')
@section('content')
    <div class="container mt-3">
        <h3>Edit Data Menu</h3>
        <div class="content bg-white border">
            <div class="m-5">
                <form action="{{ route('menu.update', $dtMenu->Menu_id) }}" method="POST" class="mb-3">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama</label>
                        <input type="text" value="{{ $dtMenu->Menu_name }}" name="name" id="name"
                            class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="category" class="col-md-4 col-form-label text-md-start">Category</label>
                        <div class="col-md-8 {{ $errors->has('category') ? 'has-error' : '' }}">
                            <select name="category" id="category" class="form-control"
                                onchange="showDiv('hidden_div', this)">
                                <option value="Master Menu" {{ $dtMenu->Menu_category == 'Master Menu' ? 'selected' : '' }}>
                                    Master Menu
                                </option>
                                <option value="Sub Menu" {{ $dtMenu->Menu_category == 'Sub Menu' ? 'selected' : '' }}>
                                    Sub Menu</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group mb-3" id="hidden_div">
                        <label for="submenu" class="col-md-4 col-form-label text-md-start">Sub Menu</label>
                        <div class="col-md-8 {{ $errors->has('submenu') ? 'has-error' : '' }}">
                            <select name="submenu" id="submenu" class="form-control">
                                @foreach ($menu as $item)
                                    <option value="{{ $item->Menu_id }}">{{ $item->Menu_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="link" class="form-label">Link</label>
                        <input type="text" name="link" id="link" class="form-control"
                            value="{{ $dtMenu->Menu_link }}">
                    </div>

                    <div class="mb-3">
                        <label for="position" class="form-label">Position</label>
                        <input type="text" name="position" id="position" class="form-control"
                            value="{{ $dtMenu->Menu_position }}">
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
        @if ($dtMenu->Menu_category == 'Sub Menu')
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
            document.getElementById(divId).style.display = element.value == 'Sub Menu' ? 'block' : 'none';
        }
    </script>
@endsection
