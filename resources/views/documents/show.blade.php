@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $document->title }}</h1>
    <h6 class="text-muted">{{ $document->type }} | Caricato da {{ $document->user->name }} il {{ $document->created_at->format('d/m/Y H:i') }}</h6>

    @if($document->amount)
    <p><strong>Importo:</strong> € {{ number_format($document->amount, 2, ',', '.') }}</p>
    @endif

    @if($document->image_path)
                        @php
                            $extension = pathinfo($document->image_path, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset($document->image_path) }}" class="card-img-top card-img-standard" alt="Immagine">
                        @else
                            <div class="p-3 text-center">
                                <a href="{{ asset($document->image_path) }}" target="_blank" class="btn btn-outline-primary">Apri documento</a>
                            </div>
                        @endif
                        @endif

    <p>{{ $document->content }}</p>

    <a href="{{ route('welcome') }}" class="btn btn-secondary mt-3">Torna indietro</a>
</div>
@endsection
