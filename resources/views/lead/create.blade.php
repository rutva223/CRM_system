{{Form::open(array('url'=>'leads','method'=>'post'))}}

<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group mb-3">
                {{Form::label('title',__('Title'),['class'=>'form-label']) }}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter User Title'),'required'=>'required'))}}
                @error('title')
                <small class="invalid-title" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-3">
                {{Form::label('user_id',__('Assign To'),['class'=>'form-label'])}}
                {{Form::select('user_id', $user, null, array('class'=>'form-control','placeholder'=>__('Select User'),'required'=>'required'))}}
                @error('user_id')
                <small class="invalid-user_id" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group mb-3">
                {{Form::label('description',__('Note'),['class'=>'form-label'])}}
                {{Form::textarea('description', null, array('class'=>'form-control','placeholder'=>__('Enter About This Lead'),'required'=>'required','rows'=>'3'))}}
                @error('description')
                <small class="invalid-description" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn btn-primary">
</div>

{{Form::close()}}

