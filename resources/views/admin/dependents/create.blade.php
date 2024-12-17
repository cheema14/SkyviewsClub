@extends('layouts.'.tenant()->id.'.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans(tenant()->id.'/global.create') }} {{ trans(tenant()->id.'/cruds.dependent.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.dependents.store", $member->id) }}" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="required" for="name">{{ trans(tenant()->id.'/cruds.dependent.fields.name') }}</label>
                <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.dependent.fields.name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="dob">{{ trans(tenant()->id.'/cruds.dependent.fields.dob') }}</label>
                <input class="form-control date {{ $errors->has('dob') ? 'is-invalid' : '' }}" type="text" name="dob" id="dob" value="{{ old('dob') }}">
                @if($errors->has('dob'))
                    <div class="invalid-feedback">
                        {{ $errors->first('dob') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.dependent.fields.dob_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans(tenant()->id.'/cruds.dependent.fields.relation') }}</label>
                <select class="form-control {{ $errors->has('relation') ? 'is-invalid' : '' }}" name="relation" id="relation" required>
                    <option value disabled {{ old('relation', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Dependent::RELATION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('relation', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('relation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('relation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.dependent.fields.relation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="occupation">{{ trans(tenant()->id.'/cruds.dependent.fields.occupation') }}</label>
                <input class="form-control {{ $errors->has('occupation') ? 'is-invalid' : '' }}" type="text" name="occupation" id="occupation" value="{{ old('occupation', '') }}">
                @if($errors->has('occupation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('occupation') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.dependent.fields.occupation_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="nationality">{{ trans(tenant()->id.'/cruds.dependent.fields.nationality') }}</label>
                <input class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text" name="nationality" id="nationality" value="{{ old('nationality', '') }}">
                @if($errors->has('nationality'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nationality') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.dependent.fields.nationality_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="golf_hcap">{{ trans(tenant()->id.'/cruds.dependent.fields.golf_hcap') }}</label>
                <input class="form-control {{ $errors->has('golf_hcap') ? 'is-invalid' : '' }}" type="text" name="golf_hcap" id="golf_hcap" value="{{ old('golf_hcap', '') }}">
                @if($errors->has('golf_hcap'))
                    <div class="invalid-feedback">
                        {{ $errors->first('golf_hcap') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.dependent.fields.golf_hcap_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans(tenant()->id.'/cruds.dependent.fields.allow_credit') }}</label>
                <select class="form-control {{ $errors->has('allow_credit') ? 'is-invalid' : '' }}" name="allow_credit" id="allow_credit" required>
                    <option value disabled {{ old('allow_credit', null) === null ? 'selected' : '' }}>{{ trans(tenant()->id.'/global.pleaseSelect') }}</option>
                    @foreach(App\Models\Dependent::ALLOW_CREDIT_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('allow_credit', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('allow_credit'))
                    <div class="invalid-feedback">
                        {{ $errors->first('allow_credit') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.dependent.fields.allow_credit_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="photo">{{ trans(tenant()->id.'/cruds.dependent.fields.photo') }}</label>
                <div class="needsclick dropzone {{ $errors->has('photo') ? 'is-invalid' : '' }}" id="photo-dropzone">
                </div>
                @if($errors->has('photo'))
                    <div class="invalid-feedback">
                        {{ $errors->first('photo') }}
                    </div>
                @endif
                <span class="help-block">{{ trans(tenant()->id.'/cruds.dependent.fields.photo_helper') }}</span>
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
    Dropzone.options.photoDropzone = {
    url: '{{ route('admin.dependents.storeMedia') }}',
    maxFilesize: 2, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 2,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="photo"]').remove()
      $('form').append('<input type="hidden" name="photo" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="photo"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($dependent) && $dependent->photo)
      var file = {!! json_encode($dependent->photo) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="photo" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
@endsection
