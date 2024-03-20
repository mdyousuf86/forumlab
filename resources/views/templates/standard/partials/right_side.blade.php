@php
    $register = getContent('register.content', true);
@endphp
<aside class="aside-list aside-col right">
    @php echo showAdvertisement(); @endphp
    <div class="sidebar-widget">
        <ul class="statistics-list">
            <li class="statistics-list__item">
                <span class="statistics-list__number">{{ @$forum }}</span>
                <span class="statistics-list__caption">@lang('Forum')</span>
            </li>
            <li class="statistics-list__item">
                <span class="statistics-list__number">{{ @$category }}</span>
                <span class="statistics-list__caption">@lang('Category')</span>
            </li>
            <li class="statistics-list__item">
                <span class="statistics-list__number">{{ @$subCategory }}</span>
                <span class="statistics-list__caption">@lang('Subcategory')</span>
            </li>
            <li class="statistics-list__item">
                <span class="statistics-list__number">{{ @$topic }}</span>
                <span class="statistics-list__caption">@lang('Topic')</span>
            </li>
        </ul>
    </div>

    @php echo showAdvertisement(); @endphp

    <div class="sidebar-widget two tc">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Top Contributors')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="sidebar-widget__list">
                @forelse ($topContributors as $top)
                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb"><a
                                href="{{ route('profile', @$top->user->username) }}">
                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$top->user->image, getFileSize('userProfile')) }}"
                                    alt="@lang('image')"></a>
                        </span>
                        <div class="sidebar-widget__list-content">
                            <a href="{{ route('profile', @$top->user->username) }}"
                                class="sidebar-widget__list-link">{{ __(@$top->user->fullname) }}</a>
                            <span class="sidebar-widget__list-meta_info"><i class="fli-comments"></i>
                                {{ @$top->total }}</span>
                        </div>
                    </li>
                @empty
                    <li class="sidebar-widget__list-item">
                        <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
    <div class="sidebar-widget two">
        <div class="sidebar-widget__header">
            <h5 class="sidebar-widget__title">@lang('Hot Topics')</h5>
        </div>
        <div class="sidebar-widget__body">
            <ul class="sidebar-widget__list">
                @forelse ($hots as $hot)
                    <li class="sidebar-widget__list-item">
                        <span class="sidebar-widget__list-thumb">
                            <a href="{{ route('profile', @$hot->topic->user->username) }}">
                                <img src="{{ getImage(getFilePath('userProfile') . '/' . @$hot->topic->user->image, getFileSize('userProfile')) }}"
                                    alt="@lang('image')">
                            </a>
                        </span>
                        <div class="sidebar-widget__list-content">
                            <a class="sidebar-widget__list-link"
                                href="{{ route('topic.detail', [slug(@$hot->topic->title), @$hot->topic->id]) }}">
                                {{ __(@$hot->topic->title) }}
                            </a>
                            <span class="sidebar-widget__list-meta_info"><i
                                    class="fli-calendar2"></i>{{ showDateTime(@$hot->topic->cretaed_at, 'd M, Y') }}</span>
                        </div>
                    </li>
                @empty
                    <li class="sidebar-widget__list-item">
                        <p><i class="las la-frown"></i> {{ __($emptyMessage) }}</p>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>
</aside>
