@if($errors->has($fieldName))
<div class="invalid-feedback">
    @foreach($errors->get($fieldName) as $error)
    <div>{{$error}}</div>
    @endforeach
</div>
@endif