@if ($type === 'success')
    <div class="flex flex-shrink-0 justify-center items-center w-5 h-5 rounded-full bg-theme-success-200">
        <x-cauri-icon name="check-mark-small" size="2xs" class="text-theme-success-500" />
    </div>
@elseif ($type === 'failed' || $type === 'error')
    <div class="flex flex-shrink-0 justify-center items-center w-5 h-5 rounded-full bg-theme-danger-100">
        <x-cauri-icon name="cross" size="2xs" class="text-theme-danger-500" />
    </div>
@elseif ($type === 'running')
    <div class="flex flex-shrink-0 justify-center items-center w-5 h-5 rounded-full bg-theme-warning-100">
        <x-cauri-icon name="arrows.arrows-rotate" size="xs" class="text-theme-warning-900 animation-spin" />
    </div>
@elseif ($type === 'updated')
    <div class="flex flex-shrink-0 justify-center items-center w-5 h-5 rounded-full bg-theme-warning-100">
        <x-cauri-icon name="arrows.arrows-rotate" size="xs" class="text-theme-warning-900" />
    </div>
@elseif ($type === 'active')
    <div class="flex flex-shrink-0 justify-center items-center rounded-full border-2 w-4.5 h-4.5 box-border border-theme-primary-500"></div>
@elseif ($type === 'locked')
    <div class="flex flex-shrink-0 justify-center items-center w-5 h-5 rounded-full bg-theme-secondary-300">
        <x-cauri-icon name="lock" size="xs" class="text-theme-secondary-700" />
    </div>
@else
    <div class="flex flex-shrink-0 justify-center items-center w-5 h-5 rounded-full bg-theme-secondary-300"></div>
@endif
