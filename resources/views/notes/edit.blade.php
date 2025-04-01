@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Notu Düzenle</span>
                        <a href="{{ route('notes.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Geri
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('notes.update', $note) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">Başlık</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title', $note->title) }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">İçerik</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5"
                                    required>{{ old('content', $note->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_private" name="is_private"
                                    value="1" {{ $note->is_private ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_private">Özel Not (Sadece ben görebilirim)</label>
                            </div>

                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Notu Güncelle
                                </button>

                                <form action="{{ route('notes.destroy', $note) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Bu notu silmek istediğinize emin misiniz?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash"></i> Notu Sil
                                    </button>
                                </form>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
