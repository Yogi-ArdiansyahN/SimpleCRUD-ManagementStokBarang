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
                        <span class="">Tambah Supplier</span>
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder">Nama Supplier</th>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder  ps-2">Alamat</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Kontak</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Brand</th>
                                <th class="text-center text-uppercase text-dark text-xs font-weight-bolder ">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($suppliers->sortByDesc('created_at') as $data)
                            <tr>
                                <td class=" text-uppercase text-dark text-xs font-weight-bold" style="padding-left:25px;">
                                    {{ $data->nama_supplier }}
                                </td>
                                <td class="text-uppercase text-dark text-xs font-weight-bold">
                                    {{ $data->alamat_supplier }}
                                </td>
                                <td class=" text-center text-dark text-xs font-weight-bold">
                                    {{ $data->kontak_supplier }}
                                </td>
                                <td class=" text-center text-dark text-xs font-weight-bold">
                                    {{ $data->brand_supplier }}
                                </td>
                                <td class="text-uppercase text-center text-dark text-xs font-weight-bold">
                                    <button style="padding: 5px 20px 5px 20px;" type="button" id="btn-edit" data-bs-toggle="modal" data-bs-target="#modal-edit-data" data-id="{{$data->id}}" data-nama="{{$data->nama_supplier}}" data-alamat="{{ $data->alamat_supplier }}" data-kontak="{{$data->kontak_supplier}}" data-brand="{{$data->brand_supplier}}" class="btn-edit btn btn-warning btn-sm">Edit Data</button>
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
                            <h5 class="text-center">Tambah Supplier</h5>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" id="myForm" action="/tambahsupplier" method="post">
                                @csrf
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Nama</label>
                                    <input id="nama" name="nama_supplier" type="text" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Alamat</label>
                                    <input id="alamat" name="alamat_supplier" type="text" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Kontak</label>
                                    <input id="alamat" name="kontak_supplier" type="number" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                                </div>
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Brand</label>
                                    <input id="alamat" name="brand_supplier" type="text" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
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


<!-- Modal Edit Data Supplier -->
<div class="modal fade" id="modal-edit-data" tabindex="-1" role="dialog" aria-labelledby="modal-edit-data" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <div class="card card-plain">
                    <div class="card-header pb-0 text-left">
                        <h5 class="text-center">Edit Data Supplier</h5>
                    </div>
                    <div class="card-body">
                        <form role="form text-left" id="editForm" action="/editsupplier" method="post">
                            @csrf
                            <div class="input-group input-group-outline my-3">
                                <input type="hidden" id="edit_id" name="id" class="form-control" readonly>
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <input type="text" id="edit_nama" name="nama_supplier" class="form-control">
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <input type="text" id="edit_alamat" name="alamat_supplier" class="form-control">
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <input type="number" id="edit_kontak" name="kontak_supplier" class="form-control">
                            </div>
                            <div class="input-group input-group-outline my-3">
                                <input type="text" id="edit_brand" name="brand_supplier" class="form-control">
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

<script type="text/javascript">
    const modalEdit = document.getElementById('modal-edit-data');
    const editForm = document.getElementById('editForm');
    const editIdInput = document.getElementById('edit_id');
    const editNamaInput = document.getElementById('edit_nama');
    const editAlamatInput = document.getElementById('edit_alamat');
    const editKontakInput = document.getElementById('edit_kontak');
    const editBrandInput = document.getElementById('edit_brand');

    // Event listener for "Edit Data" button
    const editButtons = document.querySelectorAll('.btn-edit');
    editButtons.forEach((button) => {
        button.addEventListener('click', function() {
            // Get data from the data-* attributes of the button
            const id = this.getAttribute('data-id');
            const nama = this.getAttribute('data-nama');
            const alamat = this.getAttribute('data-alamat');
            const kontak = this.getAttribute('data-kontak');
            const brand = this.getAttribute('data-brand');

            // Fill the input fields in the modal with the data
            editIdInput.value = id;
            editNamaInput.value = nama;
            editAlamatInput.value = alamat;
            editKontakInput.value = kontak;
            editBrandInput.value = brand;

        });
    });
</script>

@endsection