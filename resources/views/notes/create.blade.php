@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Yeni Not Oluştur</span>
                        <a href="{{ route('notes.index') }}" class="btn btn-sm btn-secondary">
                            <i class="fas fa-arrow-left"></i> Geri
                        </a>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('notes.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="title" class="form-label">Başlık</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="content" class="form-label">İçerik</label>
                                <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="5"
                                    required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 form-check">
                                <input type="checkbox" class="form-check-input" id="is_private" name="is_private"
                                    value="1" checked>
                                <label class="form-check-label" for="is_private">Özel Not (Sadece ben görebilirim)</label>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Notu Kaydet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
