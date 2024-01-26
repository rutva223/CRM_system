
{{ Form::model($plan, array('route' => array('plans.update', $plan->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class' => 'col-form-label']) }}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter User Name'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('price',__('Price'),['class' => 'col-form-label']) }}
                {{Form::number('price',null,array('class'=>'form-control','placeholder'=>__('Enter plan price'),'required'=>'required','min'=>1))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('max_user',__('Maximum User'),['class' => 'col-form-label'])}}
                {{Form::number('max_user',null,array('class'=>'form-control','placeholder'=>__('Enter Maximum User'),'required'=>'required'))}}
                <span>-1 for Unlimited</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('duration',__('Plan Duration'),['class' => 'col-form-label'])}}
                <select class="form-control" data-toggle="select" required="required" id="duration" name="duration">
                    <option value="Lifetime" {{ $plan->duration == 'Lifetime' ? 'selected': '' }}>Lifetime</option>
                    <option value="Monthly" {{ $plan->duration == 'Monthly' ? 'selected': '' }}>Per Month</option>
                    <option value="Yearly" {{ $plan->duration == 'Yearly' ? 'selected': '' }}>Per Year</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Description'),['class' => 'col-form-label'])}}
                <textarea class="form-control" rows="4" name="description" cols="50" id="description" placeholder="Enter Description" > {{ $plan->description }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary">{{__('Save Changes')}}</button>
</div>
{{ Form::close() }}
