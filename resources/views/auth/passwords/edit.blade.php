@extends('layouts.'.tenant()->id.'.admin')
@section('content')
@section('styles')
<style>
    .help-indicators-area{
        width:50%;
        float:left;
        line-height: 20px;
    }
    .grey-text{
        color: #6F777F;
        /* font-size: 12px; */
    }
    
    .green-text{
        color: #26ae61;
        /* font-size: 12px; */
    }

</style>
@endsection
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                {{ trans(tenant()->id.'/global.my_profile') }}
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route("profile.password.updateProfile") }}">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="name">{{ trans(tenant()->id.'/cruds.user.fields.name') }}</label>
                        <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                        @if($errors->has('name'))
                            <div class="invalid-feedback">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="title">{{ trans(tenant()->id.'/cruds.user.fields.email') }}</label>
                        <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="text" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans(tenant()->id.'/global.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                {{ trans(tenant()->id.'/global.change_password') }}
            </div>

            <div class="card-body">
                <form method="POST" name="set_password" id="set_password" action="{{ route("profile.password.update") }}">
                    @csrf
                    <div class="form-group">
                        <label class="required" for="title">New {{ trans(tenant()->id.'/cruds.user.fields.password') }}</label>
                        <input class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" type="password" name="password" id="password" required>
                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="required" for="title">Repeat New {{ trans(tenant()->id.'/cruds.user.fields.password') }}</label>
                        <input class="form-control" type="password" name="password_confirmation" id="password_confirmation" required>
                    </div>

                    <div class="help-indicators-area min_eigth">
                        <i class="form-control-feedback bv-no-label fa fa-check-circle grey-text min_eigth" style=""></i>
                        <small class="help-block help-indicator-text grey-text min_eigth" style="">8 characters minimum</small>
                    </div>

                    <div class="help-indicators-area one_special">
                        <i class="form-control-feedback bv-no-label fa fa-check-circle grey-text one_special" style=""></i>
                        <small class="help-block help-indicator-text grey-text one_special" style="">One Special Character.</small>
                    </div>

                    <div class="help-indicators-area one_lower">
                        <i class="form-control-feedback bv-no-label fa fa-check-circle grey-text one_lower" style=""></i>
                        <small class="help-block help-indicator-text grey-text one_lower" style="">One lower case Character.</small>
                    </div>

                    <div class="help-indicators-area one_upper">
                        <i class="form-control-feedback bv-no-label fa fa-check-circle grey-text one_upper" style=""></i>
                        <small class="help-block help-indicator-text grey-text one_upper" style="">One Upper case Character.</small>
                    </div>

                    <div class="help-indicators-area one_number">
                        <i class="form-control-feedback bv-no-label fa fa-check-circle grey-text one_number" style=""></i>
                        <small class="help-block help-indicator-text grey-text one_number" style="">One number.</small>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-danger" type="submit">
                            {{ trans(tenant()->id.'/global.save') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@if (auth()->user()->name == 'Super Admin')
    
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    {{ trans(tenant()->id.'/global.delete_account') }}
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route("profile.password.destroyProfile") }}" onsubmit="return prompt('{{ __('global.delete_account_warning') }}') == '{{ auth()->user()->email }}'">
                        @csrf
                        <div class="form-group">
                            <button class="btn btn-danger" type="submit">
                                {{ trans(tenant()->id.'/global.delete') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endif

@section('scripts')

<script type="text/javascript">



    $("#password").keyup(function(evt) {
      
      var value_field = $(this).val();
    
      var upperCase= new RegExp('[A-Z]');
      
      var matches_number = value_field.match(/\d+/g);
      var matches_lower = value_field.match(/[a-z]/);
      var matches_upper = value_field.match(/[A-Z]/);
      // var matches_upper = return (/[A-Z]/.test(value_field));
      
      
      if(matches_number){
        $(".one_number").removeClass("grey-text");
        $(".one_number").removeClass("grey-text");
    
        $(".one_number").addClass("green-text");
        $(".one_number").addClass("green-text");
      }
      else{
        $(".one_number").removeClass("green-text");
        $(".one_number").removeClass("green-text");
      }
      
      if(matches_lower){
        $(".one_lower").removeClass("grey-text");
        $(".one_lower").removeClass("grey-text");
    
        $(".one_lower").addClass("green-text");
        $(".one_lower").addClass("green-text");
      }
      else{
        $(".one_lower").removeClass("green-text");
        $(".one_lower").removeClass("green-text");
      }
    
      if(matches_upper){
        $(".one_upper").removeClass("grey-text");
        $(".one_upper").removeClass("grey-text");
    
        $(".one_upper").addClass("green-text");
        $(".one_upper").addClass("green-text");
      }
      else{
        $(".one_upper").removeClass("green-text");
        $(".one_upper").removeClass("green-text");
      }
    
        if (/^[a-zA-Z0-9- ]*$/.test(value_field) == false) {
          $(".one_special").removeClass("grey-text");
          $(".one_special").removeClass("grey-text");
    
          $(".one_special").addClass("green-text");
          $(".one_special").addClass("green-text");
        }
        else{
          $(".one_special").removeClass("green-text");
          $(".one_special").removeClass("green-text");
        }
    
        if(value_field.length < 8){
          $(".min_eigth").removeClass("green-text");
          $(".min_eigth").removeClass("green-text");
        }
        else{
          $(".min_eigth").removeClass("grey-text");
          $(".min_eigth").removeClass("grey-text");
    
          $(".min_eigth").addClass("green-text");
          $(".min_eigth").addClass("green-text");
        }
    
    
    });
    
</script>

<script type="text/javascript">

$('#set_password').bootstrapValidator({
			excluded: [':disabled',':hidden',':not(:visible)'],
			live: 'enabled',
			/*
			feedbackIcons: {
				valid: 'fa fa-check-circle text-success',
				invalid: 'fa fa-times-circle',
				validating: 'fa fa-refresh'
			},
			*/
			submitbuttons:'button[type="submit"]',
                fields: {
					'password':{
                            trigger: 'blur',
                            validators: {
                                    notEmpty: {
                                        message: 'Password field is required.'
                                    },
                                    regexp: {
                                        regexp: /^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/,
                                        message: 'Invalid format for Password.'
                                    },
                                    stringLength: {
                                        min:8,
                                        message: 'Password must be more than 7 characters'
                                    },
                                }
                    },
                    'password_confirmation': {
                        validators: {
                                        notEmpty: {
                                            message: 'Password field is required.'
                                        },
                                        identical: {
                                            field: 'password',
                                            message: 'The password and its confirmation do not match.'
                                        }
                                    }
                    },				
                }
        })
	    .on('success.field.bv', function(e, data) {
        

        var $parent = data.element.parents('.form-group');
        
        $parent.removeClass('has-success');
        
      })
	    .on('error.validator.bv', function(e, data) {
            

            data.element
                .data('bv.messages')
                
                .find('.help-block[data-bv-for="' + data.field + '"]').hide()
                
                .filter('[data-bv-validator="' + data.validator + '"]').show();
       }).on('success.form.bv', function(e) {
			is_valid = true;
	   }).on('error.form.bv', function(e) {
	   });


</script>

@endsection

@endsection