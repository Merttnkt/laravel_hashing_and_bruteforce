@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <div class="mt-5 mb-5">
                    <div class="display-1 text-danger">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <h1 class="display-4">Sunucu Hatası</h1>
                    <p class="lead">Üzgünüz, bir sorun oluştu.</p>
                    <hr class="my-4">
                    <p>Sunucumuz şu anda işleminizi gerçekleştiremiyor. Lütfen daha sonra tekrar deneyin.</p>

                    <div class="mt-4">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-home"></i> Ana Sayfaya Dön
                        </a>
                        <a href="javascript:window.location.reload();" class="btn btn-outline-secondary btn-lg">
                            <i class="fas fa-sync"></i> Sayfayı Yenile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
