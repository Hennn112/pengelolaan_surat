@extends('layouts.template')

@section('page','/ Data Klasifikasi')

@section('content')
 <!-- DataTales Example -->

 <div class="card shadow mb-4">

    <div class="card-header py-3">
        <a href="{{ route('admin.klasifikasi.create') }}" class="m-0 btn btn-primary font-weight-bold text-light">Tambah</a>
        <a href="{{ route('admin.klasifikasi.export-excel') }}" class="m-0 btn btn-info font-weight-bold text-light">Export Klasifikasi Surat</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                @if(Session::get('deleted'))
                <div class="alert alert-warning"> {{ Session::get('deleted') }} </div>
                @endif
                @if(Session::get('success'))
                    <div class="alert alert-success"> {{ Session::get('success') }} </div>
                @endif

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Surat</th>
                        <th>Klasifikasi Surat</th>
                        <th>Surat Tertaut</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($klasifikasi as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->letter_code }}</td>
                        <td>{{ $data->name_type }}</td>
                        <td>{{ $data->letterType->count()}}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('admin.klasifikasi.print', $data['id']) }}" class="btn m-1"><i class="fas fa-fw fa-eye"></i></a>
                            <a href="{{ route('admin.klasifikasi.edit', $data['id']) }}" class="btn m-1"><i class="fas fa-fw fa-edit"></i></a>
                            <!-- Modal -->
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$data['id']}}">
                                <i class="fas fa-fw fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal-{{$data['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Konfrimasi Kalo Mau Hapus!!</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Apakah anda yakin akan menghapus?
                                </div>
                                <div class="modal-footer">
                                    <form action="{{ route('admin.klasifikasi.delete', $data['id']) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
