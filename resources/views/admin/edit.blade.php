@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Modifica documento</h1>

    <form action="{{ route('admin.documents.update', $document) }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Titolo</label>
            <input type="text" name="title" class="form-control"
                   value="{{ old('title', $document->title) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>

            <select name="type" class="form-control">
                

                <option value="documento"
                    {{ old('type', $document->type) === 'documento' ? 'selected' : '' }}>
                    Documento
                </option>

                <option value="spese condominiali"
                    {{ old('type', $document->type) === 'spese condominiali' ? 'selected' : '' }}>
                    Spese condominiali
                </option>

                <option value="riunione di condominio"
                    {{ old('type', $document->type) === 'riunione di condominio' ? 'selected' : '' }}>
                    Riunione di condominio
                </option>
            </select>
        </div>


        <div class="mb-3">
            <label class="form-label">Contenuto</label>
            <textarea name="content" class="form-control" rows="5">{{ old('content', $document->content) }}</textarea>
        </div>

        @if($document->image_path)
            <div class="mb-3">
                <p>Immagine attuale:</p>
                <img src="{{ asset($document->image_path) }}"
                    class="img-fluid mb-2" style="max-height: 200px">
            </div>
        @endif


        <div class="mb-3">
            <label class="form-label">Nuova immagine</label>
            <input type="file" name="image" class="form-control">
        </div>

        <button class="btn btn-primary">Salva modifiche</button>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Annulla</a>
    </form>
</div>
@endsection
