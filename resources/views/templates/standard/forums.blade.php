@extends($activeTemplate . 'layouts.frontend')
@section('content')
    @include($activeTemplate . 'partials.forums', ['forums' => [$forums]]);
@endsection
