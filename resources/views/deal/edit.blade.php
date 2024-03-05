{{ Form::model($deal, ['route' => ['deals.update', $deal->id], 'method' => 'PUT']) }}
<div class="modal-body">
    <div class="tab-content tab-bordered">
        <div class="tab-pane fade show active" id="tab-1" role="tabpanel">
            <div class="row">
                <div class="col-12 form-group">
                    {{ Form::label('name', __('Deal Name'), ['class' => 'col-form-label required']) }}
                    {{ Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
                <div class="col-12 form-group">
                    {{ Form::label('pipeline_id', __('Pipeline'), ['class' => 'col-form-label required']) }}
                    {{ Form::select('pipeline_id', $pipelines, null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
                <div class="col-12 form-group">
                    {{ Form::label('amount', __('Amount'), ['class' => 'col-form-label required']) }}
                    {{ Form::number('amount', null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
                <div class="col-12 form-group">
                    {{ Form::label('stage_id', __('Stage'), ['class' => 'col-form-label required']) }}
                    {{ Form::select('stage_id', ['' => __('Select Stage')], null, ['class' => 'form-control', 'required' => 'required']) }}
                </div>
                <div class="form-group col-md-12 ">
                    {{ Form::label('priority', __('Priority'),['class'=>'col-form-label required']) }}
                    <select name="priority" id="priority" class="form-control select" required>
                        <option value="">Select Deal Stage</option>
                        @foreach ($priority as $id=>$name)
                            <option value="{{ $id }}" {{ $name == $deal->priority ? 'selected': '' }}>{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-12 form-group">
                    {{ Form::label('notes', __('Notes'), ['class' => 'col-form-label']) }}
                    {{ Form::textarea('notes', null, ['class' => 'form-control','rows'=>"7"]) }}
                </div>
            </div>
        </div>

    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn  btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
    <button type="submit" class="btn  btn-primary" id="updateButton">{{ __('Update') }}</button>
</div>

{{ Form::close() }}

<script src="{{ asset('assets/js/required.js') }}"></script>
<script>
    var stage_id = '{{ $deal->stage_id }}';

    $(document).ready(function() {
        $("#commonModal select[name=pipeline_id]").trigger('change');
    });
    $(document).on("change", "#commonModal select[name=pipeline_id]", function() {
        $.ajax({
            url: '{{ route('stages.json') }}',
            data: {
                pipeline_id: $(this).val(),
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            success: function(data) {
                $('#stage_id').empty();
                $("#stage_id").append(
                    '<option value="" selected="selected">{{ __('Select Stage') }}</option>');
                $.each(data, function(key, data) {
                    var select = '';
                    if (key == '{{ $deal->stage_id }}') {
                        select = 'selected';
                    }
                    $("#stage_id").append('<option value="' + key + '" ' + select + '>' +
                        data + '</option>');
                });
                $("#stage_id").val(stage_id);

            }
        })
    });

</script>
