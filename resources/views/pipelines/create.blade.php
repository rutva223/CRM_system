{{ Form::open(array('url' => 'pipelines')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-12">
            {{ Form::label('name', __('Pipeline Name'),['class'=>'col-form-label required']) }}
            {{ Form::text('name', '', array('class' => 'form-control','required'=>'required')) }}
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary" id="createButton" disabled>{{__('Create')}}</button>
</div>
{{ Form::close() }}
<script src="{{ asset('assets/js/required.js') }}"></script>
