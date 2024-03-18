@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-lg-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--md table-responsive">
                        <table class="table--light style--two table">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>@lang('Type')</th>
                                    <th>@lang('Impression')</th>
                                    <th>@lang('Clicked')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($ads as $ad)
                                    <tr>
                                        <td>{{ $ads->firstItem() + $loop->index }}</td>
                                        <td>
                                            @if ($ad->type == 1)
                                                <span>@lang('Banner')</span>
                                            @else
                                                <span>@lang('Script')</span>
                                            @endif
                                        </td>
                                        <td>{{ $ad->impression }}</td>
                                        <td>{{ $ad->click }}</td>
                                        <td>
                                            @php echo $ad->statusBadge; @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn--sm btn-outline--primary editBtn" data-id="{{ $ad->id }}" data-type="{{ $ad->type }}" @if (@$ad->content->link) data-link="{{ @$ad->content->link }}" @endif @if (@$ad->content->image) data-image="{{ getImage(getFilePath('ads') . '/' . @$ad->content->image, getFileSize('ads')) }}" @endif @if (@$ad->content->script) data-script="{{ @$ad->content->script }}" @endif><i class="la la-pencil"></i>@lang('Edit')</button>

                                                @if ($ad->status)
                                                    <button class="btn btn--sm btn-outline--warning confirmationBtn" data-question="@lang('Are you sure disable this ad')?" data-action="{{ route('admin.advertisement.status', $ad->id) }}">
                                                        <i class="la la-eye-slash"></i>@lang('Disable')
                                                    </button>
                                                @else
                                                    <button class="btn btn--sm btn-outline--success confirmationBtn" data-question="@lang('Are you sure enable this ad')?" data-action="{{ route('admin.advertisement.status', $ad->id) }}">
                                                        <i class="la la-eye"></i>@lang('Enable')
                                                    </button>
                                                @endif

                                                <button class="btn btn-outline--danger btn--sm confirmationBtn" data-question="@lang('Are you sure delete this ad')?" data-action="{{ route('admin.advertisement.delete', $ad->id) }}">
                                                    <i class="las la-trash"></i>@lang('Delete')
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-muted text-center" colspan="100%">{{ __($emptyMessage) }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @if ($ads->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($ads) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="advertiseModal" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"></h4>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close"><i class="las la-times"></i></button>
                </div>
                <form method="post" action="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="form-group">
                            <label>@lang('Type')</label>
                            <select class="form-control" id="type" name="type" required>
                                <option value="1">@lang('Banner')</option>
                                <option value="2">@lang('Script')</option>
                            </select>
                        </div>
                        <div class="form-group link d-none">
                            <label>@lang('Link')</label>
                            <input class="form-control" name="link" type="text" placeholder="@lang('Link')">
                        </div>
                        <div class="form-group image d-none">
                            <label>@lang('Image')<span class="text--danger">*</span></label>
                            <div class="image-upload">
                                <div class="thumb">
                                    <div class="avatar-preview">
                                        <div class="profilePicPreview" style="background-image: url({{ getImage('/', getFileSize('ads')) }})">
                                            <button class="remove-image" type="button"><i class="fa fa-times"></i></button>
                                        </div>
                                    </div>
                                    <div class="avatar-edit">
                                        <input class="profilePicUpload" id="profilePicUpload1" name="image" type="file" accept=".png, .jpg, .jpeg">
                                        <label class="bg--primary" for="profilePicUpload1">@lang('Upload Image')</label>
                                        <small class="text-facebook mt-2">@lang('Supported files'):
                                            <b>@lang('jpeg'), @lang('jpg'), @lang('png').</b>
                                            @lang('Image will be resized into '){{ getFileSize('ads') }} @lang('px')
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group script d-none">
                            <label>@lang('Script')</label>
                            <textarea class="form-control" name="script" rows="6" placeholder="@lang('Write Your Script')"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn--primary w-100 h-45" type="submit">@lang('Submit')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <button class="btn btn-outline--primary h-45 addBtn"><i class="las la-plus"></i>@lang('Add New')</button>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict"
            var modal = $('#advertiseModal');

            $('.addBtn').on('click', function() {
                modal.find('.modal-title').text(`@lang('Add New Advertise')`);
                modal.find('form').attr('action', `{{ route('admin.advertisement.store') }}`);
                modal.modal('show');
                advertisementType()
            });

            $('.editBtn').on('click', function() {
                var ad = $(this).data();
                modal.find('.modal-title').text(`@lang('Update Advertise')`);
                modal.find('form').attr('action', `{{ route('admin.advertisement.store', '') }}/${ad.id}`);
                modal.find('select[name=type]').val(ad.type);
                modal.find('[name=link]').val(ad.link);
                modal.find('[name=script]').val(ad.script);
                modal.find('.profilePicPreview').attr('style', `background-image: url(${ad.image})`);
                advertisementType(ad.type)
                modal.modal('show');
            });

            $('#type').on('change', function() {
                advertisementType($(this).val())
            }).change();

            function advertisementType(type) {
                if (type == 2) {
                    $('.link').addClass('d-none');
                    $('.image').addClass('d-none');
                    $('.script').removeClass('d-none');
                } else if ($) {
                    $('.link').removeClass('d-none');
                    $('.image').removeClass('d-none');
                    $('.script').addClass('d-none');
                }
            }

            var defautlImage = `{{ getImage('/', getFileSize('ads')) }}`;

            modal.on('hidden.bs.modal', function() {
                $('#advertiseModal form')[0].reset();
                modal.find('.profilePicPreview').attr('style', `background-image: url(${defautlImage})`);
            });
        })(jQuery);
    </script>
@endpush
