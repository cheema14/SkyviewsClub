@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@section('styles')
<style> 
.spouse_div, .child_div {
    display:none;
}
</style>
@endsection
<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.create') }} {{ trans(tenant()->id.'/cruds.employee.dependent_singular') }}
    </div>
    
    <div class="card-body">
        <form method="POST" action="{{ route("admin.employee.dependents.store", $employee->id) }}" enctype="multipart/form-data">
            @csrf
            <div class="row">
                
                <div class="form-group col-md-4">
                    <label class="required">{{ trans(tenant()->id.'/cruds.employee.dependents.relation') }}</label>
                    <select required class="form-control  {{ $errors->has('relation') ? 'is-invalid' : '' }}" name="relation" id="relation">
                        <option value disabled {{ old('relation', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                        @foreach(App\Models\EmployeeDependent::RELATION_SELECT as $key => $label)
                            @if(
                                ($key !== 'Husband' || $employee->gender !== 'M') && 
                                ($key !== 'Wife' || $employee->gender !== 'F')
                            )
                                <option value="{{ $key }}" {{ old('relation', '') === (string) $key ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @if($errors->has('relation'))
                        <div class="invalid-feedback">
                            {{ $errors->first('relation') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.relation_helper') }}</span>
                </div>
            
                <div class="form-group col-md-4">
                    <label class="required" for="name">{{ trans(tenant()->id.'/cruds.employee.dependents.name') }}</label>
                    <input maxlength="50" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{ $errors->first('name') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.name_helper') }}</span>
                </div>
                
                <div x-data class="form-group col-md-4 spouse_div">
                    <label class="" for="cnic">{{ trans(tenant()->id.'/cruds.employee.dependents.cnic') }}</label>
                    <input  x-mask="99999-9999999-9" class="form-control  {{ $errors->has('cnic') ? 'is-invalid' : '' }}" type="text" name="cnic" id="cnic" value="{{ old('cnic', '') }}">
                    @if($errors->has('cnic'))
                        <div class="invalid-feedback">
                            {{ $errors->first('cnic') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.cnic_helper') }}</span>
                </div>

                <div x-data class="form-group col-md-4 spouse_div">
                    <label class="" for="cell_no">{{ trans(tenant()->id.'/cruds.employee.dependents.cell_no') }}</label>
                    <input x-mask="9999-9999999" class="form-control  {{ $errors->has('cell_no') ? 'is-invalid' : '' }}" type="text" name="cell_no" id="cell_no" value="{{ old('cell_no', '') }}">
                    @if($errors->has('cell_no'))
                        <div class="invalid-feedback">
                            {{ $errors->first('cell_no') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.cell_no_helper') }}</span>
                </div>
                
                

                <div class="form-group col-md-4 spouse_div">
                    <label for="marriage_date">{{ trans(tenant()->id.'/cruds.employee.dependents.marriage_date') }}</label>
                    <input  class="form-control marriage_date {{ $errors->has('marriage_date') ? 'is-invalid' : '' }}" type="text" name="marriage_date" id="marriage_date" value="{{ old('marriage_date') }}">
                    @if($errors->has('marriage_date'))
                        <div class="invalid-feedback">
                            {{ $errors->first('marriage_date') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.marriage_date_helper') }}</span>
                </div>

                <div class="form-group col-md-4 spouse_div">
                    <label class="" for="marriage_place">{{ trans(tenant()->id.'/cruds.employee.dependents.marriage_place') }}</label>
                    <input maxlength="50" class="form-control {{ $errors->has('marriage_place') ? 'is-invalid' : '' }}" type="text" marriage_place="marriage_place" id="marriage_place" value="{{ old('marriage_place', '') }}">
                    @if($errors->has('marriage_place'))
                        <div class="invalid-feedback">
                            {{ $errors->first('marriage_place') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.marriage_place_helper') }}</span>
                </div>

                <div class="form-group col-md-4">
                    <label class="required" for="address">{{ trans(tenant()->id.'/cruds.employee.dependents.address') }}</label>
                    <input maxlength="100" class="form-control  {{ $errors->has('address') ? 'is-invalid' : '' }}" type="text" name="address" id="address" value="{{ old('address', '') }}" maxlength="110">
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.address_helper') }}</span>
                </div>

                <div class="form-group col-md-4 spouse_div">
                    <label class="required" for="nationality">{{ trans(tenant()->id.'/cruds.employee.dependents.nationality') }}</label>
                    <input maxlength="50" class="form-control  {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text" name="nationality" id="nationality" value="{{ old('nationality', '') }}">
                    @if($errors->has('nationality'))
                        <div class="invalid-feedback">
                            {{ $errors->first('nationality') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.nationality_helper') }}</span>
                </div>

                <div class="form-group col-md-4 spouse_div">
                    <label class="required" for="religion">{{ trans(tenant()->id.'/cruds.employee.dependents.religion') }}</label>
                    <select class="form-control  {{ $errors->has('religion') ? 'is-invalid' : '' }}" name="religion" id="religion">
                        <option value disabled {{ old('religion', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                        @foreach(App\Models\EmployeeDependent::RELGION_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('religion', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    {{-- <input class="form-control  {{ $errors->has('religion') ? 'is-invalid' : '' }}" type="text" name="religion" id="religion" value="{{ old('religion', '') }}"> --}}
                    @if($errors->has('religion'))
                        <div class="invalid-feedback">
                            {{ $errors->first('religion') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.religion_helper') }}</span>
                </div>

                <div class="form-group col-md-4 spouse_div">
                    <label class="" for="cast">{{ trans(tenant()->id.'/cruds.employee.dependents.cast') }}</label>
                    <input maxlength="20" class="form-control  {{ $errors->has('cast') ? 'is-invalid' : '' }}" type="text" name="cast" id="cast" value="{{ old('cast', '') }}">
                    @if($errors->has('cast'))
                        <div class="invalid-feedback">
                            {{ $errors->first('cast') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.cast_helper') }}</span>
                </div>

                <div class="form-group col-md-4">
                    <label class="required">{{ trans(tenant()->id.'/cruds.employee.dependents.gender') }}</label>
                    <select class="form-control  {{ $errors->has('gender') ? 'is-invalid' : '' }}" name="gender" id="gender">
                        <option value disabled {{ old('gender', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                        @foreach(App\Models\EmployeeDependent::GENDER_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('gender', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('gender'))
                        <div class="invalid-feedback">
                            {{ $errors->first('gender') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.gender_helper') }}</span>
                </div>

                <div class="form-group col-md-4">
                    <label class="" for="profession">{{ trans(tenant()->id.'/cruds.employee.dependents.profession') }}</label>
                    <input maxlength="50" class="form-control  {{ $errors->has('profession') ? 'is-invalid' : '' }}" type="text" name="profession" id="profession" value="{{ old('profession', '') }}">
                    @if($errors->has('profession'))
                        <div class="invalid-feedback">
                            {{ $errors->first('profession') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.profession_helper') }}</span>
                </div>

                <div class="form-group col-md-4">
                    <label for="date_of_birth">{{ trans(tenant()->id.'/cruds.employee.dependents.date_of_birth') }}</label>
                    <input class="form-control birth_date {{ $errors->has('date_of_birth') ? 'is-invalid' : '' }}" type="text" name="date_of_birth" id="date_of_birth" value="{{ old('date_of_birth') }}">
                    @if($errors->has('date_of_birth'))
                        <div class="invalid-feedback">
                            {{ $errors->first('date_of_birth') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans(tenant()->id.'/cruds.employee.dependents.date_of_birth_helper') }}</span>
                </div>
                

            </div>
            
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans(tenant()->id.'/global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection

@section('scripts')
<script>
    $(document).ready(function(){

    
    var relation  = "<?php echo old('relation');?>";
        
    if (relation == 'Husband' || relation == 'Wife') {
            $('.spouse_div').show();
            $('.child_div').hide();
        } 
        else{
            
            $('.child_div').show();
            $('.spouse_div').hide();
        }
        
    });
    $(document).on('change','#relation',function(){
        
        var value = $(this).val();
        
        // Reset all fields before showing/hiding
        $('.spouse_div input, .spouse_div select').val('');
        $('.child_div input, .child_div select').val('');
        $('#name').val('');
        $('#address').val('');

        if (value == 'Husband' || value == 'Wife') {
            $('.spouse_div').show();
            $('.child_div').hide();
        } 
        else{
            $('.child_div').show();
            $('.spouse_div').hide();
        } 
        
    });

</script>
@endsection
