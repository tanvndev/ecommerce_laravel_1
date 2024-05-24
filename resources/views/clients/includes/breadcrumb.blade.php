<!-- Start Breadcrumb Area  -->
<div class="axil-breadcrumb-area">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-8">
                <div class="inner">
                    <ul class="axil-breadcrumb">
                        <li class="axil-breadcrumb-item"><a href="/">{{__('client.home')}}</a></li>
                        <li class="separator"></li>
                        @if (!is_null($breadcrumb) && count($breadcrumb) > 0)
                        @foreach ($breadcrumb as $index => $brc)
                        @php
                        $name = $brc->languages->first()->pivot->name;
                        $canonical = write_url($brc->languages->first()->pivot->canonical);
                        @endphp

                        @if ($index < count($breadcrumb) - 1) <li class="axil-breadcrumb-item"><a
                                href="{{ $canonical }}" title="{{ $name }}">{{ $name }}</a></li>
                            <li class="separator"></li>
                            @else
                            <li class="axil-breadcrumb-item active" aria-current="page">{{ $name }}</li>
                            @endif

                            @endforeach
                            @endif
                    </ul>

                    <h1 class="title">{{ $model->name }}</h1>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
                <div class="inner">
                    <div class="bradcrumb-thumb">
                        <img src="assets/clients/images/product/product-45.png" alt="Image">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumb Area  -->