{{-- Better not to use @props as there's too many properties in included components --}}

@php
    // Exact class strings required to prevent purging
    $backdropClass = [
        'sm' => 'sm:hidden',
        'md' => 'md:hidden',
        'lg' => 'lg:hidden',
        'xl' => 'xl:hidden',
    ][$breakpoint ?? 'md'];

    $separatorBreakpointClass = [
        'sm' => 'sm:block',
        'md' => 'md:block',
        'lg' => 'lg:block',
        'xl' => 'xl:block',
    ][$breakpoint ?? 'md'];

    $inverted ??= false;

    $invertedSeparator = match ($inverted) {
        true => 'border-theme-primary-700 inverted:border-theme-secondary-300',
        false => 'border-theme-secondary-300 dark:border-theme-secondary-800',
    };
@endphp

<header
    @if(config('ui.dark-mode.enabled') === true)
        x-data="Navbar.dropdown({
            inverted: @js($inverted ?? false),
            invertOnScroll: @js($invertOnScroll ?? false),
            dark: window.getThemeMode() === 'dark',
        })"
        @theme-changed.window="dark = $event.detail.theme === 'dark'"
    @else
        x-data="Navbar.dropdown({
            inverted: @js($inverted ?? false),
            invertOnScroll: @js($invertOnScroll ?? false),
        })"
    @endif
>
    <div
        x-show="openDropdown !== null || open"
        class="overflow-y-auto fixed inset-0 z-30 opacity-75 bg-theme-secondary-900 {{ $backdropClass }}"
        @click="openDropdown = null; open = false;"
        x-cloak
    ></div>

    {{-- Spacer for the sticky navbar  --}}
    <div class="mb-0.5 h-20"></div>
    <nav
        aria-label="{{ trans('ui::general.primary_navigation') }}"
        x-ref="nav"
        @class([
        	'fixed top-0 z-30 w-full border-b dark:bg-theme-secondary-900 dark:border-theme-secondary-800 transition duration-400',
        	'border-theme-primary-700 bg-theme-primary-600 inverted:bg-white inverted:border-transparent inverted:shadow-header-smooth' => $inverted,
        	'bg-white border-theme-secondary-300' => ! $inverted,
        ])
        dusk="navigation-bar"
    >
        <div class="relative z-10 navbar-container border-theme-secondary-300">
            <div class="flex relative justify-between h-21">
                @include('cauri::navbar.logo')

                @isset($middle)
                    {{ $middle }}
                @endisset

                <div class="flex justify-end items-center h-full">
                    <div class="flex flex-1 justify-end items-center h-full">
                        @isset($desktop)
                            {{ $desktop }}
                        @else
                            @include('cauri::navbar.items.desktop')
                        @endisset
                    </div>

                    @if(! isset($noSeparator))
                        <span @class([
                        	$separatorClasses ?? 'hidden pr-6 border-l ml-7 h-7 transition duration-400',
                        	$invertedSeparator,
                        	$separatorBreakpointClass,
                        ])></span>
                    @endif

                    <div class="flex inset-y-0 right-0 items-center">
                        @if(is_array($navigation))
                            <x-cauri-navbar-hamburger :inverted="$inverted" :breakpoint="$breakpoint ?? 'md'" />
                        @endif

                        @isset($content)
                            {{ $content }}
                        @else
                            @include('cauri::navbar.content')
                        @endisset
                    </div>
                </div>
            </div>
        </div>

        @isset($mobile)
            {{ $mobile }}
        @else
            @include('cauri::navbar.items.mobile')
        @endisset
    </nav>
</header>
