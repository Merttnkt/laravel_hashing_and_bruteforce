@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="mt-5 mb-5">
                    <div class="display-1 text-warning">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h1 class="display-4">Erişim Engellendi</h1>
                    <p class="lead">Bu sayfaya erişim yetkiniz bulunmuyor.</p>
                    <hr class="my-4">
                    <p>Lütfen hesabınızla giriş yapın veya ana sayfaya dönün.</p>

                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home"></i> Ana Sayfaya Dön
                        </a>
                        @guest
                            <a href="{{ route('login') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Giriş Yap
                            </a>
                        @else
                            <a href="{{ route('notes.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="fas fa-sticky-note"></i> Notlarım
                            </a>
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
