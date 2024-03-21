{{Form::open(array('url'=>'roles','method'=>'post'))}}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                {{Form::label('name',__('Name'),['class'=>'form-label required'])}}
                {{Form::text('name',null,array('class'=>'form-control','required'=>'required','placeholder'=>__('Enter Role Name')))}}
                @error('name')
                <small class="invalid-name" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </small>
                @enderror
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <h6 class="my-3">{{__('Assign Permission to Roles')}}</h6>
                <table class="table  mb-0" id="dataTable-1">
                    <thead>
                        <tr>
                            <th>
                                <input type="checkbox" class="form-check-input align-middle" name="checkall" id="checkall">
                            </th>
                            <th>{{__('Module')}} </th>
                            <th>{{__('Permissions')}} </th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $modules =['user','roles','plan','leads','contacts','setting'];
                        @endphp
                        @foreach($modules as $module)
                        <tr>
                            <td><input type="checkbox" class="form-check-input align-middle ischeck" data-id="{{str_replace(' ', '', $module)}}"></td>
                            <td><label class="ischeck" data-id="{{str_replace(' ', '', $module)}}">{{ ucfirst($module) }}</label></td>
                            <td>
                                <div class="row">
                                    @if(in_array('manage '.$module,(array) $permissions))
                                    @if($key = array_search('manage '.$module,$permissions))
                                    <div class="col-md-3 custom-control custom-checkbox">
                                        {{Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])}}
                                        {{Form::label('permission'.$key,'Manage',['class'=>'form-check-label'])}}<br>
                                    </div>
                                    @endif
                                    @endif
                                    @if(in_array('create '.$module,(array) $permissions))
                                    @if($key = array_search('create '.$module,$permissions))
                                    <div class="col-md-3 custom-control custom-checkbox">
                                        {{Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])}}
                                        {{Form::label('permission'.$key,'Create',['class'=>'form-check-label'])}}<br>
                                    </div>
                                    @endif
                                    @endif
                                    @if(in_array('edit '.$module,(array) $permissions))
                                    @if($key = array_search('edit '.$module,$permissions))
                                    <div class="col-md-3 custom-control custom-checkbox">
                                        {{Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])}}
                                        {{Form::label('permission'.$key,'Edit',['class'=>'form-check-label'])}}<br>
                                    </div>
                                    @endif
                                    @endif
                                    @if(in_array('delete '.$module,(array) $permissions))
                                    @if($key = array_search('delete '.$module,$permissions))
                                    <div class="col-md-3 custom-control custom-checkbox">
                                        {{Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])}}
                                        {{Form::label('permission'.$key,'Delete',['class'=>'form-check-label'])}}<br>
                                    </div>
                                    @endif
                                    @endif
                                    @if(in_array('show '.$module,(array) $permissions))
                                    @if($key = array_search('show '.$module,$permissions))
                                    <div class="col-md-3 custom-control custom-checkbox">
                                        {{Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])}}
                                        {{Form::label('permission'.$key,'Show',['class'=>'form-check-label'])}}<br>
                                    </div>
                                    @endif
                                    @endif
                                    @if(in_array('manage payment '.$module,(array) $permissions))
                                    @if($key = array_search('manage payment '.$module,$permissions))
                                    <div class="col-md-3 custom-control custom-checkbox">
                                        {{Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])}}
                                        {{Form::label('permission'.$key,'manage payment',['class'=>'form-check-label'])}}<br>
                                    </div>
                                    @endif
                                    @endif
                                    @if(in_array('manage expense '.$module,(array) $permissions))
                                    @if($key = array_search('manage expense '.$module,$permissions))
                                    <div class="col-md-3 custom-control custom-checkbox">
                                        {{Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])}}
                                        {{Form::label('permission'.$key,'manage expense',['class'=>'form-check-label'])}}<br>
                                    </div>
                                    @endif
                                    @endif
                                    @if(in_array('manage company '.$module,(array) $permissions))
                                    @if($key = array_search('manage company '.$module,$permissions))
                                    <div class="col-md-3 custom-control custom-checkbox">
                                        {{Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])}}
                                        {{Form::label('permission'.$key,'Manage company',['class'=>'form-check-label'])}}<br>
                                    </div>
                                    @endif
                                    @endif

                                    @if(in_array('manage business '.$module,(array) $permissions))
                                    @if($key = array_search('manage business '.$module,$permissions))
                                    <div class="col-md-3 custom-control custom-checkbox">
                                        {{Form::checkbox('permissions[]',$key,false, ['class'=>'form-check-input isscheck isscheck_'.str_replace(' ', '', $module),'id' =>'permission'.$key])}}
                                        {{Form::label('permission'.$key,'Manage business',['class'=>'form-check-label'])}}<br>
                                    </div>
                                    @endif
                                    @endif

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal-footer">
    <input type="button" value="{{__('Cancel')}}" class="btn  btn-light" data-bs-dismiss="modal">
    <input type="submit" value="{{__('Create')}}" class="btn  btn-primary" id="createButton" disabled>
</div>
{{Form::close()}}

<script>
    $(document).ready(function() {
        $("#checkall").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
        });
        $(".ischeck").click(function() {
            var ischeck = $(this).data('id');
            $('.isscheck_' + ischeck).prop('checked', this.checked);
        });
    });
    $(document).ready(function() {
        $("#checkall").click(function() {
            $('input:checkbox').not(this).prop('checked', this.checked);
            toggleCreateButton();
        });

        // Function to handle checkbox click event
        $(".ischeck").click(function() {
            var ischeck = $(this).data('id');
            var isChecked = $(this).prop('checked');
            $('.isscheck_' + ischeck).prop('checked', isChecked);
            toggleCreateButton();
        });

        // Function to check if all required fields are filled
        function checkRequiredFields() {
            var allFieldsFilled = true;
            $('.form-control[required]').each(function() {
                if ($(this).val() === '') {
                    allFieldsFilled = false;
                    return false; // Exit the loop early if a required field is empty
                }
            });

            // Check if at least one permission is selected
            var atLeastOnePermissionSelected = $('.isscheck:checked').length > 0;

            return allFieldsFilled && atLeastOnePermissionSelected;
        }

        // Function to enable or disable the Create button based on required field completion
        function toggleCreateButton() {
            var allFieldsFilled = checkRequiredFields();
            $('#createButton').prop('disabled', !allFieldsFilled);
            $('#updateButton').prop('disabled', !allFieldsFilled);
        }

        // Call the toggleCreateButton function when any form field changes
        $('.form-control, .isscheck').on('input', function() {
            toggleCreateButton();
        });

        // Trigger input event on page load to check initial state
        toggleCreateButton();

        // Function to trigger input event after permissions are selected automatically
        function triggerInputEvent() {
            $('.form-control, .isscheck').trigger('input');
        }

        // Trigger input event after permissions are selected automatically
        triggerInputEvent();
    });



</script>
