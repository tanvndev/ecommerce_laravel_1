@php
$comments = $model->comments;
$totalComment = $comments->count();
$totalRate = $comments->avg('rate');
@endphp
<div class="reviews-wrapper">
    <div class="user-rating-box">
        <div class="row justify-content-center align-items-center">
            <div class="col-4">
                <div class="average-star">
                    <h5>Đánh giá trung bình</h5>
                    <h3 class="rating">{{round($totalRate, 1)}}/5</h3>

                    {!! generateStarPercent($totalRate) !!}

                    <p class="star-rating-total">
                        {{$totalComment}} đánh giá
                    </p>
                </div>
            </div>

            <div class="col-4">
                @for ($i = 5; $i >= 1 ; $i--)
                @php
                $countStar = $comments->where('rate', $i)->count();
                $percent = $totalComment > 0 ? round($countStar / $totalComment * 100, 0) : 0;
                @endphp
                <div class="progress-block">
                    <div class="progress-block__line">
                        <div class="star">
                            <span class="text">{{$i}}</span>
                            <i class="fas fa-star"></i>
                        </div>
                        <div class="progress progress-success progress-sm progress-line">
                            <div class="progress-bar" style="width: {{$percent}}%;"></div>
                        </div>
                        <span class="text ms-1">{{$countStar}}</span>
                    </div>
                </div>
                @endfor
            </div>

            <div class="col-4">
                <div class="action">
                    <div class="text">Bạn đã dùng sản phẩm này?</div>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#comment-modal"
                        class="btn btn-primary action-btn btn-lg ">GỬI ĐÁNH GIÁ</a>

                </div>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="filter">
        <div class="tags">
            <div class="text">Lọc xem theo:</div>
            <div class="filter-list">
                <div class="filter-item active" data-sort="1"><i class="fas fa-check"></i><span>Đã mua hàng</span></div>
                <div class="filter-item" data-sort="3"><i class="fas fa-check"></i><span>5
                        sao</span></div>
                <div class="filter-item" data-sort="4"><i class="fas fa-check"></i><span>4
                        sao</span></div>
                <div class="filter-item" data-sort="5"><i class="fas fa-check"></i><span>3
                        sao</span></div>
                <div class="filter-item" data-sort="6"><i class="fas fa-check"></i><span>2
                        sao</span></div>
                <div class="filter-item" data-sort="7"><i class="fas fa-check"></i><span>1
                        sao</span></div>
            </div>
        </div>
    </div>
    <div class="line"></div>
    <div class="user-wrapper">
        @foreach ( $comments as $comment)
        @php
        $fullname = $comment->fullname;
        $star = generateStar($comment->rate);
        $description = $comment->description;
        $date = convertDatetime($comment->created_at, 'd/m/Y');
        @endphp
        <div class="user-block">
            <div class="avatar">
                <div class="avatar-shape avatar-shape-text">
                    <span class="avatar-text">{{abbreviateName($fullname)}}</span>
                </div>
                <div class="avatar-info">
                    <div class="avatar-name">
                        <div class="text">{{$fullname}}</div>
                        <div class="verify">
                            <div class="label label-xs">
                                <i class="fas fa-check-circle"></i>
                                <span class="alert-text label-text">Đã mua hàng</span>
                            </div>
                        </div>
                    </div>
                    <div class="avatar-rate">
                        <div class="star">
                            {!!$star!!}
                        </div>
                    </div>
                    <div class="avatar-para">
                        <div class="text">{{$description}}</div>
                    </div>
                    <div class="avatar-time">
                        <div class="text">Ngày {{ $date }}</div>
                        {{-- <i class="fas fa-circle"></i> --}}
                        {{-- Mac dinh khong co like --}}
                        {{-- <div class="link link-xs">Thích </div> --}}
                        {{-- Khi co like --}}
                        {{-- <div class="link link-xs link-icon">
                            <i class="fas fa-thumbs-up"></i>Thích (1)
                        </div> --}}
                        {{-- <i class="fas fa-circle"></i>
                        <div class="link link-xs">Trả lời</div> --}}
                    </div>
                </div>
            </div>
        </div>
        {{-- <div class="user-block reply">
            <div class="avatar">
                <div class="avatar-shape avatar-shape-text">
                    <span class="avatar-text">MT</span>
                    <!-- <img class="avatar-img" src="https://fptshop.com.vn/api-data/comment/Content/desktop/images/logo.png" alt=""> -->
                </div>
                <div class="avatar-info">
                    <div class="avatar-name">
                        <div class="text">Nguyễn Văn Huy</div>
                        <span class="badge badge-grayscale badge-xxs m-l-4">Quản trị viên</span>
                    </div>
                    <div class="avatar-para">
                        <div class="text">Chào anh Định,
                            Dạ, với mẫu Samsung Galaxy Z Flip5 5G 256GB hiện chưa có ưu đãi tặng kèm ốp lưng
                            và
                            chưa dán cường lực miễn phí rồi ạ. Để được hỗ trợ chi tiết về sản phẩm, anh vui lòng
                            liên
                            hệ tổng đài miễn phí 18006601 hoặc để lại SĐT bên em liên hệ tư vấn nhanh nhất ạ.

                            Thân mến!</div>
                    </div>
                    <div class="avatar-time">
                        <div class="text">Ngày 08/01/2024</div>
                        <i class="fas fa-circle"></i>
                        <div class="link link-xs">Thích </div>
                        <i class="fas fa-circle"></i>
                        <div class="link link-xs">Trả lời</div>
                    </div>
                </div>
            </div>

        </div> --}}
        @endforeach

        <div class="product-pagination avatar-pagination">
            <ul class="pagination justify-content-center">
                <li class="page-item">
                    <a class="page-link" href="http://127.0.0.1:8000/dien-thoai?page=1" rel="prev"
                        aria-label="pagination.previous">‹</a>
                </li>

                <li class="page-item">
                    <a class="page-link" href="http://127.0.0.1:8000/dien-thoai?page=1">1</a>
                </li>
                <li class="page-item active" aria-current="page">
                    <span class="page-link">2</span>
                </li>

                <li class="page-item disabled" aria-disabled="true" aria-label="pagination.next">
                    <span class="page-link" aria-hidden="true">›</span>
                </li>
            </ul>
        </div>
    </div>

    <div class="modal fade quick-view-product review-comment-modal" id="comment-modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i
                            class="far fa-times"></i></button>
                </div>
                <div class="modal-body">
                    {!! Form::open(['method' => 'post', 'id' => 'form-review']) !!}
                    <div class="user-rate__modal"><img
                            src="https://images.fpt.shop/unsafe/fit-in/96x96/filters:quality(90):fill(white)/fptshop.com.vn/Uploads/Originals/2024/3/28/638472353992099331_samsung-galaxy-zflip-5-xanh-ai.jpg"
                            alt="alt">
                        <div class="h6 medium">{{$model->name}}</div>
                        <div class="rating-wrapper d-flex-center mb--20">
                            <div class="reating-inner ml--20">
                                <div class="form-group">
                                    <input type="hidden" name="rate" id="currentRating">
                                    <div class="invalid-feedback text-start"></div>
                                </div>
                                <input type="hidden" name="commentable_id" value="{{$model->id}}">
                                <input type="hidden" name="commentable_type" value="{{$reviewableType}}">
                                <input type="hidden" name="parent_id" value="{{0}}">
                                @foreach (__('product.rating') as $rating)
                                <span data-rating="{{$rating['star']}}" data-text="{{$rating['text']}}" class="star"><i
                                        class="fas fa-star"></i></span>
                                @endforeach
                            </div>
                            <div class="text"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::textarea('description', old('description'), ['class' => 'form-control
                            form-input-md',
                            'placeholder' =>
                            'Hãy chia sẻ cảm nhận của bạn về sản phẩm...', 'data-validate' => 'required']) !!}
                            <div class="invalid-feedback text-start"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::text('fullname', old('fullname', $user->fullname ?? ''), ['class' => 'form-control
                            form-input-md', 'placeholder' => 'Nhập họ và tên', 'data-validate' => 'required']) !!}
                            <div class="invalid-feedback text-start"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::text('phone', old('phone', $user->phone ?? ''), ['class' => 'form-control
                            form-input-md ', 'placeholder' => 'Nhập số điện thoại', 'data-validate' =>
                            'required|phone'])
                            !!}
                            <div class="invalid-feedback text-start"></div>
                        </div>
                        <div class="form-group">
                            {!! Form::text('email', old('email', $user->email ?? ''), ['class' => 'form-control
                            form-input-md', 'placeholder' => 'Nhập email (để nhận thông báo phản hồi)', 'data-validate'
                            =>
                            'required|email']) !!}
                            <div class="invalid-feedback text-start"></div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer justify-content-center">
                    <div class="">
                        <button type="submit" class="btn btn-success fs-4 py-2 px-4 text-white">HOÀN TẤT</button>
                    </div>
                </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>