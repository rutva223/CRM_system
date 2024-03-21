
@if(isset($meeting))
{{ Form::model($meeting, array('route' => array('leadmeetingUpdate', $lead->id, $meeting->id), 'method' => 'PUT')) }}
@else
{{ Form::open(array('route' => ['leadmeetingStore',$lead->id])) }}
@endif
<div class="modal-body">
    <div class="row">
        <div class="col-6 form-group">
            {{ Form::label('subject', __('Subject'),['class'=>'col-form-label required']) }}
            {{ Form::text('subject', null, array('class' => 'form-control','required'=>'required')) }}
        </div>
        <div class="col-6 form-group">
            {{ Form::label('status', __('Status'),['class'=>'col-form-label required']) }}
            <select name="status" id="status" class="form-control" required>
             @foreach ($status as $key=>$data)
                <option value="{{$key}}">{{ $data }}</option>
             @endforeach
            </select>
        </div>
        <div class="col-12 form-group">
            {{ Form::label('duration', __('Duration'),['class'=>'col-form-label required']) }}
            <input type="datetime-local" name="duration" id="duration" class="form-control" placeholder={{ date('d/m/y') }} required>
        </div>
        <div class="col-12 form-group">
            {{ Form::label('user_id', __('Assignee'),['class'=>'col-form-label required']) }}
            <select name="user_id" id="user_id" class="form-control" required>
                @foreach($users as $user)
                    <option value="{{ $user->getLeadUser->id }}" @if(isset($meeting->user_id) && $meeting->user_id == $user->getLeadUser->id) selected @endif>{{ $user->getLeadUser->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 form-group">
            {{ Form::label('description', __('Description'),['class'=>'col-form-label']) }}
            {{ Form::textarea('description', null, array('class' => 'form-control')) }}
        </div>
    </div>
</div>
<div class="modal-footer">
<button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
 @if(isset($meeting))
     <button type="submit" class="btn  btn-primary" id="updateButton">{{__('Edit')}}</button>
 @else
    <button type="submit" class="btn  btn-primary"  id="createButton" disabled>{{__('Create')}}</button>
 @endif
</div>

{{ Form::close() }}
<script src="{{ asset('assets/js/required.js') }}"></script>
