{{ Form::open(array('url' => 'pipelines')) }}
<div class="modal-body">
    <div class="row">
        <div class="form-group col-md-12 mb-3">
            {{ Form::label('contact_id', __('Contact'),['class'=>'form-label required']) }}
            {!! Form::select('contact_id', $contact, null,array('class' => 'form-control select','required'=>'required')) !!}
            @if (count($contact)<= 0)
            <div class=" text-xs">
                {{ __('Please create user here.') }}
                <a class="text-primary" href="{{ route('contacts.index') }}"><b>{{ __('Create Contact') }}</b></a>
            </div>
            @endif
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary" id="createButton" disabled>{{__('Create')}}</button>
</div>
{{ Form::close() }}
<script src="{{ asset('assets/js/required.js') }}"></script>
