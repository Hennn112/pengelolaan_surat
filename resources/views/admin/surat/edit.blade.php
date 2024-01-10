@extends('layouts.template')
@section('page','/ Data Surat / Edit')
@section('content')
<div class="container">
    <form action="{{ route('admin.surat.update', $surats['id']) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        @if ($errors->any())
            <ul class="alert alert-danger p-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
        <div class="d-flex justify-content-start">
            <div class="form-group">
                <label for="exampleFormControlInput1">Perihal</label>
                <input type="text" class="form-control" style="width: 480px" id="exampleFormControlInput1" name="letter_perihal" value="{{ ($errors->any()) ? old('letter_perihal') : $surats['letter_perihal'] }}">
            </div>
            <div class="form-group">
                <label for="exampleFormControlInput1">Klasifikasi Surat</label>
                <select name="letter_type_id" class="form-control" style="width: 480px">
                    @foreach ($type as $data)
                    <option value="{{ $data['id'] }}">{{ $data->name_type }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-group">
            <label for="exampleFormControlTextarea1">Isi Surat</label>
            <textarea id="myeditorinstance" name="content" placeholder="Ini Wajib Diisi"></textarea>
        </div>
        <table class="table table-striped table-bordered">
            <tr>
                <th>Nama</th>
                <th>Perserta(Ceklis jika ya)</th>
            </tr>
            @foreach ($role as $item)
            <tr>
                <td>{{ $item->name }}</td>
                <td>
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" value="{{ $item['id'] }}" id="flexCheckChecked" name="recipients[]">
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
        <div class="form-group">
            <label for="exampleFormControlFile1">Lampiran</label>
            <input type="file" class="form-control" id="exampleFormControlFile1" name="attachment" value="{{ $surats['attachment'] }}">
        </div>
        <div class="form-group">
            <label for="exampleFormControlInput1">Notulis</label>
            <select name="notulis" class="form-control" style="width: 480px" placeholder="Pilih Notulis">
                @foreach ($role as $data)
                <option value="{{ $data['id'] }}" class="form">{{ $data->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary float-right">Submit</button>
    </form>
</div>

@endsection
