@extends('layouts.serverLayout')

@section('script')

@endsection

@section('content')
<div class="body d-flex py-3">
    <div class="container-xxl">
        <div class="row align-items-center">
            <div class="border-0 mb-4">
                <div
                    class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h3 class="fw-bold mb-0">{{$config['seo']['title']}}</h3>
                    {{-- <div class="col-auto d-flex w-sm-100">
                        <a href="{{route('product.create')}}" class="btn btn-primary btn-set-task w-sm-100">
                            <i class="icofont-plus-circle me-2 fs-6"></i>{{$config['seo']['create']}} </a>
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="row g-3">
            <div class="col-lg-12 col-md-12">
                <div class="tab-filter d-flex align-items-center justify-content-between mb-3 flex-wrap">
                    <ul class="nav nav-tabs tab-card tab-body-header rounded  d-inline-flex w-sm-100">
                        <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab"
                                href="#summery-today">Today</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#summery-week">Week</a></li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#summery-month">Month</a>
                        </li>
                        <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#summery-year">Year</a></li>
                    </ul>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="tab-content mt-1">
                        <div class="tab-pane fade show active" id="summery-today">
                            <div class="card mb-3 card-create">
                                <div class="card-header py-3 bg-transparent border-bottom-0">
                                    <h6 class="mb-0 fw-bold ">{{__('messages.generalInfomation')}}</h6>
                                    <small>{{__('messages.noteNotice')[0]}} <span class="text-danger">(*)</span>
                                        {{__('messages.noteNotice')[1]}}</small>
                                </div>
                                <div class="card-body">
                                    <div class="row g-3 align-items-center">
                                        <div class="col-md-6">
                                            <label class="form-label">{{__('messages.email')}} <span
                                                    class="text-danger">(*)</span></label>
                                            <input type="email" name="email"
                                                value="{{old('email', $user->email ?? '')}}" class="form-control">
                                            {!! Form::email('username', $value ?? '', ['class' => 'form-control']) !!}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>

    </div>
    </section>
    @overwrite