@extends('layouts.main')
@section('page-title')
    {{-- {{ __(!empty(company_setting('hrm_branch_name')) ? company_setting('hrm_branch_name') : 'Branch') }} --}}
@endsection
@section('page-breadcrumb')
    {{ __('Branch') }}
@endsection
@section('page-action')
    <div>
        @can('branch create')
            <a class="btn btn-sm btn-primary" data-ajax-popup="true" data-size="md" data-title="{{ __('Create New Branch') }}"
                data-url="{{ route('branch.create') }}" data-toggle="tooltip" title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection
@section('content')
        @can('branch name edit')
            <div class="card">
                <div class="d-flex justify-content-between">
                    <div class="card-body table-border-style">
                        <h4>{{ !empty(company_setting('hrm_branch_name')) ? company_setting('hrm_branch_name') : __('Branch') }}
                        </h4>
                    </div>
                    <div class="d-flex align-items-center px-4">
                        <div class="action-btn bg-info">
                            <a class="mx-3 btn btn-sm  align-items-center" data-url="{{ route('branchname.edit') }}"
                                data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip" title=""
                                data-title="{{ __('Edit ' . (!empty(company_setting('hrm_branch_name')) ? company_setting('hrm_branch_name') : __('Branch'))) }}"
                                data-bs-original-title="{{ __('Edit Name') }}">
                                <i class="ti ti-pencil text-white"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endcan
        <div class="card">
            <div class="card-body table-border-style">
                <div class="table-responsive">
                    <table class="table mb-0 ">
                        <thead>
                            <tr>
                                <th>{{ !empty(company_setting('hrm_branch_name')) ? company_setting('hrm_branch_name') : __('Branch') }}
                                </th>
                                <th>Email</th>
                                <th>Phone No</th>
                                <th>Status</th>
                                <th>Address</th>
                                <th width="200px">{{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($branches as $branch)
                                <tr>
                                    <td>{{ !empty($branch->name) ? $branch->name : '' }}</td>
                                    <td>{{ !empty($branch->email) ? $branch->email : '' }}</td>
                                    <td>{{ !empty($branch->phone) ? $branch->phone : '' }}</td>
                                    <td>{{ !empty($branch->address) ? $branch->address : '' }}</td>
                                    <td>  @if ($branch->status == 'active')
                                        <span
                                            class="badge bg-success p-2 px-3 rounded">{{ Str::ucfirst($branch->status) }}</span>
                                    @else
                                        <span
                                            class="badge bg-danger p-2 px-3 rounded">{{ Str::ucfirst($branch->status) }}</span>
                                    @endif</td>
                                    <td >
                                        <div class="d-flex float-end">

                                            @can('edit branch')
                                                <a class="btn btn-primary shadow btn-sm sharp me-1 text-white"
                                                    data-url="{{ URL::to('branch/' . $branch->id . '/edit') }}"
                                                    data-ajax-popup="true" data-size="md" data-bs-toggle="tooltip"
                                                    title="" data-title="{{ __('Edit Branch') }}"
                                                    data-bs-original-title="{{ __('Edit') }}">
                                                    <i class="fa fa-edit text-white"></i>
                                                </a>
                                            @endcan
                                            @can('delete branch')
                                                    {{ Form::open(['route' => ['branch.destroy', $branch->id], 'class' => 'm-0']) }}
                                                    @method('DELETE')
                                                    <a class="btn btn-danger shadow btn-sm sharp text-white js-sweetalert"
                                                        data-bs-toggle="tooltip" title=""
                                                        data-bs-original-title="Delete" aria-label="Delete"
                                                        data-confirm="{{ __('Are You Sure?') }}"
                                                        data-text="{{ __('This action can not be undone. Do you want to continue?') }}"
                                                        data-confirm-yes="delete-form-{{ $branch->id }}"><i
                                                            class="ti ti-trash text-white text-white"></i></a>
                                                    {{ Form::close() }}
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <td colspan="2" class="text-center">NO data Found</th>
                                {{-- @include('layouts.nodatafound') --}}
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
