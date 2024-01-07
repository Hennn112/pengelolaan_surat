@extends ('layouts.template')

@section('page','/ Data Klasifikasi / Tambah')

@section('content')
<form action="{{ route('admin.klasifikasi.store') }}" method="POST" class="card p-5">
    @csrf

    @if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif
    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Kode Surat :</label>
        <div class="col-sm-10">
            <input type="number" class="form-control" id="name" name="letter_code">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Klasifikasi Surat</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="email" name="name_type">
        </div>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Tambah Data</button>
</form>
@endsection
