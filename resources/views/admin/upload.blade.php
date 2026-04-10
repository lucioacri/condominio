@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Upload documento</h1>

    @if(session('success'))
        <div style="color:green;">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.upload') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="title" class="form-label">Descrizione breve:</label>
            <input type="text" class="form-control" name="title" id="title" required>
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Importo complessivo:</label>
            <input type="decimal" class="form-control" name="amount" id="amount" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Numero partecipanti</label>
            <input type="number" 
                name="participants" 
                class="form-control" 
                min="1">
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
            <label for="file">File (facoltativo):</label>
            <input type="file" name="file" id="image">
        </div>

        <button type="submit">Salva documento</button>
    </form>
</div>
@endsection

