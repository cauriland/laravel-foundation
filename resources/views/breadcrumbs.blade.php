<div class="flex justify-center w-full h-16 dark:bg-black bg-theme-secondary-100">
    <div class="flex justify-start items-center px-8 mx-auto w-full max-w-7xl h-full text-sm leading-relaxed text-theme-secondary-500">
        @foreach ($crumbs as $crumb)
            @isset($crumb['route'])
                <span>
                    <a
                        class="flex items-center font-semibold hover:underline transition-default @if($loop->last) text-theme-secondary-700 @endif"
                        href="{{ route($crumb['route'], empty($crumb['params']) ? [] : $crumb['params']) }}"
                    >
                        @if($loop->first && count($crumbs) > 1)
                            <x-cauri-icon name="arrows.arrow-left" size="xs" class="inline-block my-auto mr-3" />
                        @endif

                        <span>{{ $crumb['label'] }}</span>
                    </a>
                </span>
            @else
                <span class="font-semibold truncate @if($loop->last) text-theme-secondary-700 @endif">{{ $crumb['label'] }}</span>
            @endisset

            @if(!$loop->last)
                <span class="mx-3"> | </span>
            @endif
        @endforeach
    </div>
</div>
