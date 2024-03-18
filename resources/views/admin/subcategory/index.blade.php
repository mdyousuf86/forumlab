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
                                    <th>@lang('Category')</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Status')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($subcategories as $subcategory)
                                    <tr>
                                        <td>{{ $subcategories->firstItem() + $loop->index }}</td>
                                        <td>{{ __(@$subcategory->category->name) }}</td>
                                        <td>{{ __($subcategory->name) }}</td>
                                        <td> @php echo $subcategory->statusBadge; @endphp </td>
                                        <td>
                                            <div class="button--group">
                                                <button class="btn btn-sm btn-outline--primary editBtn" data-resource="{{ $subcategory }}">
                                                    <i class="la la-pencil"></i>@lang('Edit')
                                                </button>
                                                @if ($subcategory->status)
                                                    <button class="btn btn--sm btn-outline--danger confirmationBtn" data-question="@lang('Are you sure inactive this subcategory')?" data-action="{{ route('admin.subcategory.status', $subcategory->id) }}">
                                                        <i class="la la-eye-slash"></i>@lang('Inactive')
                                                    </button>
                                                @else
                                                    <button class="btn btn--sm btn-outline--success confirmationBtn" data-question="@lang('Are you sure active this subcategory')?" data-action="{{ route('admin.subcategory.status', $subcategory->id) }}">
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
                @if ($subcategories->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($subcategories) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="subCategoryModal" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true" tabindex="-1">
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
                            <label>@lang('Category')</label>
                            <select class="form-control" name="category_id" required>
                                <option value="" selected disabled>@lang('Select One')</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @selected(old('category_id') == $category->id)>{{ __($category->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>@lang('Name')</label>
                            <input class="form-control" name="name" type="text" value="{{ old('name') }}" required>
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

@push('script')
    <script>
        (function($) {
            "use strict";

            let modal = $('#subCategoryModal');

            $('.addBtn').on('click', function() {
                modal.find('.modal-title').text(`@lang('Add New Subcategory')`);
                modal.find('form').attr('action', `{{ route('admin.subcategory.store', '') }}`);
                modal.modal('show');
            });

            $('.editBtn').on('click', function() {
                let subcategory = $(this).data('resource');
                modal.find('.modal-title').text(`@lang('Update Subcategory')`);
                modal.find('form').attr('action', `{{ route('admin.subcategory.store', '') }}/${subcategory.id}`);
                modal.find('[name=name]').val(subcategory.name);
                modal.find('select[name=category_id]').val(subcategory.category_id);
                modal.modal('show')
            });

            modal.on('hidden.bs.modal', function() {
                $('#subCategoryModal form')[0].reset();
            });
        })(jQuery);
    </script>
@endpush
