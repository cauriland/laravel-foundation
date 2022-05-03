@php($url = Request::url())

<div class="flex items-center space-x-2 font-semibold text-theme-secondary-900">
    <div>@lang('ui::actions.docs.share'):</div>

    <x-cauri-social-square
        :url="ShareLink::reddit($url)"
        icon="brands.reddit"
    />

    <x-cauri-social-square
        :url="ShareLink::twitter($url)"
        icon="brands.twitter"
    />

    <x-cauri-social-square
        :url="ShareLink::facebook($url)"
        icon="brands.facebook"
    />
</div>
