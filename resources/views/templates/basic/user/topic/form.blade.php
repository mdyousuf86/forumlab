@extends($activeTemplate . 'layouts.master')
@section('content')
    <div class="card custom--card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <h6 class="card-title">{{ __($pageTitle) }}</h6>
                <a class="tn btn-outline--base btn--sm" href="{{ route('user.topic.list') }}">
                    <i class="lab la-forumbee"></i> @lang('My Topics')
                </a>
            </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{ route('user.topic.store', @$topic->id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group order-1">
                            <label>@lang('Image')</label>
                            <div class="profile-thumb text-center">
                                <div class="thumb">
                                    <img id="upload-img" src="{{ getImage(getFilePath('topic') . '/' . @$topic->image, getFileSize('topic')) }}" alt="userProfile">
                                    <label class="badge--fill-base update-thumb-icon" for="update-photo"><i class="las la-pen"></i></label>
                                </div>
                                <div class="profile__info">
                                    <input class="form-control d-none" id="update-photo" name="image" type="file">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="form-group">
                            <label>@lang('Forum')</label>
                            <select class="form--control form-select select2-basic" name="subcategory_id" required>
                                <option value="" selected disabled>@lang('Select One')</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}" @selected(old('subcategory_id', @$topic->subcategory_id) == $subcategory->id)>
                                        {{ __(@$subcategory->category->name) }} - {{ __($subcategory->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Title')</label>
                            <input class="form--control" name="title" type="text" value="{{ old('title', @$topic->title) }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>@lang('Tags')</label>
                    <select class="form--control select2-auto-tokenize" name="tags[]" multiple="multiple" required>
                        @if (@$topic->tags)
                            @foreach (@$topic->tags as $tag)
                                <option value="{{ $tag }}" selected>{{ __($tag) }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="form-group">
                    <label>@lang('Video URL')</label>
                    <input class="form--control" name="video" type="text" value="{{ old('video', @$topic->video) }}">
                </div>
                <div class="form-group">
                    <label for="des">@lang('Description')</label>
                    <textarea class="form--control nicEdit" name="description" >{{ old('description',@$topic->description) }}</textarea>
                </div>
                <button class="btn btn--base w-100" type="submit">@lang('Submit')</button>
            </form>
        </div>
    </div>
@endsection

@push('style')
    <style>
        .profile-thumb {
            padding: 2px;
        }

        .profile-thumb .thumb {
            position: relative;
        }

        .profile-thumb .thumb img {
            width: 100%;
            height: 150px;
            border-radius: 5px;
        }

        .badge.badge--icon {
            border-radius: 5px 0 0 0;
        }

        .profile-thumb .update-thumb-icon {
            position: absolute;
            width: 35px;
            height: 35px;
            right: 0;
            bottom: -10px;
            display: grid;
            place-items: center;
            font-size: 18px;
            border-radius: 5px;
        }

        .badge--fill-base {
            background-color: #4380e4;
            border: 1px solid #4380e4;
            color: #fff;
        }

        .select2-container {
            height: 50px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 12px;
        }

        .select2-container .select2-selection--single {
            height: 50px;
        }

        .select2-container--default .select2-selection--single {
            border: 1px solid #d3d3d3;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 50px;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border: solid #4380e4 1px
        }

        .select2-container .select2-selection--multiple {
            min-height: 50px;
        }

        .select2-container--default .select2-selection--multiple {
            border: 1px solid #d3d3d3;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            margin-top: 9px;
        }
    </style>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/global/css/select2.min.css') }}" rel="stylesheet">
@endpush
@push('script-lib')
    <script src="{{ asset('assets/global/js/select2.min.js') }}"></script>
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
            "use strict";
            $(document).on('mouseover ', '.nicEdit-main,.nicEdit-panelContain', function() {
                $('.nicEdit-main').focus();
            });
            const inputField = document.querySelector('#update-photo'),
                uploadImg = document.querySelector('#upload-img');
            inputField.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function() {
                        const result = reader.result;
                        uploadImg.src = result;
                    }
                    reader.readAsDataURL(file);
                }
            });

            $('.select2-basic').select2();
            $(".select2-auto-tokenize").select2({
                tags: true,
                tokenSeparators: [',']
            });
        })(jQuery)
    </script>
@endpush
