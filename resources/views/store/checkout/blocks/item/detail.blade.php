@if($item->product->pattern)
    {{ 'Pattern: '.$item->product->pattern->name }},
@endif
@if($item->product->pile)
    {{ 'Pile: '.$item->product->pile->name }},
@endif
@if($item->product->material_id)
    {{ 'Warp: '.($item->product->material ? $item->product->material->name : "-") }},
@endif
@if($item->product->knot)
    {{ 'Knot: '.($item->product->knot ? $item->product->knot->name : "-") }},
@endif
@if($item->product->kpsi)
    {{ 'KPSI: '.$item->product->kpsi }},
@endif
@if($item->product->type)
    {{ 'Type: '.($item->product->type ? $item->product->type->name : "-") }}
@endif