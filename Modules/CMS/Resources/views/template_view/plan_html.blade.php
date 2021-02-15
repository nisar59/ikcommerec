<section class="compare_plans">
    <h2>{!! $section->title !!}</h2>
    @if($section->sub_heading)
    <h5>{!! $section->sub_heading !!}</h5>
    @endif
    <hr class="divider">
    @if($section->description)
    {!! $section->description !!}
    @endif
</section>