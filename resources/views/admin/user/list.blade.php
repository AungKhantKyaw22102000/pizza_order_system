@extends('admin.layouts.master')

@section('title', 'User List Page')

@section('content')
    <!-- MAIN CONTENT-->
    <div class="main-content">
        <div class="section__content section__content--p30">
            <div class="container-fluid">
                <div class="col-md-12">
                    <!-- DATA TABLE -->
                    <div class="table-data__tool">
                        <div class="table-data__tool-left">
                            <div class="overview-wrap">
                                <h2 class="title-1">Total - {{ $users->total() }}</h2>
                            </div>
                        </div>
                        <div class="table-data__tool-right">
                            <a href="{{ route('download#userCsv') }}">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    CSV download
                                </button>
                            </a>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            {{-- <h3 class="text-secondary"><i class="fa-solid fa-database"></i> ({{ $order->total() }})  </h3> --}}
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
                            <tbody id="dataList">
                                @foreach ($users as $user)
                                    <tr>
                                        <input type="hidden" value="{{ $user->id }}" class="userId">
                                        <td class="col-2">
                                            @if ($user->image == null)
                                                @if ($user->gender == 'male')
                                                    <img src="{{ asset('image/default_user.jpg') }}"
                                                        alt="{{ $user->name }}" class="img-thumbnail" />
                                                @else
                                                    <img src="{{ asset('image/female_default.png') }}"
                                                        alt="{{ $user->name }}" class="img-thumbnail" />
                                                @endif
                                            @else
                                                <img src="{{ asset('storage/' . $user->image) }}"
                                                    class="img-thumbnail" alt="{{ $user->name }}" class="img-thumbnail">
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->gender }}</td>
                                        <td>{{ $user->phone }}</td>
                                        <td>{{ $user->address }}</td>
                                        <td>
                                            <select name="userRole" id="" class="form-control changeUserRole">
                                                <option value="user" @if ($user->role == 'user') selected @endif>User</option>
                                                <option value="admin" @if ($user->role == 'admin') selected @endif>Admin</option>
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-5">
                            {{ $users->links() }}
                            {{-- {{ $categories->appends(request()->query())->links() }} --}}
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
            $('.changeUserRole').change(function(){
                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $userId = $parentNode.find('.userId').val();

                $data = {
                    'userId' : $userId,
                    'status' : $currentStatus
                };

                $.ajax({
                    type : 'get' ,
                    url : 'http://127.0.0.1:8000/admin/customer/change/user/status',
                    data : $data,
                    dataType : 'json',
                })

            })
        })
    </script>
@endsection
