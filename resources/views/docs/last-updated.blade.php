@props([
    'time',
    'class' => null,
])

<div @class([
    'text-sm flex space-x-2 items-center text-theme-secondary-500 font-semibold',
    $class,
])>
    <x-cauri-icon name="clock" size="sm" />
    <span>@lang('ui::general.last_updated', ['time' => \Carbon\Carbon::parse($time)->diffForHumans()])</span>
</div>
