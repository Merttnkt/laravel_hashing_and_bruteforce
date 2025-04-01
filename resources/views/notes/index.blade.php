@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Notlarım</span>
                    <a href="{{ route('notes.create') }}" class="btn btn-sm btn-primary">Yeni Not</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($notes->isEmpty())
                        <p class="text-center">Henüz not eklenmemiş.</p>
                    @else
                        <div class="list-group">
                            @foreach ($notes as $note)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="mb-1">{{ $note->title }}</h5>
                                        <small>{{ $note->created_at->format('d.m.Y H:i') }}</small>
                                        <p class="mb-1">{{ Str::limit($note->content, 100) }}</p>
                                        @if ($note->is_private)
                                            <span class="badge bg-secondary">Özel</span>
                                        @else
                                            <span class="badge bg-success">Genel</span>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('notes.edit', $note) }}" class="btn btn-sm btn-info">Düzenle</a>
                                        <form action="{{ route('notes.destroy', $note) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bu notu silmek istediğinize emin misiniz?')">Sil</button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection