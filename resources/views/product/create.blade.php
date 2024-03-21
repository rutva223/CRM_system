
{{Form::open(array('url'=>'products','method'=>'post', 'enctype' => 'multipart/form-data'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class' => 'col-form-label required']) }}
                {{Form::text('name', null, array('class'=>'form-control','placeholder'=>__('Enter Product Name'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('SKU',__('SKU'),['class' => 'col-form-label required']) }}
                {{Form::text('SKU',null,array('class'=>'form-control','placeholder'=>__('Enter SKU')))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('product_type',__('Product Type'),['class' => 'col-form-label required'])}}
                {{Form::select('product_type', ['Inventory'=>'Inventory','Non-Inventory'=>'Non-Inventory','Service'=>'Service'] ,null, array('class'=>'form-control','required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('unit_price',__('Unit Price'),['class' => 'col-form-label required'])}}
                {{Form::number('unit_price',null, array('class'=>'form-control','placeholder'=>__('Enter Unit Price'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{Form::label('unit_cost',__('Unit Cost'),['class' => 'col-form-label required'])}}
                {{Form::number('unit_cost',null,array('class'=>'form-control','placeholder'=>__('Enter Unit Cost'),'required'=>'required'))}}
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                {{ Form::label('image', __('Image'), ['class' => 'col-form-label']) }}
                <input type="file" name="image" id="user_profile" class="form-control">
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
