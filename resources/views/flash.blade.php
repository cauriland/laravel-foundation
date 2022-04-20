@if (flash()->message)
    <x-cauri-alert :type="flash()->class" :message="flash()->message" />
@endif
