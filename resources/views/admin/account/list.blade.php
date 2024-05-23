@extends('admin.layouts.master')

@section('title', 'Admin List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->

                    @if (session('deleteSuccess'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-circle-xmark"></i> {{ session('deleteSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    <div class="row">
                        <div class="col-3">
                            {{-- <h3 class="text-secondary"><i class="fa-solid fa-database"></i> ({{ $admin->total() }})  </h3> --}}
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('admin#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" value=" {{ request('key') }}" id="" placeholder="Search...">
                                    <button class="btn bg-dark text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                            <br>
                        </div>
                        <div class="row mt-2">
                            <div class="col-1 offset-10 bg-white shadow-sm p-2 mb-2 text-center">
                                <h3><i class="fa-solid fa-database"></i>  {{ $admin->total() }} </h3>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($admin as $a)
                                <tr class="tr-shadow">
                                    <input type="hidden" value="{{ $a->id }}" class="userId">
                                    <td class="col-2">
                                        @if ($a->image == null)
                                            @if($a->gender == 'male')
                                            <img src="{{ asset('image/default_user.jpg') }}" alt="{{ $a->name }}" class=" img-thumbnail" />
                                            @else
                                            <img src="{{ asset('image/female_default.png') }}" alt="{{ $a->name }}" class=" img-thumbnail" />
                                            @endif
                                        @else
                                            <img src="{{ asset('storage/'.$a->image) }}" alt="{{ $a->name }}" class=" img-thumbnail shadow-sm">
                                        @endif
                                    </td>
                                    <td>{{ $a->name }}</td>
                                    <td>{{ $a->email }}</td>
                                    <td>{{ $a->gender }}</td>
                                    <td>{{ $a->phone }}</td>
                                    <td>{{ $a->address }}</td>
                                    <td class="align-middle">
                                        @if (Auth::user()->id == $a->id)

                                        @else
                                        <select name="status" id="" class="form-control statusChange">
                                            <option value="admin" @if ($a->role == 'admin') selected @endif>Admin</option>
                                            <option value="user" @if ($a->role == 'user') selected @endif>User</option>
                                        </select>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="table-data-feature justify-content-center">
                                            @if (Auth::user()->id == $a->id)

                                            @else
                                            <a href=" {{ route('admin#delete',$a->id) }}">
                                                <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $admin->links() }}
                        </div>
                    </div>
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection


@section('scriptSection')
<script>
    $(document).ready(function(){
        $('.statusChange').change(function(){
            $currentStatus = $(this).val();
            $parentNode = $(this).parents("tr");
            $userId = $parentNode.find('.userId').val();
            $data = {
                'status' : $currentStatus ,
                'userId' : $userId
            }
            $.ajax({
                type: 'get',
                url : 'http://127.0.0.1:8000/admin/change/admin/role',
                data : {
                    'status' : $currentStatus ,
                    'userId' : $userId
                } ,
                dataType : 'json' ,
            })
        })
    })
</script>
@endsection
