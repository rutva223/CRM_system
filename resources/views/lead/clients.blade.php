
{{ Form::model($lead, array('route' => array('LeadContactUpdate', $lead->id), 'method' => 'PUT')) }}
<div class="modal-body">
    <div class="row">
        <div class="col-12 form-group">
            {{ Form::label('clients', __('Clients'),['class'=>'col-form-label required']) }}
            <select name="clients" id="clients" class="form-control" required>
                <option value="">Select Contact Clients</option>
                @foreach ($clients as $key=>$data)
                    <option value="{{ $key }}">{{ $data }}</option>
                @endforeach
            </select>
            <p class="text-danger d-none" id="clients_validation">{{__('Clients filed is required.')}}</p>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{__('Close')}}</button>
    <button type="submit" class="btn  btn-primary" id="submit">{{__('Save')}}</button>
</div>

{{ Form::close() }}

<script>
    // $(function(){
    //     $("#submit").click(function() {
    //         var client =  $("#choices-multiple option:selected").length;
    //         if(client == 0){
    //         $('#clients_validation').removeClass('d-none')
    //             return false;
    //         }else{
    //         $('#clients_validation').addClass('d-none')
    //         }
    //     });
    // });
</script>
