@extends($activeTemplate . 'layouts.app')
@section('app')
    @php
        $contact = getContent('contact_us.content', true);
        $user = auth()->user();
    @endphp
    @include($activeTemplate . 'partials.header')

    <section class="conatact-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="contact-wrapper">
                        <div class="text-center">
                            <h2 class="">{{ __(@$contact->data_values->heading) }}</h2>
                            <p>{{ __(@$contact->data_values->subheading) }}</p>
                        </div>
                        <div class="row gy-4 mt-5">
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="las la-map-marker"></i>
                                    <p>{{ __(@$contact->data_values->contact_address) }}</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="las la-phone"></i>
                                    <p><a href="tel:{{ @$contact->data_values->contact_number }}">{{ __(@$contact->data_values->contact_number) }}</a></p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="contact-item">
                                    <i class="las la-envelope"></i>
                                    <p>
                                        <a href="mailto: {{ @$contact->data_values->contact_email }}">{{ __(@$contact->data_values->contact_email) }}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <form class="verify-gcaptcha mt-5" method="post" action="">
                            @csrf
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="name">@lang('Name')</label>
                                    <input class="form--control" id="name" name="name" type="text" value="@if (@$user) {{ @$user->fullname }} @else{{ old('name') }} @endif" @if (@$user) readonly @endif required>
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="email">@lang('Email')</label>
                                    <input class="form--control" id="email" name="email" type="text" value="@if (@$user) {{ @$user->email }} @else {{ old('email') }} @endif" @if (@$user) readonly @endif required>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="subject">@lang('Subject')</label>
                                    <input class="form--control" id="subject" name="subject" type="text" value="{{ old('subject') }}" required>
                                </div>
                                <div class="form-group col-lg-12">
                                    <label for="message">@lang('Message')</label>
                                    <textarea class="form--control" id="message" name="message" wrap="off">{{ old('message') }}</textarea>
                                </div>
                                <x-captcha />
                                <div class="col-lg-12">
                                    <button class="btn btn--gradient w-100" type="submit">@lang('Submit')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include($activeTemplate . 'partials.footer')
@endsection
