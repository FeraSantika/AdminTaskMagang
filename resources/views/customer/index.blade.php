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
                                <li class="breadcrumb-item"><a href="javascript: void(0);" class="text-warning">Data Master</a></li>
                                <li class="breadcrumb-item active">Customer</li>
                            </ol>
                        </div>
                        <h4 class="page-title">Customer</h4>
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
                                    <a href="{{ route('customer.create') }}" class="btn btn-warning mb-2"><i
                                            class="mdi mdi-plus-circle me-2"></i> Add customer</a>
                                </div>
                                <div class="col-sm-5"></div>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" class="typeahead form-control" name="search" id="search"
                                            placeholder="Cari customer">
                                        <button class="input-group-text btn btn-warning btn-sm" type="button"
                                            id="search-btn"><i class="uil-search-alt"></i></button>
                                    </div>
                                </div><!-- end col-->
                            </div>

                            <div class="card-body pt-0">
                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">Kode customer</th>
                                                <th scope="col">Nama customer</th>
                                                <th scope="col">Kategori customer</th>
                                                <th scope="col">Nomor Hp</th>
                                                <th scope="col">Alamat</th>
                                                <th scope="col">Latitude</th>
                                                <th scope="col">Longtitude</th>
                                                <th scope="col">Distributor</th>
                                                <th scope="col">Depo</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="data-customer">
                                            @php
                                                $rowNumber = 1;
                                            @endphp
                                            @foreach ($dtcustomer as $item)
                                                <tr id="{{ $item->customer_id }}">
                                                    <td>{{ $rowNumber }}</td>
                                                    <td>{{ $item->customer_kode }}</td>
                                                    <td>{{ $item->customer_nama }}</td>
                                                    <td>{{ $item->kategori->kategori_customer_nama }}</td>
                                                    <td>{{ $item->customer_nomor_hp }}</td>
                                                    <td>{{ $item->customer_alamat }}</td>
                                                    <td>{{ $item->latitude }}</td>
                                                    <td>{{ $item->longtitude }}</td>
                                                    <td>{{ $item->distributor->distributor_nama ?? '' }}</td>
                                                    <td>{{ $item->depo->depo_nama ?? '' }}</td>
                                                    <td class="text-end">
                                                        <a href="{{ route('customer.edit', Crypt::encryptString($item->customer_id)) }}"
                                                            class="action-icon">
                                                            <i class="mdi mdi-square-edit-outline"></i>
                                                        </a>
                                                        <a href="{{ route('customer.destroy', $item->customer_id) }}"
                                                            class="action-icon"
                                                            onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin menghapus?')) document.getElementById('delete-form-{{ $item->customer_id }}').submit();">
                                                            <i class="mdi mdi-delete"></i>
                                                        </a>
                                                        <form id="delete-form-{{ $item->customer_id }}"
                                                            action="{{ route('customer.destroy', Crypt::encryptString($item->customer_id)) }}"
                                                            method="POST" style="display: none;">
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
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="mt-3 text-center">
                        <div class="pagination">
                            {{ $dtcustomer->links('pagination::bootstrap-4') }}
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
                    url: "{{ route('search.customer') }}",
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
                        console.log(item.kategori),
                            resultList += "<tr id='item.customer_id'>" +
                            "<td>" + rowNumber + "</td>" +
                            "<td>" + item.customer_kode + "</td>" +
                            "<td>" + item.customer_nama + "</td>" +
                            "<td>" + item.kategori.kategori_customer_nama + "</td>" +
                            "<td>" + item.customer_nomor_hp + "</td>" +
                            "<td>" + item.customer_alamat + "</td>" +
                            "<td>" + item.latitude + "</td>" +
                            "<td>" + item.longtitude + "</td>" +
                            "<td>" + item.distributor.distributor_nama + "</td>" +
                            "<td>" + item.depo.depo_nama + "</td>" +
                            "<td><a href='customer/edit/" + item.customer_id + "' class='action-icon'>" +
                            "<i class='mdi mdi-square-edit-outline'></i></a>" +
                            "<a href='javascript:void(0);' class='action-icon delete-customer' data-customer-id='" +
                            item.customer_id + "'>" +
                            "<i class='mdi mdi-delete'></i></a></td>" +
                            "</tr>";
                        rowNumber++;
                    });
                } else {
                    resultList = "<tr><td colspan='12'>Tidak ada hasil ditemukan.</td></tr>";
                }

                $("#data-customer").html(resultList);

                $('.delete-customer').on('click', function(event) {
                    event.preventDefault();

                    var customerId = $(this).data('customer-id');
                    console.log('Mengklik tombol hapus dengan customerId: ' + customerId);
                    if (confirm(
                            'Anda yakin ingin menghapus customer ini?')) {
                        deletecustomer(customerId);
                    }
                });

                function deletecustomer(customerId, deleteButton) {
                    console.log('Mengirim permintaan DELETE untuk customerId: ' + customerId);
                    $.ajax({
                        url: '/admin/customer/destroysearch/' + customerId,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log('customer deleted successfully');
                            var tr = $("#" + customerId);
                            if (tr.length > 0) {
                                tr.remove();
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
