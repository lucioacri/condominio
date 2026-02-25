@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Admin</h1>

    @if(auth()->user()->isAdmin())
        <div class="mb-4">
            <a href="{{ route('admin.upload') }}" class="btn btn-primary">Carica Nuovo Documento</a>
        </div>
    @endif

    @if($documents->isEmpty())
        <p>Nessun documento caricato.</p>
    @else
        <div class="row g-4">
            @foreach($documents as $doc)
                <div class="col-md-12">
                    <div class="card h-100 shadow-sm" >
                        @if($doc->image_path)
                            <img src="{{ asset($doc->image_path) }}" class="card-img-top card-img-standard" alt="Immagine">
                        @endif

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $doc->title }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $doc->type }}</h6>
                            <p class="card-text flex-grow-1">{{ Str::limit($doc->content, 100) }}</p>
                        </div>
                        <div class="card-footer text-muted">
                            Caricato da {{ $doc->user->name }} <br>
                            {{ $doc->created_at->format('d/m/Y H:i') }}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('documents.show', $doc) }}" class="btn btn-primary">Visualizza</a>
                                
                                <a href="{{ route('admin.documents.edit', $doc) }}" class="btn btn-warning">Modifica</a>
                                
                                <form action="{{ route('admin.documents.destroy', $doc) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger"
                                        onclick="return confirm('Sei sicuro di voler eliminare questo documento?')">
                                        Elimina
                                    </button>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection