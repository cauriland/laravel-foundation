<div>
    @if($message)
        <x-cauri-alert :type="$this->alertType()">
            {!! $message !!}
        </x-cauri-alert>
    @endif
</div>
