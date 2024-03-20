
@forelse ($forums as $forum)
    <div class="forum-block">
        <div class="forum-block__header">
            <h4 class="title">{{ __($forum->name) }}</h4>
        </div>
        @foreach ($forum->categories->take(5) as $category)
            <div class="forum-item">
                <div class="forum-item__content">
                    <h5 class="forum-item__title">
                        <a href="{{ route('category.topic', [slug($category->name), $category->id]) }}">
                            {{ __($category->name) }}</a>
                    </h5>
                    <p class="forum-item__desc">
                        {{ __($category->description) }}
                    </p>
                    <div class="forum-item__buttons">
                        @php
                            $colors = ['primary', 'info', 'secondary', 'success', 'danger', 'warning'];
                            $colorIndex = 0;
                        @endphp
                        @foreach ($category->subcategories->take(6) as $subcategory)
                            @php
                                $color = $colors[$colorIndex % count($colors)];
                                $colorIndex++;
                            @endphp
                            <a href="{{ route('subcategory.topics', [slug($subcategory->name), $subcategory->id]) }}"
                                class="btn btn--{{ $color }}">{{ $subcategory->name }}</a>
                        @endforeach
                    </div>
                </div>
                <ul class="forum-item__infolist">
                    <li class="forum-item__infolist-item">
                        <span class="icon"><i class="fli-file"></i></span>
                        <span class="text">{{ $category->topics->count() }} @lang('Topics')</span>
                    </li>
                    <li class="forum-item__infolist-item">
                        @foreach ($category->topics->take(5) as $topic)
                            <a href="{{ route('profile', @$topic->user->username) }}">
                                <span class="icon"><i class="fli-user"></i></span>
                            </a>
                        @endforeach
                        <span class="text">
                            @if ($category->topics->count() > 5)
                                5+
                            @else
                                {{ $category->topics->count() }}
                            @endif
                            @lang('Users')
                        </span>
                    </li>
                    @php
                        $comment = $category->topics()->withWhereHas('latestComment')->first();
                    @endphp
                    <li class="forum-item__infolist-item">
                        <span class="icon"><i class="fli-calendar"></i></span>
                        <span class="text">
                            @if (@$comment->latestComment->created_at)
                                {{ diffForHumans(@$comment->latestComment->created_at) }}
                            @else
                                @lang('No activities yet')
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        @endforeach
    </div>
@empty
    <div class="single-post d-block border-0 text-center">
        {{ __($emptyMessage) }}
    </div>
@endforelse
