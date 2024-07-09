@extends('admin.layouts.master')

@section('title', 'Category List Page')

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
                                <h2 class="title-1">Contact List</h2>
                            </div>
                        </div>
                        <a href="{{ route('download#contactCsv') }}">
                            <div class="table-data__tool-right">
                                <button class="au-btn au-btn-icon au-btn--green au-btn--small">
                                    CSV download
                                </button>
                            </div>
                        </a>
                    </div>

                    @if (session('createSuccess'))
                    <div class="col-4 offset-8">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fa-solid fa-check"></i> {{ session('createSuccess') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

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
                            {{-- <h3 class="text-secondary"><i class="fa-solid fa-database"></i> ({{ $categories->total() }})  </h3> --}}
                        </div>
                        <div class="col-3 offset-6">
                            <form action="{{ route('contact#list') }}" method="get">
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
                                <h3 class="text-secondary"><i class="fa-solid fa-database"></i> ({{ $contacts->total() }})  </h3>
                            </div>
                        </div>
                    </div>

                    @if (count($contacts) != 0)
                    <div class="table-responsive table-responsive-data2">
                        <table class="table table-data2 text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact Subject</th>
                                    <th>Contact Message</th>
                                    <th>Created Date</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($contacts as $contact)
                                <tr class="tr-shadow">
                                    <td>{{ $contact->id }}</td>
                                    <td class="col-2">{{ $contact->name }}</td>
                                    <td class="col-2">{{ $contact->email }}</td>
                                    <td class="col-2">{{ $contact->subject }}</td>
                                    <td class="col-2">{{ $contact->message }}</td>
                                    <td>{{ $contact->created_at->format('d-M-Y') }}</td>
                                    <td>
                                        <div class="table-data-feature justify-content-center">
                                            <a href="{{ route('contact#delete',$contact->id) }}">
                                                <button class="item me-1" data-toggle="tooltip" data-placement="top" title="Delete">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </button>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="spacer"></tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {{ $contacts->links() }}
                            {{-- {{ $categories->appends(request()->query())->links() }} --}}
                        </div>
                    </div>
                    @else
                    <h3 class="text-secondary text-center mt-5">There is no Contact Here!</h>
                    @endif
                    <!-- END DATA TABLE -->
                </div>
            </div>
        </div>
    </div>
    <!-- END MAIN CONTENT-->
@endsection
