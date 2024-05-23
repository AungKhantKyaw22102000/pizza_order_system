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
                        <div class="table-responsive table-responsive-data2">
                            <a href="{{ route('admin#orderList') }}" class=" text-dark"><i class="fa-solid fa-backward"></i> back</a>

                            <div class="card mt-4 col-4">
                                <div class="card-body">
                                    <h3><i class="fa-solid fa-clipboard me-3"></i>Order Info </h3>
                                    <small class="text-warning mt-3"><i class="fa-solid fa-triangle-exclamation me-3"></i>Include Delivery Charges</small>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-user me-3"></i>Customer Name</div>
                                        <div class="col">{{ strtoupper($orderList[0]->user_name) }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-barcode me-3"></i>Order Code</div>
                                        <div class="col">{{ $orderList[0]->order_code }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-clock me-3"></i> Order Date</div>
                                        <div class="col">{{ $orderList[0]->created_at->format('M-d-Y') }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col"><i class="fa-solid fa-money-bill-1-wave me-3"></i> Total Price</div>
                                        <div class="col">{{ $order->total_price }} Kyats</div>
                                    </div>
                                </div>
                            </div>

                            <table class="table table-data2 text-center">
                                <thead>
                                    <tr>
                                        <th>Order ID</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>Order Code</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody id="dataList">
                                    @foreach ($orderList as $o)
                                        <tr class="tr-shadow">
                                            <td class="align-middle">{{ $o->id }}</td>
                                            <td class="align-middle"><img style="width:100px;" src="{{ asset('storage/'.$o->product_image) }}" alt="" class="shadow-sm img-thumbnail"></td>
                                            <td class="align-middle">{{ $o->product_name }}</td>
                                            <td class="align-middle">{{ $o->created_at->format('M-d-Y') }}</td>
                                            <td class="align-middle">{{ $o->qty }}</td>
                                            <td class="align-middle">{{ $o->total }}</td>
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
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection

@section('scriptSection')

@endsection
