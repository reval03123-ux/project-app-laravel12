@extends('templates.layoutApp')

@push('style')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tabulator-tables@6.6.1/dist/css/tabulator_bootstrap5.min.css" crossorigin="anonymous" />
@endpush

@section('content')
<!--begin::App Content Header-->
<div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-sm-6">
                <h1 class="mb-0 fs-3">Products</h1>
            </div>
            <div class="col-sm-6">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Products</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content Header-->

<!--begin::App Content-->
<div class="app-content">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Row-->
        <div class="row">
            <div class="col-12">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(isset($errors) && $errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <!--begin::Card-->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daftar Produk</h3>
                        
                        <div class="card-tools d-flex align-items-center gap-2">
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#createProductModal">
                                <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                                Tambah Produk
                            </button>
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-lte-toggle="card-collapse"
                                aria-label="Collapse card">
                                <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                                <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                            </button>
                            <button
                                type="button"
                                class="btn btn-tool"
                                data-lte-toggle="card-remove"
                                aria-label="Remove card">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                            <div class="d-flex gap-2">
                                <button id="export-csv" type="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-filetype-csv me-1" aria-hidden="true"></i>
                                    Export CSV
                                </button>
                                <button id="export-json" type="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-filetype-json me-1" aria-hidden="true"></i>
                                    Export JSON
                                </button>
                                <button id="print-table" type="button" class="btn btn-sm btn-outline-secondary">
                                    <i class="bi bi-printer me-1" aria-hidden="true"></i>
                                    Print
                                </button>
                            </div>
                            <div class="w-auto">
                                <input type="text" id="table-filter" class="form-control form-control-sm" placeholder="Cari nama produk...">
                            </div>
                        </div>

                        <!-- Tabulator target container -->
                        <div id="product-table" aria-label="Products"></div>

                        <div
                            id="table-pagination"
                            class="d-flex flex-wrap gap-2 justify-content-end mt-2"></div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">ZieMarket Products</div>
                    <!-- /.card-footer -->
                </div>
                <!--end::Card-->
            </div>
            <!-- /.col -->
        </div>
        <!--end::Row-->
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->
@endsection

@section('modal')
    @include('product.modal')
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/tabulator-tables@6.6.1/dist/js/tabulator.min.js" crossorigin="anonymous"></script>
<script>
    function deleteProduct(id) {
        if (confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `{{ url('products') }}/${id}`;
            form.innerHTML = `
                <input type="hidden" name="_method" value="DELETE">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        const table = new Tabulator('#product-table', {
            ajaxURL: "{{ route('products.api') }}", // Mengambil data JSON dari Route Laravel
            layout: 'fitColumns',
            filterMode: "local",
            pagination: "local",
            paginationElement: document.getElementById('table-pagination'),
            paginationSize: 10,
            paginationSizeSelector: [10, 25, 50, 100],
            movableColumns: true,
            placeholder: "Tidak ada data produk ditemukan",
            columns: [
                {
                    title: 'ID',
                    field: 'id',
                    width: 70,
                    headerSort: true
                },
                {
                    title: 'Product Name',
                    field: 'name',
                    headerSort: true
                },
                {
                    title: 'Price',
                    field: 'price',
                    formatter: function(cell) {
                        const val = cell.getValue();
                        return val ? 'Rp ' + Number(val).toLocaleString('id-ID') : '-';
                    },
                    headerSort: true
                },
                {
                    title: 'Stock',
                    field: 'stock',
                    width: 100,
                    hozAlign: 'center',
                    headerSort: true
                },
                {
                    title: 'Aksi',
                    field: 'id',
                    formatter: function(cell) {
                        const id = cell.getValue();
                        const editUrl = "{{ url('products') }}/" + id + "/edit";

                        return `
                            <a href="${editUrl}" class="btn btn-sm btn-success">Edit</a>
                            <button onclick="deleteProduct(${id})" class="btn btn-sm btn-danger">Hapus</button>
                        `;
                    },
                    headerSort: false,
                    width: 160,
                    hozAlign: 'center',
                },
            ],
        });

        table.on('tableBuilt', () => {
            const grid = document.getElementById('product-table');
            if (grid) {
                grid.removeAttribute('aria-owns');
                const holder = grid.querySelector('.tabulator-tableholder');
                if (holder) holder.setAttribute('role', 'rowgroup');
                const tbl = grid.querySelector('.tabulator-table');
                if (tbl) tbl.setAttribute('role', 'presentation');
            }
        });

        table.on('renderComplete', () => {
            document.querySelectorAll('#table-pagination button').forEach((button) => {
                button.classList.add('btn', 'btn-sm', 'btn-outline-secondary');
            });
        });

        const filterInput = document.getElementById('table-filter');
        if (filterInput) {
            filterInput.addEventListener('input', (e) => {
                const value = e.target.value;
                if (value) {
                    table.setFilter('name', 'like', value);
                } else {
                    table.clearFilter();
                }
            });
        }

        const exportCsv = document.getElementById('export-csv');
        if (exportCsv) {
            exportCsv.addEventListener('click', () => table.download('csv', 'products.csv'));
        }

        const exportJson = document.getElementById('export-json');
        if (exportJson) {
            exportJson.addEventListener('click', () => table.download('json', 'products.json'));
        }

        const printTable = document.getElementById('print-table');
        if (printTable) {
            printTable.addEventListener('click', () => table.print(false, true));
        }
    });
</script>
@endpush
