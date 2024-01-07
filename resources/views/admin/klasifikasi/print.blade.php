@extends('layouts.template')

@section('page', '/ Data Klasifikasi / Lihat')

@section('content')
<div class="d-sm-flex align-items-center justify-content- mb-0">
    <h1 class="h3 mb-0 text-gray-800">{{ $data['letter_code'] }}</h1>
    <h1 class="h5 mb-0 text-gray-400">| {{ $data['name_type'] }}</h1>
</div>
<div class="row">
    @if ($data->letterType->isNotEmpty())
        @foreach ($data->letterType as $item)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $item->letter_perihal }}</h5>
                        <p class="card-subtitle mb-2 text-muted">{{ $item->created_at->format('d F Y') }}</p>
                        <ul class="list-group list-group-flush">
                            @foreach ($item->recipients as $recipient)
                                <li class="list-group-item">{{ $recipient['name'] }}</li>
                            @endforeach
                        </ul>
                        <a href="{{ route('admin.klasifikasi.pdf', $item['id']) }}" class="btn btn-primary mt-3">
                            <i class="fas fa-fw fa-download"></i> Download
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p></p>
    @endif
</div>
@endsection
