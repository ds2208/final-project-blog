@if(Auth::user()->id != $user->id)
<div class="btn-group">
    <a href="{{$user->getFrontUrl()}}" class="btn btn-info" target="_blank">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{route('admin.users.edit', ['user' => $user->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    @if($user->isEnabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#disable-modal"
        data-action="disable"
        data-id="{{$user->id}}"
        data-name="{{$user->name}}"
        >
        <i class="fas fa-times-circle"></i>
    </button>
    @endif
    @if($user->isDisabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#enable-modal"
        data-action="enable"
        data-id="{{$user->id}}"
        data-name="{{$user->name}}"
        >
        <i class="fas fa-check-circle"></i>
    </button>
    @endif
</div>
@else
<span>{{__("This is You")}}</span>
<a href="{{Auth::user()->getFrontUrl()}}" class="btn btn-info" target="_blank">
    <i class="fas fa-eye"></i>
</a>
@endif