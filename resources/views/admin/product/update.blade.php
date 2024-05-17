@extends('admin.layouts.master')

@section('title', 'Update Product Info Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="ms-5">
                                <i class="fa-solid fa-backward text-dark" onclick="history.back()"></i>
                            </div>
                            {{-- <div class="ms-5">
                                <a href="{{ route('product#list') }}">
                                    <i class="fa-solid fa-backward text-dark"></i>
                                </a>
                            </div> --}}
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Product</h3>
                            </div>

                            <hr>
                            <form action="{{ route('product#update') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        <input type="hidden" name="pizzaId" value="{{ $pizza->id }}">
                                        <img src="{{ asset('storage/'.$pizza->image) }}" alt="{{ $pizza->name }}" class=" img-thumbnail shadow-sm">
                                        <div class="mt-3">
                                            <input type="file" name="productImage" class="form-control @error('productImage') is-invalid @enderror">
                                            @error('productImage')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="mt-3">
                                            <button class="btn bg-dark text-white col-12" type="submit">
                                                <i class="fa-solid fa-circle-arrow-right me-1"></i> Update
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="productName" type="text" value="{{ old('productName',$pizza->name)}}" class="form-control @error('productName') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Product Name...">
                                            @error('productName')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Description</label>
                                            <textarea name="productDescription" class="form-control @error('productDescription') is-invalid @enderror" cols="30" rows="10" placeholder="Enter Product Description">{{ old('productDescription',$pizza->description)}}</textarea>
                                            @error('productDescription')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Category</label>
                                            <select name="productCategory" id="" class="form-control @error('productCategory') is-invalid @enderror">
                                                <option value="">Choose Category...</optioncl>
                                                @foreach ($category as $c)
                                                    <option value="{{ $c->id }}" @if($pizza->category_id == $c->id) selected @endif>{{ $c->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('productCategory')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Price</label>
                                            <input id="cc-pament" name="productPrice" type="number" value="{{ old('productPrice',$pizza->price)}}" class="form-control @error('productPrice') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Product Price...">
                                            @error('productPrice')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Waiting Time</label>
                                            <input id="cc-pament" name="waitingTime" type="number" value="{{ old('waitingTime',$pizza->waiting_time)}}" class="form-control @error('waitingTime') is-invalid @enderror" aria-required="true" aria-invalid="false" placeholder="Enter Waiting Time...">
                                            @error('waitingTime')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">View Count</label>
                                            <input id="cc-pament" name="viewCount" type="number" value="{{ old('viewCount',$pizza->view_count)}}" class="form-control @error('viewCount') is-invalid @enderror" aria-required="true" aria-invalid="false" readonly>
                                            @error('viewCount')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                        </div>

                                        <div class="form-group">
                                            <label for="">Created Time</label>
                                            <input id="cc-pament" type="text" readonly name="created_at" value="{{ $pizza->created_at->format('d-M-Y') }}" class="form-control" aria-relevant="true" aria-invalid="false">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
