@props(['c', 'style' => '', 'image' => null])
@if ($image)
<div class="rug" style="background:url('{{ $image }}') center/cover no-repeat;box-shadow:none;{{ $style }}"></div>
@else
<div class="rug" style="--c1:{{ $c[0] }};--c2:{{ $c[1] }};--c3:{{ $c[2] }};{{ $style }}"></div>
@endif
