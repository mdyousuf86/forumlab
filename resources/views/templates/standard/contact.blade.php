@extends($activeTemplate . 'layouts.app')
@section('app')
    @php
        $contact = getContent('contact_us.content', true);
        $user = auth()->user();
    @endphp
    @include($activeTemplate . 'partials.header')

    <section class="contact-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="contact-wrapper">
                        <div class="contact-info">
                            <span class="contact-info__shape"><img
                                    src="{{ getImage('assets/images/frontend/contact_us/' . @$contact->data_values->shape_one) }}"
                                    alt="Shape"></span>
                            <h3 class="contact-info__title">{{ __(@$contact->data_values->heading) }}</h3>
                            <p class="contact-info__desc">
                                {{ __(@$contact->data_values->subheading) }}
                            </p>
                            <ul class="contact-info__list">
                                <li class="contact-info__item">
                                    <span class="icon"><i class="las la-phone-volume"></i></span>
                                    <div class="content">
                                        <p class="text"><a class="text-white"
                                                href="tel:{{ @$contact->data_values->contact_number }}">{{ __(@$contact->data_values->contact_number) }}</a>
                                        </p>
                                    </div>
                                </li>
                                <li class="contact-info__item">
                                    <span class="icon"><i class="las la-envelope"></i></span>
                                    <div class="content">
                                        <p>
                                            <a class="text-white"
                                                href="mailto: {{ @$contact->data_values->contact_email }}">{{ __(@$contact->data_values->contact_email) }}</a>
                                        </p>
                                    </div>
                                </li>
                                <li class="contact-info__item">
                                    <span class="icon"><i class="las la-map-marker-alt"></i></span>
                                    <div class="content">
                                        <span class="text">{{ __(@$contact->data_values->contact_address) }}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <form action="" method="post" class="contact-form verify-gcaptcha">
                            @csrf
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="name">@lang('Name')</label>
                                        <input class="form--control"  name="name" type="text"
                                            value="@if (@$user) {{ @$user->fullname }} @else{{ old('name') }} @endif"
                                            @if (@$user) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="email">@lang('Email')</label>
                                        <input class="form--control" id="email" name="email" type="text"
                                            value="@if (@$user) {{ @$user->email }} @else {{ old('email') }} @endif"
                                            @if (@$user) readonly @endif required>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="subject">@lang('Subject')</label>
                                        <input class="form--control" id="subject" name="subject" type="text"
                                            value="{{ old('subject') }}" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="message">@lang('Message')</label>
                                        <textarea class="form--control" id="message" name="message" wrap="off">{{ old('message') }}</textarea>
                                    </div>
                                </div>
                                <x-captcha />
                                <div class="col-12">
                                    <div class="form-group mb-0 text-end">
                                        <button type="submit" class="btn btn--base">@lang('Send Message')</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="contact-map">
                        <iframe src="{{ __(@$contact->data_values->map_url) }}"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include($activeTemplate . 'partials.footer')
@endsection
