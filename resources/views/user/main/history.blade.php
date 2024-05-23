@extends('user.layouts.master')

@section('title', 'History')

@section('content')
    <!-- Cart Start -->
    <div class="container-fluid" style="height: 400px">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5 offset-2">
                <table class="table table-light table-borderless table-hover text-center mb-0" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Date</th>
                            <th>Order Id</th>
                            <th>Total Price</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        @foreach ($order as $o)
                            <tr>
                                <td class="align-middle col-3">{{ $o->created_at->format('M-j-Y') }}</td>
                                <td class="align-middle col-3">{{ $o->order_code }}</td>
                                <td class="align-middle col-3">{{ $o->total_price }} Kyats</td>
                                <td class="align-middle col-3">
                                    @if ($o->status == 0)
                                        <span class="text-warning rounded-sm"><i class="fa-solid fa-hourglass-half me-2"></i> Pending...</span>
                                    @elseif($o->status == 1)
                                        <span class="text-success rounded-sm"><i class="fa-solid fa-check me-2"></i> Success...</span>
                                    @elseif($o->status == 2)
                                        <span class="text-danger rounded-sm"><i class="fa-solid fa-triangle-exclamation me-2"></i> Reject...</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $order->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->
@endsection

@section('scriptSource')

@endsection
