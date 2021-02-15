@if($required==1)
{!! Form::password($name, ['class'=>'form-control valid','placeholder'=>$placeholder,'required'=>($required==1)?$required : 'norequired','id'=>$name])!!}
@else
{!! Form::password($name, ['class'=>'form-control valid','placeholder'=>$placeholder,'id'=>$name])!!}
@endif