@extends('layouts.serverLayout')

@section('content')

{!! Form::open(['method' => 'put', 'route' => 'user.catalogue.updatePermission']) !!}
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

                    <div class="card-body">
                        <table id="myProjectTable" class="table  table-hover align-middle mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        {{__('messages.permission.table.name')}}
                                    </th>
                                    @foreach ($userCatalogues as $userCatalogue)
                                    <th class="text-center  ">
                                        {{$userCatalogue->name}}
                                    </th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($permissions as $permission)

                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-between ">
                                            <span class="text-primary  ">{{$permission->name}}</span>
                                            <span class="text-danger  ">({{$permission->canonical}})</span>
                                        </div>
                                    </td>
                                    @foreach ($userCatalogues as $userCatalogue)

                                    <td class="text-center">
                                        {!! Form::checkbox("permission[{$userCatalogue->id}][]", $permission->id,
                                        collect($userCatalogue->permissions)->contains('id', $permission->id), ['class'
                                        => 'form-check-input check-permission']) !!}
                                    </td>

                                    @endforeach


                                </tr>
                                @endforeach


                            </tbody>

                        </table>
                    </div>
                </div>



            </div>
        </div><!-- Row end  -->

    </div>
</div>

{!! Form::close() !!}


@endsection