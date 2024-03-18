

@extends($activeTemplate . 'layouts.app')
@section('app')
@php
    $banned=getContent('banned.content',true);
@endphp
    <section class="maintenance-page flex-column justify-content-center">
        <div class="container">
            <div class="row justify-content-center align-items-center">
                <div class="col-lg-12 text-center">
                    <div class="row justify-content-center">
                        <div class="col-xl-10">
                            <h4 class="text--danger mb-3">{{ __(@$banned->data_values->heading) }}</h4>
                        </div>
                        <div class="col-sm-6 col-8 col-lg-12">
                            <img class="img-fluid mx-auto mb-3" src="{{ getImage('assets/images/frontend/banned/' . @$banned->data_values->image, '360x370') }}" >
                        </div>
                    </div>
                    <p class="mb-2">@lang('Ban Reason') : {{ __(auth()->user()->ban_reason) }}</p>
                    <a class="btn  btn--base" href="{{ route('home') }}">@lang('Home')</a>
                    <a class="btn btn-outline--base " href="{{ route('user.logout') }}">@lang('Logout')</a>
                </div>
            </div>
        </div>
    </section>
@endsection

