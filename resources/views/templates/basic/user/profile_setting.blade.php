@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <h5>{{ __($pageTitle) }}</h5>
        </div>
        <div class="card-body">
            <form class="register prevent-double-click" action="" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('First Name')</label>
                            <input class="form--control" name="firstname" type="text" value="{{ $user->firstname }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('Last Name')</label>
                            <input class="form--control" name="lastname" type="text" value="{{ $user->lastname }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('E-mail Address')</label>
                            <input class="form--control" value="{{ $user->email }}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('Mobile Number')</label>
                            <input class="form--control" value="{{ $user->mobile }}" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('Address')</label>
                            <input class="form--control" name="address" type="text" value="{{ @$user->address->address }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('State')</label>
                            <input class="form--control" name="state" type="text" value="{{ @$user->address->state }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('Zip Code')</label>
                            <input class="form--control" name="zip" type="text" value="{{ @$user->address->zip }}" required>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('City')</label>
                            <input class="form--control" name="city" type="text" value="{{ @$user->address->city }}" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('Country')</label>
                            <input class="form--control" value="{{ @$user->address->country }}" disabled>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>@lang('Image')</label>
                            <input class="form--control profilePicUpload" name="image" type="file" accept=".jpg, .jpeg, .png">
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>@lang('About Yourself')</label>
                            <textarea class="form--control nicEdit" name="about" rows="5">@php echo $user->about @endphp</textarea>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn--base w-100" type="submit">@lang('Update Profile')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script-lib')
    <script src="{{ asset('assets/global/js/nicEdit.js') }}"></script>
@endpush

@push('script')
    <script>
        bkLib.onDomLoaded(function() {
            $(".nicEdit").each(function(index) {
                $(this).attr("id", "nicEditor" + index);
                new nicEditor({
                    fullPanel: true
                }).panelInstance('nicEditor' + index, {
                    hasPanel: true
                });
            });
        });
        (function($) {
            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });

            function proPicURL(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        var preview = $('.user-sidebar').find('.profilePicPreview');
                        $(preview).attr('src', e.target.result);
                        $(preview).hide();
                        $(preview).fadeIn(650);
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".profilePicUpload").on('change', function() {
                proPicURL(this);
            });


        })(jQuery);
    </script>
@endpush
