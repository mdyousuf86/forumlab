@php
    $register = getContent('register.content', true);
@endphp
<aside class="xxxl-2 col-lg-3 d-lg-block d-none">
    @guest
        @php
            $register = getContent('register.content', true);
        @endphp
        <div class="rounded-3 bg--gradient mb-4 p-4 text-center">
            <h3 class="fw-normal text-white">{{ __(@$register->data_values->ad_title) }}</h3>
            <p class="fs--14px mt-3 text-white">{{ __(@$register->data_values->short_description) }}</p>
            <a class="btn btn--base mt-4" href="{{ route('user.register') }}">@lang('Registration Now')</a>
        </div>
    @endguest

    <div class="sidebar-widget">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Statistics')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="statistics-list">
                <li class="single-stat">
                    <h3 class="single-stat__number">{{ @$forum }}</h3>
                    <span class="single-stat__caption fs--14px">@lang('Forum')</span>
                </li>
                <li class="single-stat">
                    <h3 class="single-stat__number">{{ @$category }}</h3>
                    <span class="single-stat__caption fs--14px">@lang('Category')</span>
                </li>
                <li class="single-stat">
                    <h3 class="single-stat__number">{{ @$subCategory }}</h3>
                    <span class="single-stat__caption fs--14px">@lang('Subcategory')</span>
                </li>
                <li class="single-stat">
                    <h3 class="single-stat__number">{{ @$topic }}</h3>
                    <span class="single-stat__caption fs--14px">@lang('Topic')</span>
                </li>
            </ul>
        </div>
    </div>
    @php echo showAdvertisement(); @endphp

    <div class="sidebar-widget mt-4">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Top Contributors')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="contributor-list">
                @forelse ($topContributors as $top)
                    <li class="single-contributor">
                        <div class="single-contributor__thumb">
                            <a href="{{ route('profile', @$top->user->username) }}">
                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$top->user->image, getFileSize('userProfile')) }}" alt="@lang('image')">
                            </a>
                        </div>
                        <h6 class="single-contributor__name">
                            <a href="{{ route('profile', @$top->user->username) }}">
                                {{ __(@$top->user->fullname) }}
                            </a>
                        </h6>
                        <span class="single-contributor__comment fs--14px"><i class="las la-comments"></i> {{ @$top->total }}</span>
                    </li>
                @empty
                    <li class="single-discussion">
                        <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                    </li>
                @endforelse

            </ul>
        </div>
    </div>

    <div class="sidebar-widget mt-4">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Unanswered Talks')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="unanswered-list">
                @forelse ($unTalks as $unTalk)
                    <li class="single-unanswered">
                        <div class="single-unanswered__top">
                            <div class="single-unanswered__thumb">
                                <a href="{{ route('profile', @$unTalk->user->username) }}">
                                    <img src="{{ getImage(getFilePath('userProfile') . '/' . @$unTalk->user->image, getFileSize('userProfile')) }}" alt="@lang('image')">
                                </a>
                            </div>
                            <div class="single-unanswered__content d-flex align-items-center justify-content-between">
                                <h6 class="single-unanswered__name"><a href="{{ route('profile', @$unTalk->user->username) }}">{{ __(@$unTalk->user->fullname) }}</a></h6>
                                <span class="fs--12px">{{ showDateTime(@$unTalk->created_at, 'd M, Y') }}</span>
                            </div>
                        </div>
                        <h6 class="single-unanswered__title">
                            <a href="{{ route('topic.detail', [slug($unTalk->title), $unTalk->id]) }}">
                                {{ __($unTalk->title) }}
                            </a>
                        </h6>
                        <span class="fs--12px">
                            <i class="las la-comments fs--14px"></i>
                            {{ $unTalk->comment }} @lang('comment')
                        </span>
                    </li>
                @empty
                    <li class="single-discussion">
                        <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                    </li>
                @endforelse

            </ul>
        </div>
    </div>
    <div class="sidebar-widget mt-4">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Hot Topics')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="topic-list">
                @forelse ($hots as $hot)
                    <li class="single-topic">
                        <div class="single-topic__thumb">
                            <a href="{{ route('profile', @$hot->topic->user->username) }}">
                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$hot->topic->user->image, getFileSize('userProfile')) }}" alt="@lang('image')">
                            </a>
                        </div>
                        <div class="single-topic__content">
                            <h6 class="single-topic__title">
                                <a href="{{ route('topic.detail', [slug(@$hot->topic->title), @$hot->topic->id]) }}">
                                    {{ __(@$hot->topic->title) }}
                                </a>
                            </h6>
                            <span class="fs--12px"><i class="las la-calendar fs--14px"></i> {{ showDateTime(@$hot->topic->cretaed_at, 'd M, Y') }}</span>
                        </div>
                    </li>
                @empty
                    <li class="single-discussion">
                        <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    @php echo showAdvertisement(); @endphp
</aside>
