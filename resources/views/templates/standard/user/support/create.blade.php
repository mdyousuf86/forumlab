@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="row gy-4">
    <div class="col-12">
        <div class="card custom--card ">
            <div class="ccard-header  d-flex align-item-center justify-content-between p-3">
                <h6>{{ __($pageTitle) }}</h6>
                <a class="btn btn-outline--base btn--sm" href="{{ route('ticket.index') }}">
                    <i class="la la-ticket"></i> @lang('My Tickets')
                </a>
            </div>
            <div class="card-body">
                <form action="{{ route('ticket.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label class="form-label">@lang('Subject')</label>
                            <input class="form--control" name="subject" type="text" value="{{ old('subject') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label class="form-label">@lang('Priority')</label>
                            <select class="form--control form-select" name="priority" required>
                                <option value="3">@lang('High')</option>
                                <option value="2">@lang('Medium')</option>
                                <option value="1">@lang('Low')</option>
                            </select>
                        </div>
                        <div class="col-12 form-group">
                            <label class="form-label">@lang('Message')</label>
                            <textarea class="form--control" id="inputMessage" name="message" rows="6" required>{{ old('message') }}</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="text-end">
                            <button class="btn btn--base btn--sm addFile" type="button">
                                <i class="la la-plus"></i> @lang('Add New')
                            </button>
                        </div>
                        <div class="file-upload">
                            <label class="form-label">@lang('Attachments')</label> <small
                                class="text--danger">@lang('Max 5 files can be uploaded'). @lang('Maximum upload size
                                is') {{ ini_get('upload_max_filesize') }}</small>
                            <input class="form--control mb-2" id="inputAttachments" name="attachments[]" type="file" />
                            <div id="fileUploadsContainer"></div>
                            <p class="ticket-attachments-message text-muted">
                                @lang('Allowed File Extensions'): .@lang('jpg'), .@lang('jpeg'), .@lang('png'),
                                .@lang('pdf'), .@lang('doc'), .@lang('docx')
                            </p>
                        </div>
                    </div>
                    <div class="form-group">
                        <button class="btn btn--base w-100" type="submit"><i class="la la-paper-plane"></i>
                            @lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
<script>
    (function ($) {
        "use strict";
        var fileAdded = 0;
        $('.addFile').on('click', function () {
            if (fileAdded >= 4) {
                notify('error', 'You\'ve added maximum number of file');
                return false;
            }
            fileAdded++;
            $("#fileUploadsContainer").append(`
                    <div class="input-group my-3">
                        <input type="file" name="attachments[]" class="form--control" required />
                        <button type="button" class="input-group-text btn--danger border-0 remove-btn"><i class="las la-times"></i></button>
                    </div>
                `)
        });
        $(document).on('click', '.remove-btn', function () {
            fileAdded--;
            $(this).closest('.input-group').remove();
        });

    })(jQuery);

</script>
@endpush
