@extends('layouts.template')
@section('page','/ Restore / Data Surat')
@section('content')
 <!-- DataTales Example -->

 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#restoreAll">
            <i class="fa fa-undo"></i>Restore All
        </button>
        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAll">
            <i class="fa fa-trash"></i>Delete All
        </button>
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
                @if(Session::get('failed'))
                    <div class="alert alert-danger"> {{ Session::get('failed') }} </div>
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
                                <td class="text-danger">Tidak Tersedia!</td>
                            @endif

                            <td>{{ $data->letter_perihal }} </td>
                            <td>{{ $data['created_at']->format('d F Y') }}</td>
                            <td>
                                @foreach ($data['recipients'] as $item)
                                {{ $item['name']}} <br>
                                @endforeach
                            </td>
                            @if ($data->user !== null)
                            <td>{{ $data->user->name}}</td>
                            @else
                                <td class="text-danger">Data Guru Sudah Dihapus</td>
                            @endif
                            <td>
                                @if ($data->Result !== null)
                                    <p class="text-success"> Sudah Dibuat</p>
                                @else
                                    <p class="text-danger">Belum Dibuat</p>
                                @endif
                            </td>
                            <td class="d-flex justify-content-center">
                                <!-- Modal -->
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#restore-{{$data['id']}}">
                                    <i class="fas fa-fw fa-undo"></i>
                                </button>
                                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$data['id']}}">
                                    <i class="fas fa-fw fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <div class="modal fade" id="restore-{{$data['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-warning" id="exampleModalLabel">Restore</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin akan melakukan restore data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('admin.restore.surats', $data['id']) }}" method="get">
                                            <button type="submit" class="btn btn-success">Restore</button>
                                        </form>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- End Modal -->
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal-{{$data['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5 text-warning" id="exampleModalLabel">Delete</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda yakin akan menghapus data ini?
                                    </div>
                                    <div class="modal-footer">
                                        <form action="{{ route('admin.restore.deletesurat', $data['id']) }}" method="POST">
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
    <div class="modal fade" id="restoreAll" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-warning" id="exampleModalLabel">Restore</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan melakukan restore semua data?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.restore.surats') }}" method="get">
                        <button type="submit" class="btn btn-success">Restore</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteAll" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-warning" id="exampleModalLabel">Delete</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Apakah anda yakin akan menghapus semua data?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('admin.restore.deletesurat') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
