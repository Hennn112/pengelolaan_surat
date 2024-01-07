@extends('layouts.template')
@section('page','/ Data Staff')
@section('content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
    <div class="card-header py-3">
        <a href="{{ route('admin.staff.create') }}" class="m-0 btn btn-primary font-weight-bold text-light">Tambah</a>
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
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($staff as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('admin.staff.edit', $user['id']) }}" class="btn m-1"><i class="fas fa-fw fa-edit"></i></a>
                            <!-- Modal -->
                            @if (Auth::check())
                                @if (Auth::user()->id == $user->id)
                                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$user['id']}}">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>

                                    <div class="modal fade" id="exampleModal-{{$user['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5 text-danger" id="exampleModalLabel">Penghapusan gagal</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Tidak bisa menghapus akun yang sedang login
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @else
                                    <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$user['id']}}">
                                        <i class="fas fa-fw fa-trash"></i>
                                    </button>

                                    <div class="modal fade" id="exampleModal-{{$user['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                                    <form action="{{ route('admin.staff.delete', $user['id']) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </form>
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </td>
                    </tr>
                    <!-- Modal -->

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
