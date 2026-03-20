@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Bacheca Documenti</h1>

    @if($documents->isEmpty())
        <p>Nessun documento disponibile.</p>
    @else
        <div class="row g-4">
            @foreach($documents as $doc)
                <div class="col-md-12">
                    <div class="card h-100 shadow-sm">

                        @if($doc->image_path)
                        @php
                            $extension = pathinfo($doc->image_path, PATHINFO_EXTENSION);
                        @endphp

                        @if(in_array($extension, ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset($doc->image_path) }}" class="card-img-top card-img-standard" alt="Immagine">
                        @else
                            <div class="p-3 text-center">
                                <a href="{{ asset($doc->image_path) }}" target="_blank" class="btn btn-outline-primary">
                                    Apri documento
                                </a>
                            </div>
                        @endif
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $doc->title }}</h5>
                            <div>
                                <span class="badge bg-secondary mb-2">{{ $doc->type }}</span>
                            </div>

                            @if($doc->amount)
                                <p class="card-text">
                                    <strong>Importo:</strong> € {{ number_format($doc->amount, 2, ',', '.') }}
                                </p>
                            @endif

                            
                        </div>

                        <div class="card-footer text-muted small">
                            Pubblicato da <strong>{{ $doc->user->name }}</strong><br>
                            {{ $doc->created_at->format('d/m/Y H:i') }}
                            <div>
                                <a href="{{ route('documents.show', $doc) }}" class="btn btn-primary my-end">Visualizza</a>
                            </div>
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
