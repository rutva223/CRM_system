@extends('layouts.main')

@section('title')
    {{ __('Manage Coupon') }}
@endsection
@section('page-breadcrumb')
    {{ __   ('Coupon') }}
@endsection
@section('page-action')
        <a href="#" data-size="md" data-url="{{ route('coupons.create') }}" data-ajax-popup="true"
            data-bs-toggle="tooltip" data-title="{{ __('Add New Coupon') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus text-white"></i>
        </a>
@endsection

@section('content')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fa-solid fa-file-lines me-1"></i>Coupons List</h4>
        </div>
        <div class="card-body pb-4">
            <div class="table-responsive">
                <table class="display" id="example" >
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Coupon Name</th>
                            <th>Coupon Code</th>
                            <th>Coupon Expire Date</th>
                            <th>Discount</th>
                            <th>Limit</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($coupons as $index => $coupon)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ $coupon->name }}</td>
                                <td>{{ $coupon->coupon_code }}</td>
                                <td>{{ $coupon->coupon_exp_date }}</td>
                                <td>{{ $coupon->discount }}</td>
                                <td>{{ $coupon->limit }}</td>
                                <td >
                                    <div class="d-flex">
                                        <a href="#!" data-size="md" data-url="{{ route('coupons.edit', $coupon->id) }}"
                                            data-ajax-popup="true" class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                            data-title="{{ __('Edit User') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['coupons.destroy', $coupon->id]]) !!}
                                        <a href="javascript:;" class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                            title="Delete data">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @empty
                            @include('layouts.nodatafound')
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
