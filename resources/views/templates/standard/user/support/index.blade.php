@extends($activeTemplate . 'layouts.master')
@section('content')
<div class="row gy-4 align-items-center">
  <div class="col-12">
        <div class="card custom--card">
            <div class="card-header  d-flex align-item-center justify-content-between p-3">
                <h6>{{ __($pageTitle) }}</h6>
                <a class="btn btn-outline--base btn--sm" href="{{ route('ticket.open') }}">
                    <i class="la la-plus"></i> @lang('Open New Ticket')
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive--md">
                    <table class="custom--table table">
                        <thead>
                            <tr>
                                <th>@lang('Subject')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('Priority')</th>
                                <th>@lang('Last Reply')</th>
                                <th>@lang('Action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($supports as $support)
                                <tr>
                                    <td> <a class="fw-bold" href="{{ route('ticket.view', $support->ticket) }}"> [@lang('Ticket')#{{ $support->ticket }}] {{ __($support->subject) }} </a></td>
                                    <td>
                                        @php echo $support->statusBadge; @endphp
                                    </td>
                                    <td>
                                        @if ($support->priority == Status::PRIORITY_LOW)
                                            <span class="badge badge--dark">@lang('Low')</span>
                                        @elseif($support->priority == Status::PRIORITY_MEDIUM)
                                            <span class="badge badge--warning">@lang('Medium')</span>
                                        @elseif($support->priority == Status::PRIORITY_HIGH)
                                            <span class="badge badge--danger">@lang('High')</span>
                                        @endif
                                    </td>
                                    <td>{{ diffForHumans($support->last_reply) }} </td>
                                    <td>
                                        <a class="btn btn-outline--base btn--sm" href="{{ route('ticket.view', $support->ticket) }}">
                                            <i class="fa fa-desktop"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="100%">
                                        <i class="las la-frown fs--30px"></i><br>
                                        <span>{{ __($emptyMessage) }}</span>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ paginateLinks($supports) }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
