@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upload documento</h1>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Titolo / descrizione:</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>

        <div class="mb-3">
            <label for="type">Tipo di documento:</label>
            <select name="type" class="form-select" id="type" required>
                <option value="documento">Documento</option>
                <option value="spese condominiali">Spese condominiali</option>
                <option value="riunione condominio">Riunione condominio</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="content">Testo del documento:</label>
            <textarea name="content" class="form-control" id="content" rows="8" required></textarea>
        </div>

        <div class="mb-3">
            <label for="image">Immagine (facoltativa):</label>
            <input type="file" name="image" id="image">
        </div>

        <button type="submit">Salva documento</button>
    </form>
</div>
@endsection

