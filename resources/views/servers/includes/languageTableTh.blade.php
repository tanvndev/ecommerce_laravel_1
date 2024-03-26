@foreach ($languages as $language)
@if ($language->canonical == app()->getLocale())
@continue
@endif
<th class="text-center ">
    <img class="rounded-2 img-thumbnail img-language-th img-contain" src="{{$language->image}}"
        alt="{{$language->name}}">
</th>
@endforeach