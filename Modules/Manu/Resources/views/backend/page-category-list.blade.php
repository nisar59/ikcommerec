@if($type=='custom_link')

    {!! Form::text('URL','', ['class'=>'form-control','placeholder'=>'#','id'=>'URL'])!!}
@elseif($type=='page')

    {!! Form::select('values', $options,[], array('class' => 'form-control')) !!}
@elseif($type=='style')
    @include('manu::layouts.select',['name'=>'url','value'=>(isset($isEdit) and $isEdit)?$mitem->style_id:null, 'required'=>true ,'data'=> $options])
@elseif($type=='color')
    @include('admin.snippets.select',['name'=>'url','value'=>(isset($isEdit) and $isEdit)?$mitem->color_id:null, 'required'=>true ,'data'=> $options])
@elseif($type=='size')
    @include('admin.snippets.select',['name'=>'url','value'=>(isset($isEdit) and $isEdit)?$mitem->size_id:null, 'required'=>true ,'data'=> $options])
@elseif($type=='material')
    @include('admin.snippets.select',['name'=>'url','value'=>(isset($isEdit) and $isEdit)?$mitem->material_id:null, 'required'=>true ,'data'=> $options])
@elseif($type=='shape')
    @include('admin.snippets.select',['name'=>'url','value'=>(isset($isEdit) and $isEdit)?$mitem->shape_id:null, 'required'=>true ,'data'=> $options])
@elseif(!is_null($options))

    {!! Form::select('values', $options,[], array('class' => 'form-control')) !!}
@else
    @include('admin.snippets.text-field',['name'=>'url','value'=>(isset($isEdit) and $isEdit)?$mitem->url:'#','required'=>true,'placeholder'=>'Enter URL'])
@endif