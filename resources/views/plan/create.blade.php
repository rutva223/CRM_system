
{{Form::open(array('url'=>'plans','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class' => 'col-form-label required']) }}
                {{Form::text('name',null,array('class'=>'form-control','placeholder'=>__('Enter Plan Name'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('price',__('Price'),['class' => 'col-form-label required']) }}
                {{Form::number('price',null,array('class'=>'form-control','min'=>1,'placeholder'=>__('Enter plan price'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('max_user',__('Maximum User'),['class' => 'col-form-label required'])}}
                {{Form::number('max_user',null,array('class'=>'form-control','placeholder'=>__('Enter Maximum User'),'required'=>'required'))}}
                <span>-1 for Unlimited</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('max_customer',__('Maximum Customer'),['class' => 'col-form-label required'])}}
                {{Form::number('max_customer',null,array('class'=>'form-control','placeholder'=>__('Enter Maximum Customer'),'required'=>'required'))}}
                <span>-1 for Unlimited</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('max_vendor',__('Maximum Vendor'),['class' => 'col-form-label required'])}}
                {{Form::number('max_vendor',null,array('class'=>'form-control','placeholder'=>__('Enter Maximum Vendor'),'required'=>'required'))}}
                <span>-1 for Unlimited</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('duration',__('Plan Duration'),['class' => 'col-form-label required'])}}
                <select class="form-control" data-toggle="select" required="required" id="duration" name="duration">
                    <option value="Lifetime">Lifetime</option>
                    <option value="Monthly">Per Month</option>
                    <option value="Yearly">Per Year</option>
                </select>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('description',__('Description'),['class' => 'col-form-label'])}}
                <textarea class="form-control" rows="4" name="description" cols="50" id="description" placeholder="Enter Description"></textarea>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary" id="createButton" disabled>{{__('Create')}}</button>
</div>
{{ Form::close() }}
<script src="{{ asset('assets/js/required.js') }}"></script>
