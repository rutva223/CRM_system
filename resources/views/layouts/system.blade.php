<div class="col-xl-2 col-xxl-3">
    <div class="file-left-body">
        <div class="email-left-body">
            <div class="email-left-box border-end  dlab-scroll" id="email-left">
                <div class="mail-list rounded ">
                    <a href="{{ route('pipelines.index') }}" class="list-group-item {{ request()->is('pipelines') ? 'active' : '' }} "><i class="fa fa-genderless"></i>Pipeline<span class="badge badge-purple badge-sm float-end">2</span> </a>
                    <a href="{{ route('deal-stages.index') }}" class="list-group-item {{ request()->is('deal-stages') ? 'active' : '' }} "><i class="fa fa-genderless"></i>Deal Stage <span class="badge badge-purple badge-sm float-end">2</span> </a>
                    <a href="{{ route('dealtypes.index') }}" class="list-group-item {{ request()->is('dealtypes') ? 'active' : '' }} "><i class="fa fa-genderless"></i>Deal Type <span class="badge badge-purple badge-sm float-end">2</span> </a>
                    <a href="{{ route('labels.index') }}" class="list-group-item {{ request()->is('labels') ? 'active' : '' }} "><i class="fa fa-genderless"></i>Label <span class="badge badge-purple badge-sm float-end">2</span> </a>
                </div>
            </div>
        </div>
    </div>
</div>
