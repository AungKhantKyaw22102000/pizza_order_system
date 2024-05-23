@extends('admin.layouts.master')

@section('title', 'Order List Page')

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
                                <h2 class="title-1">Order List</h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-3">
                            {{-- <h3 class="text-secondary"><i class="fa-solid fa-database"></i> ({{ $order->total() }})  </h3> --}}
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('product#list') }}" method="get">
                                @csrf
                                <div class="d-flex">
                                    <input type="text" name="key" class="form-control" value=" {{ request('key') }}"
                                        id="" placeholder="Search...">
                                    <button class="btn bg-dark text-white" type="submit">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </div>
                            </form>
                            <br>
                        </div>
                        <div class="row mt-2">
                            <div class="col-1 offset-10 bg-white shadow-sm p-2 mb-2 text-center">
                                <h3 class="text-secondary"><i class="fa-solid fa-database"></i> {{ count($order) }} </h3>
                            </div>
                        </div>

                        <form action="{{ route('admin#changeStatus') }}" method="post" class="col-5">
                            @csrf
                            <div class="d-flex my-3">
                                <div class="input-group mb-3">
                                    <div class="input-group mb-3">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <h3 class="text-secondary"><i class="fa-solid fa-database"></i> {{ count($order) }} </h3>
                                            </span>
                                        </div>
                                        <select class="form-select" name="orderStatus" id="inputGroupSelect04" aria-label="Example select with button addon">
                                          <option value="">All</option>
                                          <option value="0" @if(request('orderStatus') == '0') selected @endif>Pending</option>
                                          <option value="1" @if(request('orderStatus') == '1') selected @endif>Success</option>
                                          <option value="2" @if(request('orderStatus') == '2') selected @endif>Reject</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn bg-dark text-white ms-3" type="submit"><i class="fa-solid fa-magnifying-glass me-2"></i>Search</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    @if (count($order) != 0)
                        <div class="table-responsive table-responsive-data2">
                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>User ID</th>
                                        <th>User Name</th>
                                        <th>Order Date</th>
                                        <th>Order Code</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="dataList">
                                    @foreach ($order as $o)
                                        <tr class="tr-shadow">
                                            <input type="hidden" name="" class="orderId"
                                                value="{{ $o->id }}">
                                            <td>{{ $o->user_id }}</td>
                                            <td>{{ $o->user_name }}</td>
                                            <td>{{ $o->created_at->format('M-d-Y') }}</td>
                                            <td>
                                                <a href="{{ route('admin#orderListInfo', $o->order_code) }}" class="text-primary">{{ $o->order_code }}</a>
                                            </td>
                                            <td>{{ $o->total_price }} Kyats</td>
                                            <td class="align-middle">
                                                <select name="status" class="form-control statusChange">
                                                    <option value="0"
                                                        @if ($o->status == 0) selected @endif>Pending</option>
                                                    <option value="1"
                                                        @if ($o->status == 1) selected @endif>Success</option>
                                                    <option value="2"
                                                        @if ($o->status == 2) selected @endif>Reject</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr class="spacer"></tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="mt-3">
                                {{-- {{ $order->links() }} --}}
                                {{-- {{ $categories->appends(request()->query())->links() }} --}}
                            </div>
                        </div>
                    @else
                        <h3 class="text-secondary text-center mt-5">There is no Order Here!</h>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')
    <script>
        $(document).ready(function() {
            // $('#orderStatus').change(function(){
            //     $status = $('#orderStatus').val();
            //     $.ajax({
            //         type : 'get',
            //         url : 'http://127.0.0.1:8000/order/ajax/status',
            //         data : {
            //             'status' : $status ,
            //         } ,
            //         dataType : 'json' ,
            //         success : function(response){

            //             // append
            //             $list = '';
            //             for($i=0;$i<response.length;$i++){

            //                 $months = ['Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sep','Oct','Nov','Dec']
            //                 $dbDate = new Date(response[$i].created_at);
            //                 $finalDate = $months[$dbDate.getMonth()]+'-'+$dbDate.getDate()+'-'+$dbDate.getFullYear()

            //                 if(response[$i].status == 0) {
            //                     $statusMessage = `
        //                     <select name="status" id="" class="form-control statusChange">
        //                         <option value="0" selected>Pending</option>
        //                         <option value="1" >Success</option>
        //                         <option value="2" >Reject</option>
        //                     </select>
        //                     `;
            //                 } else if(response[$i].status == 1) {
            //                     $statusMessage = `
        //                     <select name="status" id="" class="form-control statusChange">
        //                         <option value="0">Pending</option>
        //                         <option value="1" selected>Success</option>
        //                         <option value="2" >Reject</option>
        //                     </select>
        //                     `;
            //                 } else if(response[$i].status == 2) {
            //                     $statusMessage = `
        //                     <select name="status" id="" class="form-control statusChange">
        //                         <option value="0">Pending</option>
        //                         <option value="1" >Success</option>
        //                         <option value="2" selected>Reject</option>
        //                     </select>
        //                     `;
            //                 }

            //                 $list += `
        //                 <tr class="tr-shadow">
        //                     <input type="hidden" name="" class="orderId" value="${response[$i].id}">
        //                     <td>${response[$i].user_id}</td>
        //                     <td>${response[$i].user_name}</td>
        //                     <td>${$finalDate}</td>
        //                     <td>${response[$i].order_code}</td>
        //                     <td>${response[$i].total_price} Kyats</td>
        //                     <td>${$statusMessage}</td>
        //                 </tr>
        //                 <tr class="spacer"></tr>
        //                 `;
            //             }
            //             $('#dataList').html($list);
            //         }
            //     })
            // })

            // change status
            $('.statusChange').change(function() {

                $currentStatus = $(this).val();
                $parentNode = $(this).parents("tr");
                $orderId = $parentNode.find('.orderId').val();

                $data = {
                    'status': $currentStatus,
                    'orderId': $orderId,
                };

                $.ajax({
                    type: 'get',
                    url: 'http://127.0.0.1:8000/order/ajax/change/status',
                    data: $data,
                    dataType: 'json'
                })
            })
        })
    </script>
@endsection
