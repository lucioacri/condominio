@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Bacheca Documenti</h1>

    @if($documents->isEmpty())
        <p>Nessun documento disponibile.</p>
    @else
        <div class="row g-4">
            @foreach($documents as $doc)
                <div class="col-md-4">
                    <div class="card h-100 shadow-sm">

                        {{-- Immagine --}}
                        @if($doc->image_path)
                            <img src="{{ asset($doc->image_path) }}" class="card-img-top card-img-standard">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $doc->title }}</h5>
                            <div>
                                <span class="badge bg-secondary mb-2">{{ $doc->type }}</span>
                            </div>

                            <p class="card-text flex-grow-1">
                                {{ Str::limit($doc->content, 120) }}
                            </p>
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
