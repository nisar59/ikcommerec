@if($required==1)
{!! Form::text($name,$value, ['class'=>(isset($class))?'form-control '.$class:'form-control','placeholder'=>$placeholder ,'id'=>$name])!!}
@else
{!! Form::text($name,$value, ['class'=>'form-control','placeholder'=>$placeholder,'id'=>$name])!!}
@endif