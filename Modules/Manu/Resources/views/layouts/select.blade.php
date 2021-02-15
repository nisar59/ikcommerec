@if(!isset($attr))
    {!! Form::select($name, $data, $value) !!}
@else
    {!! Form::select($name, $data, $value, $attr) !!}
@endif