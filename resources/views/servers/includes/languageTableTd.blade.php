@foreach ($languages as $language)
@if ($language->canonical == app()->getLocale())
@continue
@endif
@php
$translated = $model->languages->contains('id', $language->id);
@endphp
<td class="text-center ">
    <a class="btn btn-link {{$translated ? 'text-success' : 'text-danger'}}"
        href="{{route('language.translate', ['id' => $model->id, 'languageId' => $language->id, 'model' => $modelName ])}}">{{$translated
        ? 'Đã dịch' : 'Chưa dịch'}}</a>
</td>
@endforeach