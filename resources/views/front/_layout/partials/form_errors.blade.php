@if($errors->has($fieldName))
<div class="alert alert-danger text-danger">
    @foreach($errors->get($fieldName) as $error)
    <div>{{$error}}</div>
    @endforeach
</div>
@endif