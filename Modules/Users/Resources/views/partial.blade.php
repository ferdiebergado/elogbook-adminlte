<!-- NAME -->
<div class="row">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{ $user->name ?? old('name') }}"
                required>
            </div>
        </div>
    </div>
</div>
<!-- END NAME -->

<!-- EMAIL -->
<div class="row">
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </span>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $user->email ?? old('email') }}"
                required>
            </div>
        </div>
    </div>
</div>
<!-- END EMAIL -->

<!-- JOB TITLE -->
<div class="row">
    <div id="divJobTitleId" class="form-group {{ $errors->has('jobtitle_id') ?: 'has-error' }}">
        <label for="jobtitle_id" class="col-sm-2 control-label">Job Title</label>
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user-md"></i>
                </span>
                @component('documents::components.select2', ['field' => $user->jobtitle_id, 'name' => 'jobtitle_id', 'rows' => $jobtitles])
                @slot('id') 
                jobtitle_id 
                @endslot 
                @slot('prompt') 
                a Job Title 
                @endslot 
                required 
                @endcomponent
            </div>
            <div id="divHelpJt" class="help-block"></div>
            @if ($errors->has('jobtitle_id'))
            <p class="help-block text-danger">{{ $errors->first('jobtitle_id') }}</p>
            @endif
        </div>
    </div>
</div>
<!-- END JOB TITLE -->

<!-- OFFICE -->
<div class="row">
    <div id="divOfficeId" class="form-group {{ $errors->has('office_id') ?: 'has-error' }}">
        <label for="office_id" class="col-sm-2 control-label">Office</label>
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-building"></i>
                </span>
                @component('documents::components.select2', ['field' => $user->office_id, 'name' => 'office_id', 'rows' => $offices]) @slot('id')
                office_id @endslot @slot('prompt') an office @endslot required @endcomponent
            </div>
            <div id="divHelpOfc" class="help-block"></div>
            @if ($errors->has('office_id'))
            <p class="help-block text-danger">{{ $errors->first('office_id') }}</p>
            @endif
        </div>
    </div>
</div>
<!-- END OFFICE -->

<!-- ACTIVE -->
@can('admin')
<div class="checkbox">
    <label><input type="checkbox" id="active" name="active" value="{{ $user->active ?? old('active') }}">Active</label>
</div>
@endcan
<!-- END ACTIVE -->

@push('scripts')
<script>
    <!-- Simple input validation -->
    $(function () {
        var jt = $('#jobtitle_id');
        var ofc = $('#office_id');
        var divJt = $('#divJobTitleId');
        var divHelpJt = $('#divHelpJt');
        var divHelpOfc = $('#divHelpOfc');
        var divOfc = $('#divOfficeId');
        var toggleError = function (e, ediv, helpdiv) {
            var errClass = 'has-error';
            var sel2 = '.select2-selection--single';
            var cssBorder = '1px solid ';
            var cssError = '#a94442';
            var cssNormal = '#cccccc';
            var helpMsg = "<p class='text-danger'>Please fill up this field.</p>";
            if (e.val() !== '') {
                ediv.removeClass(errClass);
                ediv.find($(sel2)).css('border', cssBorder + cssNormal);
                helpdiv.html('');
            } else {
                ediv.addClass(errClass);
                ediv.find($(sel2)).css('border', cssBorder + cssError);
                helpdiv.html(helpMsg);
            }
        }
        toggleError(jt, divJt, divHelpJt);
        toggleError(ofc, divOfc, divHelpOfc);
        jt.change(function () {
            toggleError(jt, divJt, divHelpJt);
        });
        ofc.change(function () { toggleError(ofc, divOfc, divHelpOfc); });
    });
</script>
@endpush