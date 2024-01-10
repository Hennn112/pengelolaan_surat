@extends('layouts.template')
@section('page','/ Data Klasifikasi / Edit')
@section('content')
<form action="{{ route('admin.klasifikasi.update', $klasifikasi['id']) }}" method="POST" class="card p-5">
    @csrf
    @method('PATCH')

    @if ($errors->any())
        <ul class="alert alert-danger p-3">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <div class="mb-3 row">
        <label for="name" class="col-sm-2 col-form-label">Kode Surat :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="name" name="letter_code" value="{{ ($errors->any()) ? old('letter_code') : substr($klasifikasi['letter_code'],0,- 2) }}">
        </div>
    </div>

    <div class="mb-3 row">
        <label for="email" class="col-sm-2 col-form-label">Email :</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" id="email" name="name_type" value="{{ ($errors->any()) ? old('name_type') : $klasifikasi['name_type'] }}">
        </div>
    </div>

    <button type="submit" class="btn btn-primary mt-3">Ubah Data</button>
</form>
@endsection
