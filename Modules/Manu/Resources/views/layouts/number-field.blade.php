@set('cls','')
@isset($class)
@set('cls',$class)
@endisset
@if($required==1)
{!! Form::number($name,$value, ['class'=>'form-control valid '.$cls,'placeholder'=>$placeholder,'required'=>($required==1)?$required : 'norequired','id'=>$name])!!}
@else
{!! Form::number($name,$value, ['class'=>'form-control valid '.$cls,'placeholder'=>$placeholder,'id'=>$name])!!}
@endif