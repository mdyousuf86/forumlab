@extends($activeTemplate . 'layouts.frontend')
@section('content')
    <section>
        <div class="container">
            <div class="row justify-content-center">
                <h2 class="mb-4 text-center">{{ __($pageTitle) }}</h2>
                <div class="col-xl-12">
                    @php echo $policy->data_values->details; @endphp
                </div>
            </div>
        </div>
    </section>
@endsection
