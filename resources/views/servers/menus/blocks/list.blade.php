<div class="card mb-3 card-create">
    <div class="card-header py-3 bg-transparent border-bottom-0">
        <h6 class="mb-0 fw-bold ">Vị trí menu</h6>
        <small>Website có các vị trí hiển thị cho từng menu. Lựa chọn vị trí muốn hiển thị.</small>
    </div>
    <div class="card-body">
        <div class="row g-3 d-flex align-items-center">
            <div class="table-responsive">
                <table class="table table-bordered table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Tên menu</th>
                            <th scope="col">Đường dẫn</th>
                            <th class="text-end w-10" scope="col">Vị trí</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody class="menu-row-wrap">
                        @php
                        $menu = old('menu', ($menuList ?? []));
                        @endphp
                        <tr class="menu-row-empty {{!empty($menu) && count($menu) > 0 ? 'd-none' : ''}}">
                            <td colspan="10">
                                <div class="notification-menu text-center">
                                    <h5>Danh sách liên kết này chưa có bất kì đường dẫn nào.</h5>
                                    <p class="mb-0">Hãy nhấn vào <span class="link-info">"Thêm đường
                                            dẫn"</span> để bắt đầu thêm.</p>
                                </div>
                            </td>
                        </tr>

                        @if (!empty($menu) && count($menu) > 0 )
                        @foreach ($menu['canonical'] as $key => $value)
                        <tr class="menu-row-item {{$value}}">
                            <td>
                                {!! Form::text('menu[name][]', $menu['name'][$key], ['class' => 'form-control'])
                                !!}
                            </td>
                            <td>
                                {!! Form::text('menu[canonical][]', $value, ['class' => 'form-control']) !!}

                            </td>
                            <td>
                                {!! Form::number('menu[order][]', $menu['order'][$key], ['class' => 'form-control
                                text-end'])
                                !!}

                                {!! Form::hidden('menu[id][]', $menu['id'][$key]) !!}

                            </td>
                            <td class="text-center ">
                                <button type="button"
                                    class="btn btn-outline-secondary text-danger px-2 delete-menu-row">
                                    <i class="icofont-trash fs-14 "></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        @endif
                    </tbody>
                </table>

            </div>

        </div>
    </div>
</div>