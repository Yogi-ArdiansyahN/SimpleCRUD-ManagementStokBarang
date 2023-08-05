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
                        <span class="">Tambah Penjualan</span>
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama Barang</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder  ps-2">Kategori</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Harga</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Jumlah</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Total</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Tanggal</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($penjualan->sortByDesc('created_at') as $data)
                            <tr>
                                <td class=" text-uppercase text-dark text-xs font-weight-bold" style="padding-left:25px;">
                                    {{ $data->barang->nama_barang }}
                                </td>
                                <td class="text-uppercase text-dark text-xs font-weight-bold">
                                    {{ $data->kategori->nama_kategori }}
                                </td>
                                <td class=" text-center text-dark text-xs font-weight-bold">
                                    {{ 'Rp. ' . number_format((float)$data->harga, 0, ',', '.') }}
                                </td>
                                <td class=" text-center text-dark text-xs font-weight-bold">
                                    {{ $data->jumlah_barang }}
                                </td>
                                <td class="text-uppercase text-center text-dark text-xs font-weight-bold">
                                    {{ 'Rp. ' . number_format((float)$data->total_harga, 0, ',', '.') }}
                                </td>
                                <td class="text-uppercase text-center text-dark text-xs font-weight-bold">
                                    {{ $data->tanggal_penjualan }}
                                </td>
                                <td class="text-uppercase text-center text-dark text-xs font-weight-bold">
                                    <form action="/hapuspenjualan" method="post">
                                        @csrf
                                        <input type="hidden" name="barang_id" value="{{ $data->barang_id }}">
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <button style="padding: 5px 20px 5px 20px;" type="submit" id="btn-edit" class="btn-edit btn btn-danger btn-sm">Hapus Data</button>
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
                            <h5 class="text-center">Penjualan Barang</h5>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" id="myForm" action="/tambahpenjualan" method="post">
                                @csrf
                                <div class="input-group input-group-outline my-3">
                                    <select name="nama_barang" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off" required>
                                        <option selected disabled>Nama Barang</option>
                                        @foreach ($barang as $data)
                                        @if ($data->harga_jual && $data->stok_barang)
                                        <option value="{{$data->id}}" data-kategori="{{$data->kategori->nama_kategori}}" data-harga="{{ $data->harga_jual }}" data-max-stock="{{ $data->stok_barang }}">
                                            {{ $data->nama_barang }}
                                        </option>
                                        @else

                                        @endif
                                        @endforeach
                                    </select>
                                </div>

                                <div class="input-group input-group-outline my-3">
                                    <input id="kategori" name="kategori_id" type="text" class="form-control" placeholder="Kategori Barang" readonly required>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input id="harga" name="harga_jual" type="text" class="form-control" placeholder="Harga Barang Satuan" required readonly>
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input id="jumlah" name="jumlah" type="number" class="form-control" oninput="calculateTotal()" required autocomplete="off">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <input id="total_harga" name="total_harga" type="text" class="form-control" placeholder="Total Harga" readonly required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" id="submit-btn" class="btn btn-round bg-gradient-info btn-lg w-100 mt-4 mb-0">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Your existing HTML code -->

<script type="text/javascript">
    const namaBarangSelect = document.querySelector('select[name="nama_barang"]');
    const kategoriInput = document.getElementById('kategori');
    const hargaInput = document.getElementById('harga');
    const jumlahInput = document.getElementById('jumlah');
    const totalHargaInput = document.getElementById('total_harga');

    // Function to calculate total harga
    function calculateTotal() {
        const harga = parseFloat(hargaInput.value.replace(/[^\d]/g, '')); // Remove non-numeric characters
        let jumlah = parseFloat(jumlahInput.value);
        const totalHarga = harga * jumlah;

        // Get the maximum stock quantity from the "data-max-stock" attribute of the selected option
        const maxStock = parseFloat(namaBarangSelect.options[namaBarangSelect.selectedIndex].getAttribute('data-max-stock'));

        // Check if the entered jumlah exceeds the maximum stock quantity or is negative
        if (jumlah > maxStock) {
            jumlah = maxStock; // Set jumlah to the maximum stock quantity
        } else if (jumlah < 0) {
            jumlah = 0; // Set jumlah to 0 if it is negative
        }

        jumlahInput.value = jumlah; // Update the input field value
        totalHargaInput.value = formatRupiah(totalHarga);
    }

    // Function to format the number as Rupiah
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            maximumFractionDigits: 0
        }).format(number);
    }

    // Event listener for "Nama Barang" select element
    namaBarangSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const kategori = selectedOption.getAttribute('data-kategori');
        const harga = parseFloat(selectedOption.getAttribute('data-harga').replace(/[^\d]/g, '')); // Remove non-numeric characters

        kategoriInput.value = kategori;
        hargaInput.value = formatRupiah(harga);

        // Get the maximum stock quantity from the "data-max-stock" attribute of the selected option
        const maxStock = parseFloat(selectedOption.getAttribute('data-max-stock'));

        jumlahInput.value = maxStock; // Set the "Jumlah" input to the maximum stock quantity
        calculateTotal();
    });

    // Event listener for "Jumlah" input element
    jumlahInput.addEventListener('input', function() {
        calculateTotal();
    });
</script>





@endsection