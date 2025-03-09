@if (isset($slides['why-choose']) && count($slides['why-choose']->item) > 0)

<div class="axil-why-choose-area pb--50 pb_sm--30">
    <div class="container">
        <div class="section-title-wrapper section-title-center">
            <span class="title-highlighter highlighter-secondary"><i class="fal fa-thumbs-up"></i>Tại sao là chúng
                tôi</span>
            <h2 class="title">Tại sao mọi người chọn chúng tôi</h2>
        </div>
        <div class="row row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-sm-2 row-cols-1 row--20">
            @foreach ($slides['why-choose']->item as $whyChoose)
            <div class="col">
                <div class="service-box">
                    <div class="icon">
                        <img src="{{ $whyChoose['image'] ?? '' }}" alt="{{ $whyChoose['alt'] ?? '' }}">
                    </div>
                    <h6 class="title">{{ $whyChoose['name'] ?? '' }}</h6>
                </div>
            </div>
            @endforeach

        </div>
    </div>
</div>
@endif
