<div class='input-group'>
    @if($required==1)
    {!! Form::text($name,$value, ['class'=>'form-control','placeholder'=>$placeholder, 'data-date-format'=>'mm/dd/yyyy', 'required'=>($required==1)?$required : 'norequired','id'=>$name])!!}
    @else
    {!! Form::text($name,$value, ['class'=>'form-control','placeholder'=>$placeholder, 'data-date-format'=>'mm/dd/yyyy', 'id'=>$name])!!}
    @endif
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-calendar"></span>
    </span>
</div>