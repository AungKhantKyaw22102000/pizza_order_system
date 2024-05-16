@extends('admin.layouts.master')

@section('title', 'Edit Info Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-lg-10 offset-1">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-title">
                                <h3 class="text-center title-2">Edit Profile</h3>
                            </div>
                            
                            <hr>
                            <form action="">
                                <div class="row">
                                    <div class="col-4 offset-1">
                                        @if (Auth::user()->image == null)
                                            <img src="{{ asset('image/default_user.jpg') }}" alt="{{ Auth::user()->name }}" class=" img-thumbnail shadow-sm" />
                                        @else
                                            <img src="{{ asset('admin/images/icon/avatar-01.jpg') }}" alt="{{ Auth::user()->name }}" class=" img-thumbnail shadow-sm">
                                        @endif

                                        <div class="">
                                            <input type="file" name="image" class="form-control">
                                        </div>
                                    </div>
                                    <div class="row col-6">
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Name</label>
                                            <input id="cc-pament" name="name" type="text" value="{{ old('name',Auth::user()->name)}}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Admin Name...">
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Email</label>
                                            <input id="cc-pament" name="email" type="text" value="{{ old('email',Auth::user()->email)}}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Admin Email...">
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Phone</label>
                                            <input id="cc-pament" name="phone" type="text" value="{{ old('phone',Auth::user()->phone)}}" class="form-control" aria-required="true" aria-invalid="false" placeholder="Enter Admin Phone...">
                                            
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Address</label>
                                            <textarea name="address" class="form-control " cols="30" rows="10" placeholder="Enter Admin Address">{{ old('name',Auth::user()->address)}}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="cc-payment" class="control-label mb-1">Role</label>
                                            <input id="cc-pament" name="role" type="text" value="{{ old('role', Auth::user()->role)}}" class="form-control" aria-required="true" aria-invalid="false" disabled>
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
