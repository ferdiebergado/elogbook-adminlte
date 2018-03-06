<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
    <img src="{{ $avatar }}" class="user-image" alt="User Image">
    <span class="hidden-xs">{{ auth()->user()->name }}</span>
  </a>
  <ul class="dropdown-menu">
    <!-- User image -->
    <li class="user-header">
      <img src="{{ $avatar }}" class="img-circle" alt="User Image">
      <p>
        {{ auth()->user()->name }}
        <small>Member since {{ auth()->user()->created_at->toFormattedDateString() }}</small>
      </p>
    </li>
    <!-- Menu Footer-->
    <li class="user-footer">
      <div class="pull-left">
        <a href="{{ route('users.show', auth()->user()->id) }}" class="btn btn-default btn-flat"><i class="fa fa-user"></i> Profile</a>
      </div>
      <div class="pull-right">
        <a id="logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
      </div>
    </li>
  </ul>
</li>
