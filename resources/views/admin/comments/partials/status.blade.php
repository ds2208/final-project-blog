@if($comment->index == 1)
<span class="text-success">@lang('enabled')</span>
@else
<span class="text-danger">@lang('disabled')</span>
@endif