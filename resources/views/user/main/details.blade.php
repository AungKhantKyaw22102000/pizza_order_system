@extends('user.layouts.master')

@section('title', 'Product Detail')

@section('content')

    <!-- Shop Detail Start -->
    <div class="container-fluid pb-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 mb-30">
                <p onclick="history.back()"><i class="fa-solid fa-backward text-dark me-1"></i> back</p>
                <div id="product-carousel" class="carousel slide mt-3" data-ride="carousel">
                    <div class="carousel-inner bg-light">
                        <div class="carousel-item active">
                            <img class="w-100 h-100" src="{{ asset('storage/' . $pizza->image) }}" alt="{{ $pizza->name }}">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-7 h-auto mb-30 mt-3">
                <div class="h-100 bg-light p-30">
                    <h3>{{ $pizza->name }}</h3>
                    <small>Rating 4.5/5</small>
                    <div class="text-primary mb-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <i class="fas fa-star text-dark"></i>
                        @endfor
                    </div>
                    <p class="mt-3">{{ $pizza->description }}</p>
                    <div class="d-flex mb-3">
                        <small class="pt-1"><i class="fa-solid fa-eye me-2"></i>{{ $pizza->view_count + 1 }} </small>
                    </div>
                    <h3 class="font-weight-semi-bold mb-4">{{ $pizza->price }} Kyats</h3>
                    <div class="d-flex align-items-center mb-4 pt-2">
                        <div class="input-group quantity mr-3" style="width: 130px;">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-minus">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <input type="text" class="form-control bg-secondary border-0 text-center" value="1"
                                id="orderCount">
                            <div class="input-group-btn">
                                <button class="btn btn-primary btn-plus">
                                    <i class="fa fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" value="{{ Auth::user()->id }}" id="userId">
                        <input type="hidden" id="pizzaId" value="{{ $pizza->id }}">
                        <button class="btn btn-primary px-3" id="addCartBtn" type="button"><i
                                class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                    </div>
                    <div class="d-flex pt-2">
                        <strong class="text-dark mr-2">Share on:</strong>
                        <div class="d-inline-flex">
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            <a class="text-dark px-2" href="">
                                <i class="fab fa-pinterest"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="bg-light p-30">
                    <div class="nav nav-tabs mb-4">
                        <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Reviews
                            {{ count($ratings) }}</a>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="tab-pane-1">
                            <div class="row">
                                <div class="col-md-6">
                                    @if (session('createSuccess'))
                                        <div id="success">
                                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                                <i class="fa-solid fa-check"></i> {{ session('createSuccess') }}
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                    aria-label="Close"></button>
                                            </div>
                                        </div>
                                    @endif
                                    <h4 class="mb-4">Review for "{{ $pizza->name }}"</h4>
                                    @foreach ($ratings as $rating)
                                        <div class="media mb-4">
                                            @if ($rating->user->iamge == null)
                                                @if ($rating->user->gender == 'male')
                                                    <img src="{{ asset('image/default_user.jpg') }}"
                                                        alt="{{ $rating->user->name }}" class="img-fluid mr-3 mt-1"
                                                        style="width: 45px;">
                                                @else
                                                    <img src="{{ asset('image/female_default.png') }}"
                                                        alt="{{ $rating->user->name }}" class="img-fluid mr-3 mt-1"
                                                        style="width: 45px;">
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $rating->user->image) }}"
                                                    alt="{{ $rating->user->name }}" class="img-fluid mr-3 mt-1"
                                                    style="width: 45px;">
                                            @endif
                                            <div class="media-body">
                                                <h6>{{ $rating->user->name }}<small> -
                                                        <i>{{ $rating->created_at->format('d-M-Y') }}</i></small></h6>
                                                <div class="text-primary mb-2">
                                                    @for ($i = 1; $i <= 5; $i++)
                                                        @if ($i <= $rating->rating_count)
                                                            <i class="fas fa-star"></i>
                                                        @else
                                                            <i class="far fa-star"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                                <p>{{ $rating->message }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-md-6">
                                    <h4 class="mb-4">Leave a review</h4>
                                    <form method="POST" action="{{ route('user#ratingCreate') }}" class="mt-1">
                                        @csrf
                                        <input type="hidden" value="{{ $pizza->id }}" name="productId">
                                        <input type="hidden" value="{{ Auth::user()->id }}" name="userId">
                                        <div class="form-group">
                                            <label for="">Your Rating * :</label>
                                            <input type="range" name="ratingCount" min="0" max="5"
                                                id="">
                                        </div>
                                        <div class="form-group">
                                            <label for="message">Your Review *</label>
                                            <textarea name="ratingMessage" id="message" cols="30" rows="5" class="form-control"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Your Name *</label>
                                            <input name='userName' type="text" class="form-control" id="name">
                                        </div>
                                        <div class="form-group mb-0">
                                            <input type="submit" value="Leave Your Review" class="btn btn-primary px-3">
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">You May
                Also Like</span></h2>
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel related-carousel">
                    @foreach ($pizzaList as $p)
                        <div class="product-item bg-light">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid w-100" src="{{ asset('storage/' . $p->image) }}"
                                    style="height: 250px" alt="">
                                <div class="product-action">
                                    <a class="btn btn-outline-dark btn-square" href=""><i
                                            class="fa fa-shopping-cart"></i></a>
                                    <a class="btn btn-outline-dark btn-square"
                                        href="{{ route('user#pizzaDetails', $p->id) }}"><i
                                            class="fa-solid fa-circle-info"></i></a>
                                </div>
                            </div>
                            <div class="text-center py-4">
                                <a class="h6 text-decoration-none text-truncate" href="">{{ $p->name }}</a>
                                <div class="d-flex align-items-center justify-content-center mt-2">
                                    <h5>{{ $p->price }} Kyats</h5>
                                    <h6 class="text-muted ml-2"></h6>
                                </div>
                                <div class="d-flex align-items-center justify-content-center mb-1">
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small class="fa fa-star text-primary mr-1"></small>
                                    <small>(99)</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Products End -->

@endsection

@section('scriptSource')
    <script>
        $(document).ready(function() {

            // increase view count
            $.ajax({
                type: 'get',
                url: 'http://127.0.0.1:8000/user/ajax/increase/viewCount',
                data: {
                    'productId': $('#pizzaId').val(),
                },
                dataType: 'json',
            })

            // click add to cart btn
            $('#addCartBtn').click(function() {
                $source = {
                    'userId': $('#userId').val(),
                    'pizzaId': $('#pizzaId').val(),
                    'count': $('#orderCount').val(),
                };

                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/user/ajax/addToCart',
                    data: $source,
                    dataType: 'json',
                    success: function(response) {
                        if (response.status == 'success') {
                            window.location.href = "http://127.0.0.1:8000/user/homePage"
                        }
                    }
                })
            })
        })
    </script>
@endsection
