{{Form::open(array('url'=>'deals','method'=>'post'))}}

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                {{Form::label('name',__('Name'),['class'=>'form-label required']) }}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-12 mb-3">
            {{ Form::label('pipeline', __('Pipeline'),['class'=>'form-label required']) }}
            <select name="pipeline" id="pipeline" class="form-control select" required>
                @foreach ($pipeline as $id=>$name)
                    <option value="{{ $id }}"  {{ $id == $select_pipeline ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-3">
                {{Form::label('amount',__('Amount'),['class'=>'form-label required'])}}
                {{Form::number('amount',null,array('class'=>'form-control','placeholder'=>__('Enter deal amount'),'required'=>'required'))}}
                @error('amount')
                <small class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-3">
                {{Form::label('close_date',__('Deal Close Date'),['class'=>'form-label required'])}}
                {{Form::date('close_date',null,array('class'=>'form-control','required'=>'required'))}}
                @error('close_date')
                <small class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-12 mb-3">
            {{ Form::label('stage_id', __('Deal Stage'),['class'=>'form-label required']) }}
            <select name="stage_id" id="stage_id" class="form-control select" required>
                <option value="">Select Deal Stage</option>
                @foreach ($deal_stage as $id=>$name)
                    <option value="{{ $id }}"  {{ $name == $select_stage ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-12 mb-3">
            {{ Form::label('priority', __('Priority'),['class'=>'form-label required']) }}
            <select name="priority" id="priority" class="form-control select" required>
                <option value="">Select Deal Stage</option>
                @foreach ($priority as $id=>$name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-12 mb-3">
            {{ Form::label('user', __('Owner'),['class'=>'form-label required']) }}
            {!! Form::select('user', $users, null,array('class' => 'form-control select','required'=>'required')) !!}
            <div class=" text-xs">
                {{ __('Please create user here.') }}
                <a class="text-primary" href="{{ route('users.index') }}"><b>{{ __('Create User') }}</b></a>
            </div>
            @error('user')
            <small class="invalid-role" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary" id="createButton" disabled>
</div>

{{Form::close()}}
<script>
            $('.multi-select').select2();

</script>
<script src="{{ asset('assets/js/required.js') }}"></script>




