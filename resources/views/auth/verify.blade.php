@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('E-posta Adresinizi Doğrulayın') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ __('E-posta adresinize yeni bir doğrulama bağlantısı gönderildi.') }}
                            </div>
                        @endif

                        {{ __('Devam etmeden önce, lütfen e-posta adresinize gönderilen doğrulama bağlantısını kontrol edin.') }}
                        {{ __('E-posta almadıysanız') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn btn-link p-0 m-0 align-baseline">{{ __('Yeni bir bağlantı göndermek için tıklayın') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
