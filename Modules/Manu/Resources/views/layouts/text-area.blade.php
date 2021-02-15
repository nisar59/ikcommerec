@if($richeditor)
    {!! Form::textarea($name,$value, ['class'=>'form-control valid text-editor '.(isset($content_class) ? $content_class : 'ckeditor'),'placeholder'=>$placeholder])!!}
@else
    {!! Form::textarea($name,$value, ['class'=>'form-control valid','placeholder'=>$placeholder])!!}
@endif