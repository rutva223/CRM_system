
{{ Form::model($lead, array('route' => array('leads.update', $lead->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('title',__('Title'),['class'=>'form-label']) }}
                {{Form::text('title',null,array('class'=>'form-control','placeholder'=>__('Enter User Title'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('user_id',__('Assign To'),['class'=>'form-label'])}}
                {{Form::select('user_id', $user, null, array('class'=>'form-control','placeholder'=>__('Select User'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Note'),['class' => 'col-form-label'])}}
                {{Form::textarea('description', null, array('class'=>'form-control','placeholder'=>__('Enter About This Lead'),'required'=>'required','rows'=>'3'))}}
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary">{{__('Save Changes')}}</button>
</div>
{{ Form::close() }}
