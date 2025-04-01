@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Not Uygulaması Ana Sayfa') }}</div>

                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif

                        <h4>Hoş geldiniz, {{ $user->name }}!</h4>
                        <p>Toplam not sayınız: <strong>{{ $noteCount }}</strong></p>

                        <div class="mt-4">
                            <h5>Son Notlarınız</h5>
                            @if ($notes->count() > 0)
                                <div class="list-group">
                                    @foreach ($notes as $note)
                                        <a href="{{ route('notes.edit', $note) }}"
                                            class="list-group-item list-group-item-action">
                                            <div class="d-flex w-100 justify-content-between">
                                                <h5 class="mb-1">{{ $note->title }}</h5>
                                                <small>{{ $note->created_at->diffForHumans() }}</small>
                                            </div>
                                            <p class="mb-1">{{ \Illuminate\Support\Str::limit($note->content, 100) }}</p>
                                            <small>{{ $note->is_private ? 'Özel' : 'Genel' }}</small>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p>Henüz not oluşturmadınız.</p>
                            @endif
                        </div>

                        <div class="mt-4">
                            <a href="{{ route('notes.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Yeni Not Oluştur
                            </a>
                            <a href="{{ route('notes.index') }}" class="btn btn-secondary">
                                <i class="fas fa-list"></i> Tüm Notlarım
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
