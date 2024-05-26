@if (isset($attributeCatalogues) && count($attributeCatalogues) > 0)

@php
$attributeQuery = explode(',',request()->get('attribute_id'));
@endphp
<div class="product-variations-wrapper">

    @foreach ($attributeCatalogues as $attributeCatalogue)
    <div class="product-variation product-size-variation">
        <h6 class="title">{{$attributeCatalogue->name}}</h6>
        <ul class="range-variant">
            @foreach ($attributeCatalogue->attributes as $attribute)
            @php
            $active = !empty($attributeQuery) && in_array($attribute->id, $attributeQuery) ? 'active' : '';
            @endphp
            <li class="product-variation-item choose-attribute {{$active}}" data-attribute-id="{{$attribute->id}}">
                {{$attribute->name}}</li>
            @endforeach
        </ul>
    </div>
    <!-- End Product Variation  -->
    @endforeach
</div>
@endif