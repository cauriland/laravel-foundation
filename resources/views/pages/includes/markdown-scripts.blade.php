@props(['toolbar' => 'basic'])
<script src="{{ mix('js/markdown-editor.js') }}"></script>
<link rel="stylesheet" href="{{ mix('css/markdown-editor.css') }}">

@unless($toolbar === 'basic')
    @include('cauri::inputs.includes.markdown.embed-link-modal')
    @include('cauri::inputs.includes.markdown.embed-tweet-modal')
    @include('cauri::inputs.includes.markdown.embed-podcast-modal')
    @include('cauri::inputs.includes.markdown.link-collection-modal')
    @include('cauri::inputs.includes.markdown.alert-modal')
    @include('cauri::inputs.includes.markdown.page-reference-modal')
    @include('cauri::inputs.includes.markdown.image-modal')
@endunless

@include('cauri::inputs.includes.markdown.link-modal')
