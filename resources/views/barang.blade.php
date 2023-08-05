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
                        <span class="">Tambah</span>
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama Barang</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder  ps-2">Supplier</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder  ps-2">Kategori</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Harga Modal Satuan</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Harga Jual</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Stok</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder "> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangs->sortByDesc('created_at') as $data)
                            <tr>
                                <td class=" text-uppercase text-dark text-xs font-weight-bold" style="padding-left:25px;">
                                    {{ $data->nama_barang }}
                                </td>
                                <td class="text-uppercase text-dark text-xs font-weight-bold">
                                    {{ $data->supplier->nama_supplier }} ({{ $data->supplier->brand_supplier }})
                                </td>
                                <td class="text-uppercase text-dark text-xs font-weight-bold">
                                    {{ $data->kategori->nama_kategori }}
                                </td>
                                <td class=" text-center text-dark text-xs font-weight-bold">
                                    {{ 'Rp. ' . number_format((float)$data->harga_modal, 0, ',', '.') }}
                                </td>

                                @if ($data->harga_jual === null)
                                <td class=" text-center text-dark text-xs font-weight-bold">
                                    Rp. 0
                                </td>
                                @else
                                <td class=" text-center text-dark text-xs font-weight-bold">
                                    {{ 'Rp. ' . number_format((float)$data->harga_jual, 0, ',', '.') }}
                                </td>
                                @endif

                                @if($data->stok_barang === null )
                                <td class="text-uppercase text-center text-dark text-xs font-weight-bold">
                                    0
                                </td>
                                @else
                                <td class="text-uppercase text-center text-dark text-xs font-weight-bold">
                                    {{ $data->stok_barang }}
                                </td>
                                @endif

                                <td class="text-uppercase text-center text-dark text-xs font-weight-bold">
                                    <button style="padding: 5px 20px 5px 20px;" type="button" id="btn-edit" data-bs-toggle="modal" data-nama="{{ $data->nama_barang }}" data-kategori="{{ $data->kategori->nama_kategori }}" data-supplier="{{ $data->supplier->id }}" data-hargajual="{{ $data->harga_jual  }}" data-id="{{ $data->id }}" data-bs-target="#modal-edit-data" class="btn-edit btn btn-warning btn-sm">Edit Data</button>
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
                            <h5 class="text-center">Tambah Barang</h5>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" id="myForm" action="/tambahbarang" method="post">
                                @csrf
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Nama Barang</label>
                                    <input id="nama" name="nama_barang" type="text" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <select name="supplier_id" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                                        <option selected disabled>Supplier</option>
                                        @foreach ($suppliers as $data)
                                        <option value="{{$data->id}}" name="supplier_id">{{$data->nama_supplier}} ({{ $data->brand_supplier }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <select id="kategori-select-hitung" name=" kategori_id" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                                        <option selected disabled>Pilih Kategori Barang</option>
                                        @foreach ($kategoris as $data)
                                        <option value="{{$data->id}}" name="kategori_id">{{$data->nama_kategori}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Harga Jual Barang</label>
                                    <input id="harga_jual" name="harga_jual" type="text" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="submit-btn" class=" btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Tambah Barang</button>
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
                            <h5 class="text-center">Edit Data</h5>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" id="" action="/editbarang" method="post">
                                @csrf
                                <div class="input-group input-group-outline my-3">
                                    <input type="hidden" id="id" name="id" class="form-control" readonly>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" id="nama_barang" name="nama_barang" class="form-control">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <select id="supp" name="supplier_id" class="form-control" required autocomplete="off">
                                        <option selected disabled>Supplier</option>
                                        @foreach ($suppliers as $data)
                                        <option value="{{$data->id}}">{{$data->nama_supplier}} ({{ $data->brand_supplier }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <select id="kate" name="kategori_id" class="form-control" required autocomplete="off">
                                        <option selected disabled>Kategori</option>
                                        @foreach ($kategoris as $data)
                                        <option value="{{$data->id}}">{{$data->nama_kategori}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" id="harga_jualan" name="harga_jual" class="form-control" autocomplete="off">
                                </div>

                                <div class="text-center">
                                    <button type="submit" id="submit" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Submit</button>
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
    function formatRupiah(input) {
        // Mengambil nilai input
        let value = input.value;

        // Menghapus semua karakter selain angka
        value = value.replace(/\D/g, '');

        // Jika input tidak kosong, tambahkan format rupiah
        if (value !== '') {
            // Mengubah angka menjadi format rupiah
            value = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(value);
        }

        // Mengganti isi input dengan nilai yang telah diformat
        input.value = value;
    }
</script>


<!-- passing data edit  -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    var btnEdit = document.querySelectorAll('.btn-edit');
    var noId = document.getElementById('id');
    var namaBarang = document.getElementById('nama_barang');
    var hargaJual = document.getElementById('harga_jualan');
    var suppSelect = document.getElementById('supp');
    var kategoriSelect = document.getElementById('kate');

    btnEdit.forEach(function(button) {
        button.addEventListener('click', function() {
            var dataId = this.getAttribute('data-id');
            var dataNama = this.dataset.nama;
            var dataKategori = this.dataset.kategori;
            var dataSupplier = this.dataset.supplier;
            var dataHargaJual = this.dataset.hargajual;
            var formattedNominal = formatRupiah(dataHargaJual);

            noId.value = dataId;
            namaBarang.value = dataNama;
            hargaJual.value = formattedNominal;

            // Menandai pilihan kategori
            var optionsKategori = kategoriSelect.options;
            for (var i = 0; i < optionsKategori.length; i++) {
                if (optionsKategori[i].text === dataKategori) {
                    optionsKategori[i].selected = true;
                    break;
                }
            }

            // Menandai pilihan supplier
            var optionsSupplier = suppSelect.options;
            for (var i = 0; i < optionsSupplier.length; i++) {
                if (optionsSupplier[i].value === dataSupplier) { // Compare with the supplier ID
                    optionsSupplier[i].selected = true;
                    break;
                }
            }

        })
        // Fungsi untuk mengubah nilai menjadi format rupiah
        function formatRupiah(nominal) {
            var reverse = nominal.toString().split('').reverse().join('');
            var thousands = reverse.match(/\d{1,3}/g);
            var formatted = thousands.join('.').split('').reverse().join('');
            return formatted;
        }
    });

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

    // Fungsi untuk mengubah format rupiah saat input diisi (modal Tambah)
    document.getElementById('harga_jual').addEventListener('input', function(e) {
        var input = e.target;
        var hargaSatuan = input.value.replace(/\D/g, '');
        input.value = formatRupiah(hargaSatuan);
    });

    // Fungsi untuk mengubah format rupiah saat input diisi (modal Edit)
    document.getElementById('harga_jualan').addEventListener('input', function(e) {
        var input = e.target;
        var hargaSatuan = input.value.replace(/\D/g, '');
        input.value = formatRupiah(hargaSatuan);
    });
</script>
@endsection