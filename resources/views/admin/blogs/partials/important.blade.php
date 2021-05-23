@if($blog->important == 1)
<span class="text-success">@lang('On Index')</span>
@else
<span class="text-danger">@lang('No on index')</span>
@endif