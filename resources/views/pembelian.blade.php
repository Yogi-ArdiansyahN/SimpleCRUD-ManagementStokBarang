@extends('Layouts.main')
@section('main')
<div style="padding-left:10px" class="container-fluid">
    <div class="row mb-4 pt-1">
        <div class="col-lg-12 col-md-8 ">
            @if(session()->has('error'))
            <div class="mb-2 alert alert-danger alert-dismissible fade show" role="alert">
                <a style="color:white;">{{ session('error') }}</a>
                <button style="color:white;" type="button" class="btn-close" data-bs-dismiss="alert">X</button>
            </div>
            @endif
            @if(session()->has('warning'))
            <div class="mb-2 alert alert-warning alert-dismissible fade show" role="alert">
                <a style="color:white;">{{ session('warning') }}</a>
                <button style="color:white;" type="button" class="btn-close" data-bs-dismiss="alert">X</button>
            </div>
            @endif
            @if(session()->has('success'))
            <div class="mb-2 alert alert-success alert-dismissible fade show" role="alert">
                <a style="color:white;">{{ session('success') }}</a>
                <button style="color:white;" type="button" class="btn-close" data-bs-dismiss="alert">X</button>
            </div>
            @endif
            <div class="card">
                <div class="col-auto mt-3" style="margin-left: 10px; display: flex; justify-content: flex-start; gap: 10px;">
                    <button class="btn btn-block btn-icon btn-3 btn-success" type="button" data-bs-toggle="modal" data-bs-target="#modal-form">
                        <i class="fa-solid fa-plus"></i>
                        <span class="">Tambah Pembelian</span>
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama Barang</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder  ps-2">Kategori</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder  ps-2">Supplier</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Harga Barang</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Jumlah Beli</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Total Harga</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder "> Tanggal Beli </th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder "> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembelians->sortByDesc('created_at') as $data)
                            <tr>
                                <td class=" text-uppercase text-dark text-xs font-weight-bold" style="padding-left:25px;">
                                    {{ $data->barang->nama_barang }}
                                </td>
                                <td class="text-uppercase text-dark text-xs font-weight-bold">
                                    {{ $data->barang->kategori->nama_kategori }}
                                </td>
                                <td class="text-uppercase text-dark text-xs font-weight-bold">
                                    {{ $data->barang->supplier->nama_supplier }} ({{ $data->barang->supplier->brand_supplier }})
                                </td>
                                <td class=" text-center text-dark text-xs font-weight-bold">
                                    {{ 'Rp. ' . number_format((float)$data->harga_beli, 0, ',', '.') }}
                                </td>
                                <td class=" text-center text-dark text-xs font-weight-bold">
                                    {{ $data->jumlah_beli }}
                                </td>
                                <td class="text-uppercase text-center text-dark text-xs font-weight-bold">
                                    {{ 'Rp. ' . number_format((float)$data->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="text-uppercase text-center text-dark text-xs font-weight-bold">
                                    {{ $data->tanggal_pembelian }}
                                </td>
                                <td class="text-uppercase text-center text-dark text-xs font-weight-bold">
                                    <button style="padding: 5px 20px 5px 20px; margin:0 0 5px 0;" type="button" id="btn-edit" data-bs-toggle="modal" data-bs-target="#modal-edit-data" data-id="{{ $data->id }}" data-nama="{{ $data->barang->nama_barang }}" data-kategori="{{ $data->barang->kategori->id }}" data-supplier="{{ $data->barang->supplier->id }}" data-harga="{{ $data->harga_beli }}" data-jumlahbeli="{{ $data->jumlah_beli }}" data-totalharga="{{ $data->total_harga }}" class="btn-edit btn btn-warning btn-sm">Edit </button>
                                    <form action="/hapuspembelian" method="post">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <button style="padding: 5px 20px 5px 20px; margin:0px;" type="submit" id="btn-edit" class="btn-edit btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah -->
<div class="col-md-4">
    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-left">
                            <h5 class="text-center">Pembelian Barang</h5>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" id="myForm" action="/tambahpembelian" method="post">
                                @csrf
                                <div class="input-group input-group-outline my-3">
                                    <select id="barang" name="barang_id" class="form-control" required autocomplete="off" onchange="updateSupplierAndKategori()">
                                        <option selected> Pilih Barang </option>
                                        @foreach ($barang as $data)
                                        <option value="{{ $data->id }}" data-supplier="{{ $data->supplier->nama_supplier }}" data-kategori="{{ $data->kategori->nama_kategori }}">{{ $data->nama_barang }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input id="supplier" name="supplier_id" type="text" class="form-control" required autocomplete="off" placeholder="Supplier" readonly>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input id="kategori" name="kategori_id" type="text" class="form-control" required autocomplete="off" placeholder="Kategori Barang" readonly>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Harga Barang</label>
                                    <input id="harga_modal" name="harga_beli" type="text" class="form-control" required autocomplete="off">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Jumlah Beli</label>
                                    <input id="jumlah_beli" name="jumlah_beli" type="number" class="form-control" oninput="calculateTotal()" required autocomplete="off">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input id="total_harga" name="total_harga" type="text" class="form-control" placeholder="Total Pembelian" readonly>
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="submit-btn" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Beli Barang</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Data -->
<div class="col-md-4">
    <div class="modal fade" id="modal-edit-data" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-left">
                            <h5 class="text-center">Edit Data Pembelian</h5>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" id="" action="/editpembelian" method="post">
                                @csrf
                                <div class="input-group input-group-outline my-3">
                                    <input type="hidden" id="id" name="id" class="form-control" readonly>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" id="nama_barang" name="nama_barang" class="form-control" autocomplete="off">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <select id="kate" name="kategori_id" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                                        @foreach ($kategoris as $data)
                                        <option value="{{$data->id}}" name="kategori_id">{{$data->nama_kategori}} </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <select id="supp" name="supplier_id" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                                        @foreach ($suppliers as $data)
                                        <option value="{{ $data->id }}" name="supplier_id">{{ $data->nama_supplier }} ({{ $data->brand_supplier }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" id="hrg_beli" name="harga_beli" class="form-control" autocomplete="off">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input type="number" id="jml_beli" name="jumlah_beli" class="form-control" oninput="totalan()" autocomplete="off">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" id="ttl_harga" name="total_harga" class="form-control" autocomplete="off" readonly>
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="submit" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Edit Data Pembelian</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk mengubah angka menjadi format rupiah
    function formatRupiah(angka) {
        var numberString = angka.toString();
        var sisa = numberString.length % 3;
        var rupiah = numberString.substr(0, sisa);
        var ribuan = numberString.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            var separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }

    // Fungsi untuk mengubah format rupiah saat input diisi
    document.getElementById('harga_modal').addEventListener('input', function(e) {
        var input = e.target;
        var hargaSatuan = input.value.replace(/\D/g, '');
        input.value = formatRupiah(hargaSatuan);
        calculateTotal();
    });

    // Fungsi untuk menghitung total harga dan mengisi nilai pada input total_harga
    function calculateTotal() {
        var hargaSatuan = parseInt(document.getElementById('harga_modal').value.replace(/\D/g, ''));
        var jumlahBeli = parseInt(document.getElementById('jumlah_beli').value.replace(/\D/g, ''));
        var totalHarga = hargaSatuan * jumlahBeli;
        document.getElementById('total_harga').value = formatRupiah(totalHarga);
    }
</script>

<script>
    function updateSupplierAndKategori() {
        var selectBarang = document.getElementById('barang');
        var selectedOption = selectBarang.options[selectBarang.selectedIndex];

        var supplierInput = document.getElementById('supplier');
        var kategoriInput = document.getElementById('kategori');

        var supplierValue = selectedOption.getAttribute('data-supplier');
        var kategoriValue = selectedOption.getAttribute('data-kategori');

        supplierInput.value = supplierValue;
        kategoriInput.value = kategoriValue;
    }
</script>

<!-- Passing Data Edit -->
<!-- JavaScript code -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    // Define the variable to store the buttons with class 'btn-edit'
    var btnEdit = document.querySelectorAll('.btn-edit');

    var noId = document.getElementById('id');
    var barang = document.getElementById('nama_barang');
    var kategori = document.getElementById('kate');
    var supplier = document.getElementById('supp'); // Corrected ID to 'supp'
    var jmlBeli = document.getElementById('jml_beli'); // Corrected typo in ID
    var hrgBeli = document.getElementById('hrg_beli');
    var ttlHarga = document.getElementById('ttl_harga');

    // Add event listeners to the buttons
    btnEdit.forEach(function(button) {
        button.addEventListener('click', function() {
            var dataId = this.getAttribute('data-id');
            var dataNama = this.dataset.nama;
            var dataKategori = this.dataset.kategori;
            var dataSupplier = this.dataset.supplier;
            var dataHarga = this.dataset.harga;
            var dataJmlBeli = this.dataset.jumlahbeli;
            var dataTtlHarga = this.dataset.totalharga;
            var formattedNominal = formatRupiah(dataTtlHarga);
            var formattedHarga = formatRupiah(dataHarga);

            noId.value = dataId;
            barang.value = dataNama;
            // kategori.selectedOption = dataKategori;
            // supplier.selectedOption = dataSupplier; // Corrected ID to 'supp'
            jmlBeli.value = dataJmlBeli; // Corrected typo in ID
            hrgBeli.value = formattedHarga;
            ttlHarga.value = formattedNominal;

            // Auto-select the 'kategori' option based on 'dataKategori'
            $("#kate option").each(function() {
                if ($(this).val() === dataKategori) {
                    $(this).prop("selected", true);
                } else {
                    $(this).prop("selected", false);
                }
            });

            // Auto-select the 'supplier' option based on 'dataSupplier'
            $("#supp option").each(function() {
                if ($(this).val() === dataSupplier) {
                    $(this).prop("selected", true);
                } else {
                    $(this).prop("selected", false);
                }
            });
        });
    });

    // Fungsi untuk mengubah nilai menjadi format rupiah
    function formatRupiah(nominal) {
        var reverse = nominal.toString().split('').reverse().join('');
        var thousands = reverse.match(/\d{1,3}/g);
        var formatted = thousands.join('.').split('').reverse().join('');
        return formatted;
    }

    // Fungsi untuk mengubah format rupiah saat input diisi
    document.getElementById('hrg_beli').addEventListener('input', function(e) {
        var input = e.target;
        var hrgbeli = input.value.replace(/\D/g, '');
        input.value = formatRupiah(hrgbeli);
        calculateTotalEdit();
    });

    // Fungsi untuk menghitung total harga dan mengisi nilai pada input total_harga
    function calculateTotalEdit() {
        var hrg = parseInt(document.getElementById('hrg_beli').value.replace(/\D/g, ''));
        var jml = parseInt(document.getElementById('jml_beli').value.replace(/\D/g, ''));
        var ttl = hrg * jml;
        document.getElementById('ttl_harga').value = formatRupiah(ttl);
    }
</script>

@endsection