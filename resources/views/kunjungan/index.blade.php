@extends('main')
@section('content')
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-warning">Hyper</a></li>
                                <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-warning">Kunjungan</a></li>
                            </ol>
                        </div>
                        <h4 class="page-title">Kunjungan</h4>
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-2">
                                    <a href="{{ route('kunjungan.create') }}" class="btn btn-warning mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add Kunjungan</a>
                                </div>
                                <div class="col-sm-7 d-flex justify-content-end">
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" class="typeahead form-control" name="search"
                                                id="search" placeholder="Cari Sales">
                                            <button class="input-group-text btn btn-warning btn-sm" type="button"
                                                id="search-btn"><i class="uil-search-alt"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div style="display: flex; justify-content: flex-end;">
                                        <form action="{{ route('kunjungan.import') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <div style="display: flex; align-items: center;">
                                                <input type="file" name="file" accept=".xlsx, .csv"
                                                    class="form-control" style="flex: 1; max-width: 200px;">
                                                <button type="submit" class="btn btn-success"
                                                    style="margin-left: 10px;">Import</button>
                                            </div>
                                        </form>
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered w-100 table-nowrap mb-0" id="products-datatable">
                                    <thead class="table-light">
                                        <tr>
                                            <th>No.</th>
                                            {{-- <th>Kunjungan ID</th> --}}
                                            <th scope="col">User</th>
                                            <th scope="col">Rute</th>
                                            <th scope="col">Tanggal kunjungan</th>
                                            <th scope="col" style="width: 100px;" class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="data-kunjungan">
                                        @php
                                            $rowNumber = 1;
                                        @endphp
                                        @foreach ($dtkunjungan as $item)
                                            <tr>
                                                <td>{{ $rowNumber }}</td>
                                                {{-- <td>{{ $item->kunjungan_id }}</td> --}}
                                                <td>
                                                    {{ $item->user->User_name ?? '' }}
                                                </td>
                                                <td>
                                                    {{ $item->rute->rute_nama ?? '' }}
                                                </td>
                                                <td>
                                                    {{ \Carbon\Carbon::parse($item->kunjungan_tanggal)->format('d-m-Y') }}
                                                </td>
                                                <td class="text-end">
                                                    <a href="{{ route('kunjungan.detail', $item->kunjungan_id) }}"
                                                        class="action-icon">
                                                        <i class="uil-file-search-alt"></i>
                                                    </a>
                                                    <a href="{{ route('kunjungan.edit', $item->kunjungan_id) }}"
                                                        class="action-icon">
                                                        <i class="mdi mdi-square-edit-outline"></i>
                                                    </a>
                                                    <a href="javascript:void(0);" class="action-icon"
                                                        onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $item->kunjungan_id }}').submit();">
                                                        <i class="mdi mdi-delete"></i>
                                                    </a>
                                                    <form id="delete-form-{{ $item->kunjungan_id }}"
                                                        action="{{ route('kunjungan.destroy', $item->kunjungan_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                            @php
                                                $rowNumber++;
                                            @endphp
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="mt-3 text-center">
                        <div class="pagination">
                            {{ $dtkunjungan->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div> <!-- end col -->
            </div>
            <!-- end row -->

        </div> <!-- container -->

    </div>
@endsection
@section('script')
    <script type="text/javascript">
        $(document).ready(function() {
            $("#search-btn").click(function() {
                var searchTerm = $("#search").val();
                performSearch(searchTerm);
            });

            function performSearch(searchTerm) {
                $.ajax({
                    url: "{{ route('search.kunjungan') }}",
                    type: 'GET',
                    dataType: "json",
                    data: {
                        cari: searchTerm
                    },
                    success: function(data) {
                        displaySearchResults(data);
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            }

            function displaySearchResults(data) {
                var resultList = "";
                var rowNumber = 1;

                if (data.length > 0) {
                    data.forEach(function(item) {

                        var kunjunganDate = new Date(item.kunjungan_tanggal);

                        var day = kunjunganDate.getDate();
                        var month = kunjunganDate.getMonth() + 1;
                        var year = kunjunganDate.getFullYear();

                        var formattedDate = day + '-' + month + '-' + year;

                        console.log(item),
                            resultList += "<tr id='item.customer_id'>" +
                            "<td>" + rowNumber + "</td>" +
                            // "<td>" + item.kunjungan_id + "</td>" +
                            "<td>" + item.user.User_name + "</td>" +
                            "<td>" + item.rute.rute_nama + "</td>" +
                            "<td>" + formattedDate + "</td>" +
                            "<td><a href='kunjungan/detail/" + item.kunjungan_id +
                            "' class='action-icon'>" +
                            "<i class='uil-file-search-alt'></i></a>" +
                            "<a href='kunjungan/edit/" + item.kunjungan_id + "' class='action-icon'>" +
                            "<i class='mdi mdi-square-edit-outline'></i></a>" +
                            "<a href='javascript:void(0);' class='action-icon delete-kunjungan' data-kunjungan-id='" +
                            item.kunjungan_id + "'>" +
                            "<i class='mdi mdi-delete'></i></a>" +
                            "</td>" +
                            "</tr>";
                        rowNumber++;
                    });
                } else {
                    resultList = "<tr><td colspan='12'>Tidak ada hasil ditemukan.</td></tr>";
                }

                $("#data-kunjungan").html(resultList);

                $('.delete-kunjungan').on('click', function(event) {
                    event.preventDefault();

                    var kunjunganID = $(this).data('kunjungan-id');
                    console.log('Mengklik tombol hapus dengan kunjunganID: ' + kunjunganID);
                    if (confirm(
                            'Anda yakin ingin menghapus customer ini?')) {
                        deletekunjungan(kunjunganID);
                    }
                });

                function deletekunjungan(kunjunganID, deleteButton) {
                    console.log('Mengirim permintaan DELETE untuk kunjunganID: ' + kunjunganID);
                    $.ajax({
                        url: '/admin/kunjungan/destroy/' + kunjunganID,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('customer deleted successfully');
                            var tr = $("#" + kunjunganID);
                            if (tr.length > 0) {
                                tr.remove();
                                location.reload();
                            } else {
                                console.log('Element <tr> not found.');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting customer:', error);
                        }
                    });
                }
            }

            function resetSearchResults() {
                var searchTerm = $("#search").val();
                $("#data-customer").empty();
            }
        });
    </script>
@endsection
