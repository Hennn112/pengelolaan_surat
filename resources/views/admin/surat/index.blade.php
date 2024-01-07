@extends('layouts.template')
@section('page','/ Data Surat')
@section('content')
 <!-- DataTales Example -->

 <div class="card shadow mb-4">

    @if (Auth::check())
        @if (Auth::user()->role == 'guru')

        @else
            <div class="card-header py-3">
                <a href="{{ route('admin.surat.create') }}" class="m-0 btn btn-primary font-weight-bold text-light">Tambah</a>
                <a href="{{ route('admin.surat.export-excel') }}" class="m-0 btn btn-info font-weight-bold text-light">Export Klasifikasi Surat</a>
            </div>
        @endif
    @endif
    
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
                        <th>Nomor Surat</th>
                        <th>Perihal</th>
                        <th>Tanggal Keluar</th>
                        <th>Penerima Surat</th>
                        <th>Notulis</th>
                        <th>Hasil Rapat</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($surats as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        @if ($data->Letter !== null)
                            <td>{{ $data->Letter->letter_code}}/{{ str_pad($data->id, 4, '0', STR_PAD_LEFT) }}/SMK Wikrama/XII/{{ $data->Letter->first()->created_at->format('Y') }}</td>
                        @else
                            <td class="text-danger">Data Surat Sudah Dihapus!!!</td>
                        @endif

                        <td>{{ $data->letter_perihal }} </td>
                        <td>{{ $data['created_at']->format('d F Y') }}</td>
                        <td>
                            @foreach ($data['recipients'] as $item)
                            {{ $item['name']}} <br>
                            @endforeach
                        </td>
                        <td>{{ $data->user->name }}</td>
                        @if (Auth::check())
                            @if (Auth::user()->role == 'staff')
                                    <td>
                                        @if ($data->Result !== null)
                                            <p class="text-success"> Sudah Dibuat</p>
                                        @else
                                            <p class="text-danger">Belum Dibuat</p>
                                        @endif
                                    </td>
                                    <td class="d-flex justify-content-center">
                                        <a href="{{ route('admin.surat.detail',$data['id']) }}" class="btn m-1"><i class="fas fa-fw fa-eye"></i></a>
                                        <a href="{{ route('admin.surat.edit', $data['id']) }}" class="btn m-1"><i class="fas fa-fw fa-edit"></i></a>
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
                                                <form action="{{ route('admin.surat.delete', $data['id']) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                                </form>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <td>
                                    @if ($data->Result !== null)
                                        <p class="text-success">Sudah Dibuat</p>
                                    @else
                                        @if (Auth::user()->id == $data->notulis)
                                            <a href="{{ route('guru.data.edit',$data['id']) }}" class="btn text-warning">Buat Hasil Rapat</a>
                                        @else
                                            <p class="text-danger">Belum Dibuat</p>
                                        @endif
                                    @endif
                                </td>
                                <td class="d-flex justify-content-center">
                                    <a href="{{ route('guru.data.detail',$data['id']) }}" class="btn m-1"><i class="fas fa-fw fa-eye"></i></a>
                                </td>
                            @endif
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
