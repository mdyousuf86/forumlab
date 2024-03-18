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
                                    <th>@lang('User')</th>
                                    <th>@lang('Comment')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($comments as $comment)
                                    <tr>
                                        <td>{{ $comments->firstItem() + $loop->index }}</td>
                                        <td>
                                            <span class="fw-bold">{{ @$comment->user->fullname }}</span>
                                            <br>
                                            <span class="small">
                                                <a href="{{ route('admin.users.detail', @$comment->user->id) }}"><span>@</span>{{ @$comment->user->username }}</a>
                                            </span>
                                        </td>
                                        <td>
                                            {{ strLimit(__(@$comment->comment), 25) }}
                                        </td>
                                        <td>
                                            <div class="button-group">
                                                <button class="btn btn-sm btn-outline--info view-comment" data-comment="{{ $comment->comment }}">
                                                    <i class="las la-comment"></i> @lang('View')
                                                </button>
                                                <a class="btn btn-sm btn-outline--danger confirmationBtn" data-action="{{ route('admin.topic.comment.delete', [$comment->id, $comment->topic_id]) }}" data-question="@lang('Are you sure delete this comment')?">
                                                    <i class="las la-trash"></i> @lang('Delete')
                                                </a>
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
                @if ($comments->hasPages())
                    <div class="card-footer py-4">
                        {{ paginateLinks($comments) }}
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade" id="commentModal" role="dialog" tabindex="-1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Comment')</h5>
                    <span class="close" data-bs-dismiss="modal" type="button" aria-label="Close">
                        <i class="las la-times"></i>
                    </span>
                </div>
                <div class="modal-body">
                    <p class="comment"></p>
                </div>
            </div>
        </div>
    </div>

    <x-confirmation-modal />
@endsection

@push('breadcrumb-plugins')
    <x-search-form />
@endpush

@push('script')
    <script>
        (function($) {
            "use strict";
            $('.view-comment').on('click', function(e) {
                var modal = $("#commentModal");
                modal.find('.comment').text($(this).data('comment'));
                modal.modal('show');
            });
        })(jQuery)
    </script>
@endpush
