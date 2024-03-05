
{{ Form::open(array('route' => ['emailStore',$deal->id])) }}
    <div class="modal-body">
        <div class="row">
            <div class="col-6 form-group">
                {{ Form::label('to', __('Mail To'),['class'=>'col-form-label required']) }}
                {{ Form::email('to', null, array('class' => 'form-control','required'=>'required')) }}
            </div>
            <div class="col-6 form-group">
                {{ Form::label('subject', __('Subject'),['class'=>'col-form-label required']) }}
                {{ Form::text('subject', null, array('class' => 'form-control','required'=>'required')) }}
            </div>
            <div class="col-12 form-group">
                {{ Form::label('description', __('Description'),['class'=>'col-form-label']) }}
                {{ Form::textarea('description',null, array('class' => 'form-control')) }}
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
        <button type="submit" class="btn  btn-primary" id="createButton" disabled>{{__('Create')}}</button>
    </div>
{{ Form::close() }}

<script src="{{ asset('assets/js/required.js') }}"></script>
