@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $document->title }}</h1>
    <h6 class="text-muted">{{ $document->type }} | Caricato da {{ $document->user->name }} il {{ $document->created_at->format('d/m/Y H:i') }}</h6>

    @if($document->image_path)
        <img src="{{ asset($document->image_path) }}" class="img-fluid detail-img">
    @endif

    <p>{{ $document->content }}</p>

    <a href="{{ route('welcome') }}" class="btn btn-secondary mt-3">Torna indietro</a>
</div>
@endsection
