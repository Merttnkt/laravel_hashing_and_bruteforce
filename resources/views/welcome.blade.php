@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="mt-5 mb-5">
                    <h1 class="display-4">Not Defteri Uygulaması</h1>
                    <p class="lead">Notlarınızı güvenli bir şekilde saklayın ve istediğiniz zaman erişin</p>
                    <hr class="my-4">
                    <p>Hesabınıza giriş yaparak notlarınızı yönetmeye başlayabilirsiniz.</p>

                    @auth
                        <div class="mt-4">
                            <a href="{{ route('home') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-home"></i> Ana Sayfaya Git
                            </a>
                            <a href="{{ route('notes.create') }}" class="btn btn-success btn-lg">
                                <i class="fas fa-plus"></i> Yeni Not Ekle
                            </a>
                        </div>
                    @else
                        <div class="mt-4">
                            <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-sign-in-alt"></i> Giriş Yap
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-user-plus"></i> Kayıt Ol
                            </a>
                        </div>
                    @endauth
                </div>
        </div>
    </div>
@endsection
