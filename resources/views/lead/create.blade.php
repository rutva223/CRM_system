{{Form::open(array('url'=>'leads','method'=>'post'))}}

<div class="modal-body">
    <div class="row">
            <div class="col-md-6 form-group mb-3">
                {{Form::label('name',__('Name'),['class'=>'form-label required']) }}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        <div class="col-md-6 form-group mb-3 ">
            {{ Form::label('email', __('Email'),['class'=>'form-label']) }}
            {{ Form::text('email', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-md-6 form-group mb-3">
            {{ Form::label('subject', __('Subject'),['class'=>'form-label']) }}
            {{ Form::text('subject', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="form-group col-md-6 mb-3">
            {{ Form::label('pipeline_id', __('Pipeline'),['class'=>'form-label required']) }}
            <select name="pipeline_id" id="pipeline_id" class="form-control select" required>
                @foreach ($pipeline as $id=>$name)
                    <option value="{{ $id }}"  {{ $id == $select_pipeline ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
            <div class="form-group mb-3 col-md-6">
                {{Form::label('amount',__('Amount'),['class'=>'form-label required'])}}
                {{Form::number('amount',null,array('class'=>'form-control','placeholder'=>__('Enter lead amount'),'required'=>'required'))}}
                @error('amount')
                <small class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        <div class="form-group col-md-6 mb-3">
            {{ Form::label('stage_id', __('Lead Stage'),['class'=>'form-label required']) }}
            <select name="stage_id" id="stage_id" class="form-control select" required>
                <option value="">Select lead Stage</option>
                @foreach ($lead_stage as $id=>$name)
                    <option value="{{ $id }}"  {{ $name == $select_stage ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-6 mb-3">
            {{ Form::label('priority', __('Priority'),['class'=>'form-label required']) }}
            <select name="priority" id="priority" class="form-control select" required>
                <option value="">Select lead Stage</option>
                @foreach ($priority as $id=>$name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group col-md-6 mb-3">
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
            <div class="form-group mb-3 col-md-12">
                {{Form::label('description',__('Note'),['class'=>'form-label required'])}}
                {{Form::textarea('description', null, array('class'=>'form-control','placeholder'=>__('Enter About This Lead'),'required'=>'required','rows'=>'3'))}}
                @error('description')
                <small class="invalid-description" role="alert">
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




