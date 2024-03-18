@extends('admin.layouts.app')
@section('panel')
    <div class="row">
        <div class="col-md-12">
            <div class="card b-radius--10">
                <div class="card-body p-0">
                    <div class="table-responsive--sm table-responsive">
                        <table class="table--light style--two custom-data-table table">
                            <thead>
                                <tr>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Icon')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($forums as $forum)
                                    <tr>
                                        <td>{{ __($forum->name) }}</td>
                                        <td>
                                            @php echo $forum->icon; @endphp
                                        </td>
                                        <td>
                                            @php echo $forum->statusBadge;@endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-outline--primary btn--sm editBtn" data-resource="{{ $forum }}" type="button">
                                                    <i class="las la-pencil-alt"></i>@lang('Edit')
                                                </button>
                                                @if ($forum->status == Status::FORUM_ACTIVE)
                                                    <button class="btn btn-outline--danger btn--sm confirmationBtn" data-action="{{ route('admin.forum.status', $forum->id) }}" data-question="@lang('Are you sure inactive this forum')?" type="button">
                                                        <i class="las la-eye-slash"></i>@lang('Inactive')
                                                    </button>
                                                @else
                                                    <button class="btn btn-outline--success btn--sm confirmationBtn" data-action="{{ route('admin.forum.status', $forum->id) }}" data-question="@lang('Are you sure activate this forum')?" type="button">
                                                        <i class="las la-eye"></i>@lang('Active')
                                                    </button>
                                                @endif
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
                @if ($forums->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($forums) }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="modal fade" id="forumModal" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"></h4>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close"><i class="las la-times"></i></button>
                </div>
                <form class="form-horizontal" method="post" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" name="name" type="text" value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group">
                            <label>@lang('Icon')</label>
                            <div class="input-group">
                                <input class="form-control iconPicker icon" name="icon" type="text" autocomplete="off" required>
                                <span class="input-group-text input-group-addon" data-icon="las la-home" role="iconpicker"></span>
                            </div>
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
    <x-search-form />
    <button class="btn btn-outline--primary h-45 addBtn"><i class="las la-plus"></i>@lang('Add New')</button>
@endpush

@push('style-lib')
    <link href="{{ asset('assets/admin/css/fontawesome-iconpicker.min.css') }}" rel="stylesheet">
@endpush

@push('script-lib')
    <script src="{{ asset('assets/admin/js/fontawesome-iconpicker.js') }}"></script>
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            let modal = $('#forumModal');

            $('.addBtn').on('click', function() {
                modal.find('.modal-title').text(`@lang('Add New Forum')`);
                modal.find('form').attr('action', `{{ route('admin.forum.store', '') }}`);
                modal.modal('show');
            });

            $('.editBtn').on('click', function() {
                let forum = $(this).data('resource');
                modal.find('form').attr('action', `{{ route('admin.forum.store', '') }}/${forum.id}`);
                modal.find('.modal-title').text(`@lang('Update Forum')`);
                modal.find('[name=name]').val(forum.name);
                modal.find('[name=icon]').val(forum.icon);
                modal.modal('show')
            });

            $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
                $(this).closest('.form-group').find('.iconpicker-input').val(`<i class="${e.iconpickerValue}"></i>`);
            });

            modal.on('hidden.bs.modal', function() {
                $("#forumModal form")[0].reset();
            });

        })(jQuery)
    </script>
@endpush
