@extends('layouts.serverLayout')



@section('content')
@php
$url = $config['method'] == 'create' ? route('generate.store') : route('generate.update', $generate->id);
@endphp
<form action="{{ $url }}" method="post" enctype="multipart/form-data">

    @csrf
    @if ($config['method'] == 'update')
    @method('PUT')
    @endif
    <div class="body d-flex py-3">

        <div class="container-xxl">

            <div class="row align-items-center">
                <div class="border-0 mb-4">
                    <div
                        class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                        <h3 class="fw-bold mb-0">{{$config['seo']['title']}}</h3>
                        <button type="submit"
                            class="btn btn-primary py-2 px-5 text-uppercase btn-set-task w-sm-100">{{__('messages.saveButton')}}
                    </div>
                </div>
            </div> <!-- Row end  -->

            <div class="row g-3 mb-3 justify-content-center ">
                <div class="col-lg-10">

                    @include('servers.includes.messageError')

                    <div class="card mb-3 card-create">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
                            <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                                {{__('messages.noteNotice')[1]}}</small>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-6">
                                    <label class="form-label">{{__('messages.generate.table.name')}} <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" name="name" value="{{old('name', $generate->name ?? '')}}"
                                        class="form-control">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">{{__('messages.generate.table.module')}} <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" name="module" value="{{old('module', $generate->module ?? '')}}"
                                        class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">{{__('messages.generate.table.path')}} <span
                                            class="text-danger">(*)</span></label>
                                    <input type="text" name="path" value="{{old('path', $generate->path ?? '')}}"
                                        class="form-control path-route">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Loại module <span class="text-danger">(*)</span></label>

                                    <select class="form-select form-select-lg" name="module_type" id="">
                                        <option selected>Chọn loại module</option>
                                        <option value="1">Module danh mục</option>
                                        <option value="2">Module chi tiết</option>
                                        <option value="3">Module khác</option>
                                    </select>

                                </div>


                            </div>
                        </div>
                    </div>

                    <div class="card mb-3 card-create">
                        <div class="card-header py-3 bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Thôn tin schema</h6>
                            <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                                {{__('messages.noteNotice')[1]}}</small>
                        </div>
                        <div class="card-body">
                            <div class="row g-3 align-items-center">
                                <div class="col-md-12">
                                    <label class="form-label">Schema <span class="text-danger">(*)</span></label>
                                    <textarea class="form-control textarea-expand " name="schema" rows="15">{{ old('schema', $generate->schema ?? trim('
$table->id();
$table->integer(\'parent_id\')->default(0);
$table->integer(\'left\')->default(0);
$table->integer(\'right\')->default(0);
$table->integer(\'level\')->default(0);
$table->string(\'image\')->nullable();
$table->string(\'icon\')->nullable();
$table->text(\'album\')->nullable();
$table->tinyInteger(\'publish\')->default(1);
$table->tinyInteger(\'follow\')->default(0);
$table->integer(\'order\')->default(0);
$table->foreignId(\'user_id\')->constrained(\'users\')->onDelete(\'cascade\');
$table->softDeletes();
$table->timestamps();')) }}</textarea>


                                </div>
                                {{-- <div class="col-md-12">
                                    <label class="form-label">Schema 2 </label>
                                    <textarea class="form-control textarea-expand" name="schema[]"
                                        rows="10">{{old('schema', $generate->schema ?? '')}}</textarea>

                                </div> --}}


                            </div>
                        </div>
                    </div>


                </div>
            </div><!-- Row end  -->

        </div>
    </div>
</form>

@endsection