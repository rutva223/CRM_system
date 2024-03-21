@extends('layouts.main')

@section('title')
    {{ __('Manage Product') }}
@endsection
@section('page-breadcrumb')
    {{ __   ('Product') }}
@endsection
@section('page-action')
        <a href="#" data-size="lg" data-url="{{ route('products.create') }}" data-ajax-popup="true"
            data-bs-toggle="tooltip" data-title="{{ __('Add New Product') }}" class="btn btn-sm btn-primary">
            <i class="fa fa-plus text-white"></i>
        </a>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><i class="fa-solid fa-file-lines me-1"></i>Product List</h4>
        </div>
        <div class="card-body pb-4">
            <div class="table-responsive">
                <table class="display" id="example" >
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Product Type</th>
                            <th>Unit Price</th>
                            <th>Unit Cost</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $index => $product)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->SKU }}</td>
                                <td>{{ $product->product_type }}</td>
                                <td>{{ $product->unit_price }}</td>
                                <td>{{ $product->unit_cost }}</td>
                                <td>{{ $product->description }}</td>
                                <td >
                                    <div class="d-flex">
                                        <a href="#!" data-size="lg" data-url="{{ route('products.edit', $product->id) }}" data-ajax-popup="true" class="btn btn-primary shadow btn-sm sharp me-1 text-white" data-title="{{ __('Edit Product') }}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        {!! Form::open(['method' => 'DELETE', 'route' => ['products.destroy', $product->id]]) !!}
                                        <a href="javascript:;" class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                            title="Delete data">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        {!! Form::close() !!}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')

@endpush




