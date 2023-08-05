@extends('Layouts.main')
@section('main')
<div style="padding-left:10px;" class="container-fluid">
    <div class="row mb-8 pt-1">
        <div class="col-lg-5 col-md-5 ">
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
                        <span class="">Tambah Kategori</span>
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table align-items-center mb-0">
                        <thead>
                            <tr>
                                <th class="text-uppercase text-dark text-xs font-weight-bolder"><i>Nama Kategori</i></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kategoribarang->sortByDesc('created_at') as $data)
                            <tr>
                                <td class=" text-uppercase text-dark text-xs font-weight-bold" style="padding-left:25px;">
                                    {{ $data->nama_kategori }}
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
                            <h5 class="text-center">Tambah Kategori</h5>
                        </div>
                        <div class="card-body">
                            <form role="form text-left" id="myForm" action="/tambahkategori" method="post">
                                @csrf
                                <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Nama Kategori</label>
                                    <input id="nama" name="nama_kategori" type="text" class="form-control" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
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
@endsection