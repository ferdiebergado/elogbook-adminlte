<div class="row">
    <div class="form-group">
        <label for="name" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user"></i>
                </span>
                <input type="text" class="form-control" id="name" name="name" placeholder="Name" value="{{  isset($user->name) ? $user->name : old('name') }}"
                    required>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label for="email" class="col-sm-2 control-label">Email</label>
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-envelope"></i>
                </span>
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ isset($user->email) ? $user->email : old('email') }}"
                    required>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="form-group">
        <label for="jobtitle_id" class="col-sm-2 control-label">Job Title</label>
        <div class="col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-user-md"></i>
                </span>
                @component('documents::components.select2', ['field' => $user->jobtitle_id, 'name' => 'jobtitle_id', 'rows' => $jobtitles])
                @slot('id') jobtitle_id @endslot @slot('prompt') a Job Title @endslot required @endcomponent
            </div>
        </div>
    </div>
</div>
<!-- OFFICE -->
<div class="row">
    <div class="form-group">
        <label for="office_id" class="col-sm-2 control-label">Office</label>
        {{--
        <div class="col-xs-10 col-sm-10 col-md-6 col-lg-6"> --}}
            <div class="col-sm-6">
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="fa fa-building"></i>
                    </span>
                    @component('documents::components.select2', ['field' => $user->office_id, 'name' => 'office_id', 'rows' => $offices]) @slot('id')
                    office_id @endslot @slot('prompt') an office @endslot required @endcomponent
                </div>
            </div>
        </div>
    </div>
    <!-- END OFFICE -->