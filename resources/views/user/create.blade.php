{{Form::open(array('url'=>'users','method'=>'post'))}}

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                {{Form::label('name',__('Name'),['class'=>'form-label']) }}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-3">
                {{Form::label('email',__('Email'),['class'=>'form-label'])}}
                {{Form::email('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
                @error('email')
                <small class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-3">
                {{Form::label('password',__('Password'),['class'=>'form-label'])}}
                {{Form::password('password',array('class'=>'form-control','placeholder'=>__('Enter User Password'),'required'=>'required','minlength'=>"6"))}}
                @error('password')
                <small class="invalid-password" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        @if (Session::get('user_type') != 'super admin')
            <div class="form-group col-md-12">
                {{ Form::label('roles', __('User Role'),['class'=>'form-label']) }}
                {!! Form::select('roles', $roles, null,array('class' => 'form-control select','required'=>'required')) !!}
                <div class=" text-xs">
                    {{ __('Please create role here. ') }}
                    <a class="text-primary" href="{{ route('roles.index') }}"><b>{{ __('Create role') }}</b></a>
                </div>
                @error('roles')
                <small class="invalid-role" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        @endif
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
</div>

{{Form::close()}}

