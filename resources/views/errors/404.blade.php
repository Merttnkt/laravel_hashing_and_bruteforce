@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="mt-5 mb-5">
                    <div class="display-1 text-danger">
                        <i class="fas fa-exclamation-circle"></i>
                    </div>
                    <h1 class="display-4">Sayfa Bulunamadı</h1>
                    <p class="lead">Aradığınız sayfa mevcut değil veya taşınmış olabilir.</p>
                    <hr class="my-4">
                    <p>Lütfen doğru URL'yi girdiğinizden emin olun veya ana sayfaya dönün.</p>

                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home"></i> Ana Sayfaya Dön
                        </a>
                        @auth
                            <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-sticky-note"></i> Notlarım
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
