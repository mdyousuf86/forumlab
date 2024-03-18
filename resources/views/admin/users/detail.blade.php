@extends('admin.layouts.app')

@section('panel')
    <div class="row">
        <div class="col-12">
            <div class="row gy-4">

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--19">
                        <div class="widget-two__icon b-radius--5 bg--primary">
                            <i class="las la-list-ul"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ getAmount($topic['total_topics']) }}</h3>
                            <p class="text-white">@lang('Total Topics')</p>
                        </div>
                        <a class="widget-two__btn" href="{{ route('admin.topic.list') }}?search={{ $user->username }}">@lang('View All')</a>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--warning">
                        <div class="widget-two__icon b-radius--5 bg--warning">
                            <i class="las la-spinner"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ getAmount($topic['pending_topics']) }}</h3>
                            <p class="text-white">@lang('Pending Topics')</p>
                        </div>
                        <a class="widget-two__btn" href="{{ route('admin.topic.pending') }}?search={{ $user->username }}">@lang('View All')</a>
                    </div>
                </div>
                <!-- dashboard-w1 end -->

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--success">
                        <div class="widget-two__icon b-radius--5 bg--success">
                            <i class="las la-check-circle"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ getAmount($topic['approved_topics']) }}</h3>
                            <p class="text-white">@lang('Approved Topics')</p>
                        </div>
                        <a class="widget-two__btn" href="{{ route('admin.topic.approved') }}?search={{ $user->username }}">@lang('View All')</a>
                    </div>
                </div>

                <div class="col-xxl-3 col-sm-6">
                    <div class="widget-two style--two box--shadow2 b-radius--5 bg--danger">
                        <div class="widget-two__icon b-radius--5 bg--danger">
                            <i class="las la-times-circle"></i>
                        </div>
                        <div class="widget-two__content">
                            <h3 class="text-white">{{ getAmount($topic['rejected_topics']) }}</h3>
                            <p class="text-white">@lang('Rejected Topic')</p>
                        </div>
                        <a class="widget-two__btn" href="{{ route('admin.topic.rejected') }}?search={{ $user->username }}">@lang('View All')</a>
                    </div>
                </div>

            </div>

            <div class="d-flex mt-4 flex-wrap gap-3">

                <div class="flex-fill">
                    <a class="btn btn--primary btn--shadow w-100 btn-lg" href="{{ route('admin.report.login.history') }}?search={{ $user->username }}">
                        <i class="las la-list-alt"></i>@lang('Logins')
                    </a>
                </div>

                <div class="flex-fill">
                    <a class="btn btn--secondary btn--shadow w-100 btn-lg" href="{{ route('admin.users.notification.log', $user->id) }}">
                        <i class="las la-bell"></i>@lang('Notifications')
                    </a>
                </div>

                <div class="flex-fill">
                    <a class="btn btn--primary btn--gradi btn--shadow w-100 btn-lg" href="{{ route('admin.users.login', $user->id) }}" target="_blank">
                        <i class="las la-sign-in-alt"></i>@lang('Login as User')
                    </a>
                </div>

                @if ($user->kyc_data)
                    <div class="flex-fill">
                        <a class="btn btn--dark btn--shadow w-100 btn-lg" href="{{ route('admin.users.kyc.details', $user->id) }}" target="_blank">
                            <i class="las la-user-check"></i>@lang('KYC Data')
                        </a>
                    </div>
                @endif

                <div class="flex-fill">
                    @if ($user->status == Status::USER_ACTIVE)
                        <button class="btn btn--warning btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal" type="button">
                            <i class="las la-ban"></i>@lang('Ban User')
                        </button>
                    @else
                        <button class="btn btn--success btn--gradi btn--shadow w-100 btn-lg userStatus" data-bs-toggle="modal" data-bs-target="#userStatusModal" type="button">
                            <i class="las la-undo"></i>@lang('Unban User')
                        </button>
                    @endif
                </div>
            </div>

            <div class="card mt-30">
                <div class="card-header">
                    <h5 class="card-title mb-0">@lang('Information of') {{ $user->fullname }}</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', [$user->id]) }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('First Name')</label>
                                    <input class="form-control" name="firstname" type="text" value="{{ $user->firstname }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">@lang('Last Name')</label>
                                    <input class="form-control" name="lastname" type="text" value="{{ $user->lastname }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Email') </label>
                                    <input class="form-control" name="email" type="email" value="{{ $user->email }}" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>@lang('Mobile Number') </label>
                                    <div class="input-group">
                                        <span class="input-group-text mobile-code"></span>
                                        <input class="form-control checkUser" id="mobile" name="mobile" type="number" value="{{ old('mobile') }}" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>@lang('Address')</label>
                                    <input class="form-control" name="address" type="text" value="{{ @$user->address->address }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('City')</label>
                                    <input class="form-control" name="city" type="text" value="{{ @$user->address->city }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('State')</label>
                                    <input class="form-control" name="state" type="text" value="{{ @$user->address->state }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Zip/Postal')</label>
                                    <input class="form-control" name="zip" type="text" value="{{ @$user->address->zip }}">
                                </div>
                            </div>

                            <div class="col-xl-3 col-md-6">
                                <div class="form-group">
                                    <label>@lang('Country')</label>
                                    <select class="form-control" name="country">
                                        @foreach ($countries as $key => $country)
                                            <option data-mobile_code="{{ $country->dial_code }}" value="{{ $key }}">{{ __($country->country) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label>@lang('Email Verification')</label>
                                <input name="ev" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" type="checkbox" @if ($user->ev) checked @endif>

                            </div>

                            <div class="form-group col-sm-6">
                                <label>@lang('Mobile Verification')</label>
                                <input name="sv" data-width="100%" data-onstyle="-success" data-offstyle="-danger" data-bs-toggle="toggle" data-on="@lang('Verified')" data-off="@lang('Unverified')" type="checkbox" @if ($user->sv) checked @endif>

                            </div>


                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')
                                    </button>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <div class="modal fade" id="userStatusModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        @if ($user->status == Status::USER_ACTIVE)
                            <span>@lang('Ban User')</span>
                        @else
                            <span>@lang('Unban User')</span>
                        @endif
                    </h5>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </button>
                </div>
                <form action="{{ route('admin.users.status', $user->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        @if ($user->status == Status::USER_ACTIVE)
                            <h6 class="mb-2">@lang('If you ban this user he/she won\'t able to access his/her dashboard.')</h6>
                            <div class="form-group">
                                <label>@lang('Reason')</label>
                                <textarea class="form-control" name="reason" rows="4" required></textarea>
                            </div>
                        @else
                            <p><span>@lang('Ban reason was'):</span></p>
                            <p>{{ $user->ban_reason }}</p>
                            <h4 class="mt-3 text-center">@lang('Are you sure to unban this user?')</h4>
                        @endif
                    </div>
                    <div class="modal-footer">
                        @if ($user->status == Status::USER_ACTIVE)
                            <button class="btn btn--primary h-45 w-100" type="submit">@lang('Submit')</button>
                        @else
                            <button class="btn btn--dark" data-bs-dismiss="modal" type="button">@lang('No')</button>
                            <button class="btn btn--primary" type="submit">@lang('Yes')</button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        (function($) {
            "use strict"

            let mobileElement = $('.mobile-code');
            $('select[name=country]').change(function() {
                mobileElement.text(`+${$('select[name=country] :selected').data('mobile_code')}`);
            });

            $('select[name=country]').val('{{ @$user->country_code }}');
            let dialCode = $('select[name=country] :selected').data('mobile_code');
            let mobileNumber = `{{ $user->mobile }}`;
            mobileNumber = mobileNumber.replace(dialCode, '');
            $('input[name=mobile]').val(mobileNumber);
            mobileElement.text(`+${dialCode}`);

        })(jQuery);
    </script>
@endpush
