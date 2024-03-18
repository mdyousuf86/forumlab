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
                                    <th>@lang('S.N.')</th>
                                    <th>@lang('Forum')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Icon')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                    <tr>
                                        <td>{{ $categories->firstItem() + $loop->index }}</td>
                                        <td>{{ __(@$category->forum->name) }}</td>
                                        <td>{{ __($category->name) }}</td>
                                        <td>
                                            @php
                                                echo $category->icon;
                                            @endphp
                                        </td>
                                        <td> @php echo $category->statusBadge; @endphp
                                        </td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-sm btn-outline--primary editBtn" data-resource="{{ $category }}">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>
                                                @if ($category->status)
                                                    <button class="btn btn--sm btn-outline--danger confirmationBtn" data-question="@lang('Are you sure inactive this category')?" data-action="{{ route('admin.category.status', $category->id) }}">
                                                        <i class="la la-eye-slash"></i>@lang('Inactive')
                                                    </button>
                                                @else
                                                    <button class="btn btn--sm btn-outline--success confirmationBtn" data-question="@lang('Are you sure active this category')?" data-action="{{ route('admin.category.status', $category->id) }}">
                                                        <i class="la la-eye"></i>@lang('Active')
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
                @if ($categories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($categories) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="categoryModal" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="createModalLabel"></h4>
                    <button class="close" data-bs-dismiss="modal" type="button" aria-label="Close"><i class="las la-times"></i></button>
                </div>
                <form method="post" action="">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label>@lang('Forum')</label>
                            <select class="form-control" name="forum_id" required>
                                <option value="" selected disabled>@lang('Select One')</option>
                                @foreach ($forums as $forum)
                                    <option value="{{ $forum->id }}" @selected(old('forum_id') == $forum->id)>{{ __($forum->name) }}</option>
                                @endforeach
                            </select>
                        </div>
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
                        <div class="form-group">
                            <label>@lang('Description')</label>
                            <textarea class="form-control" name="description" rows="5" required maxlength="255">{{ old('description') }}</textarea>
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
    <x-search-form placeholder="Search Here" />
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
            "use strict"
            let modal = $('#categoryModal');

            $('.addBtn').on('click', function() {
                modal.find('.modal-title').text(`@lang('Add New Category')`);
                modal.find('form').attr('action', `{{ route('admin.category.store', '') }}`);
                modal.modal('show');
            });

            $('.editBtn').on('click', function() {
                let category = $(this).data('resource');
                modal.find('.modal-title').text(`@lang('Update Category')`);
                modal.find('form').attr('action', `{{ route('admin.category.store', '') }}/${category.id}`);
                modal.find('[name=name]').val(category.name);
                modal.find('[name=icon]').val(category.icon);
                modal.find('select[name=forum_id]').val(category.forum_id);
                modal.find('[name=description]').val(category.description);
                modal.modal('show')
            });

            $('.iconPicker').iconpicker().on('iconpickerSelected', function(e) {
                $(this).closest('.form-group').find('.iconpicker-input').val(`<i class="${e.iconpickerValue}"></i>`);
            });

            modal.on('hidden.bs.modal', function() {
                $('#categoryModal form')[0].reset();
            });
        })(jQuery);
    </script>
@endpush
