
{{ Form::model($user, array('route' => array('users.update', $user->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class' => 'col-form-label']) }}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('email',__('Email'),['class' => 'col-form-label'])}}
                {{Form::text('email',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
            </div>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('role', __('User Role'),['class'=>'form-label']) }}
            {!! Form::select('role', $roles, null,array('class' => 'form-control select','required'=>'required')) !!}
            @error('role')
            <small class="invalid-role" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary">{{__('Update')}}</button>
</div>
{{ Form::close() }}
