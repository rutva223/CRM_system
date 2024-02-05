{{Form::open(array('url'=>'deals','method'=>'post'))}}

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
                {{Form::label('price',__('Price'),['class'=>'form-label'])}}
                {{Form::number('price',null,array('class'=>'form-control','placeholder'=>__('Enter User Email'),'required'=>'required'))}}
                @error('price')
                <small class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="form-group col-md-12">
            {{ Form::label('client', __('Clients'),['class'=>'form-label']) }}
            {!! Form::select('client', $client, null,array('class' => 'form-control select','required'=>'required')) !!}
            <div class=" text-xs">
                {{ __('Please create client here.') }}
                <a class="text-primary" href="{{ route('client.index') }}"><b>{{ __('Create Client') }}</b></a>
            </div>
            @error('client')
            <small class="invalid-role" role="alert">
                <strong class="text-danger">{{ $message }}</strong>
            </small>
            @enderror
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
</div>

{{Form::close()}}

