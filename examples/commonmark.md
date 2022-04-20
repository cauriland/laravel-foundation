# Simple Examples

This file contains basic examples and explains the parameters that can be used for the components.

---

## Inputs

### Input

`<x-cauri-input type="email" name="my-input" :label="trans('forms.email_address')" :value="old('email')" :errors="$errors" />`

| Parameter   | Description                                                                      | Required |
| ----------- | -------------------------------------------------------------------------------- | -------- |
| name        | input name, will also be used as `id` if none specified                          | yes      |
| errors      | laravel error bag                                                                | yes      |
| label       | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| type        | input type, can be the general HTML types. Defaults to `text`                    | no       |
| placeholder | placeholder value                                                                | no       |
| value       | default value to show, can be used with laravel's `old('value')` functionality   | no       |
| model       | livewire model to attach to                                                      | no       |
| id          | id of the input, by default `name` is used                                       | no       |

### Textarea

`<x-cauri-textarea name="my-textarea" :errors="$errors" />`

| Parameter | Description                                                                      | Required |
| --------- | -------------------------------------------------------------------------------- | -------- |
| name      | input name, will also be used as `id` if none specified                          | yes      |
| errors    | laravel error bag                                                                | yes      |
| label     | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| model     | livewire model to attach to                                                      | no       |
| rows      | amount of rows to show, defaults to 10                                           | no       |
| readonly  | whether the input is readonly or not                                             | no       |
| id        | id of the input, by default `name` is used                                       | no       |

### Checkbox

`<x-cauri-checkbox name="my-checkbox" />`

| Parameter | Description                                                                      | Required |
| --------- | -------------------------------------------------------------------------------- | -------- |
| name      | input name, will also be used as `id` if none specified                          | yes      |
| label     | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| model     | livewire model to attach to                                                      | no       |
| checked   | whether the input is checked or not                                              | no       |
| disabled  | whether the input is disabled or not                                             | no       |
| id        | id of the input, by default `name` is used                                       | no       |

### Radio Button

`<x-cauri-radio name="my-radio-button" />`

| Parameter | Description                                                                      | Required |
| --------- | -------------------------------------------------------------------------------- | -------- |
| name      | input name, will also be used as `id` if none specified                          | yes      |
| label     | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| model     | livewire model to attach to                                                      | no       |
| checked   | whether the input is checked or not                                              | no       |
| disabled  | whether the input is disabled or not                                             | no       |
| id        | id of the input, by default `name` is used                                       | no       |

### Toggle

`<x-cauri-toggle name="my-toggle" :errors="$errors" />`

| Parameter | Description                                                                      | Required |
| --------- | -------------------------------------------------------------------------------- | -------- |
| name      | input name, will also be used as `id` if none specified                          | yes      |
| label     | label to be shown for the input, will use `trans(form.<name>)` if none specified | no       |
| model     | livewire model to attach to                                                      | no       |
| default   | default toggle position, defaults to `false` = unchecked                         | no       |

---

## Navigation

### Navbar

`<x-cauri-navbar title="Deployer" :navigation="[['route' => 'tokens', 'label' => trans('menus.dashboard')]]" />`

| Parameter  | Description                                                          | Required |
| ---------- | -------------------------------------------------------------------- | -------- |
| title      | used for the "CAURI <title>" navbar text                               | yes      |
| navigation | an array of `route`, `label` pairs for the navbar navigation options | yes      |

### Breadcrumbs

> Note: this works best when using a breadcrumb section in your layout view to which you pass the breadcrumb itself on different pages

```php
<x-cauri-breadcrumbs :crumbs="[
    ['route' => 'tokens', 'label' => trans('menus.dashboard')],
    ['route' => 'tokens.welcome', 'label' => trans('menus.onboarding'), 'params' => [$token]],
    ['route' => 'tokens.identity', 'label' => trans('menus.tokens.identity'), 'params' => [$token]],
]" />
```

### Sidebar Links

> Sidebar links that automatically change class when they correspond to the active route

`<x-cauri-sidebar-link :name="trans('menus.tokens.networks')" route="tokens.show" :params="[$token]" />`

---

## Misc Components

### Alerts

> Note: Requires various icons to be present to properly work. Relies on [Blade SVG](https://github.com/adamwathan/blade-svg) to load them.

Simple inline usage with a string message (if not specified, it sets `type="info"` by default):

`<x-cauri-alert message="your-message-here" />`

Additionally, you can use it as a block and set the content:

```php
<x-cauri-alert type="info">
    {!! trans('tokens.networks.no_source_provider_alert', ['route' => route('tokens.source-providers', $selectedToken)]) !!}
</x-cauri-alert>
```

You can also get a dismissible alert by specifying `dismissible`, this flag adds a closing button at the end of the title:

```php
<x-cauri-alert type="info" dismissible>
    {!! trans('tokens.networks.no_source_provider_alert', ['route' => route('tokens.source-providers', $selectedToken)]) !!}
</x-cauri-alert>
```

### Accordion

```php
<x-cauri-accordion-group slots="2">
    @slot('title_1')
        <p>Title for slot 1</p>
    @endslot
    @slot('slot_1')
        <p>Content for slot 1</p>
    @endslot

    @slot('title_2')
        <p>Title for slot 2</p>
    @endslot
    @slot('slot_2')
        <p>Content for slot 2</p>
    @endslot
</x-cauri-accordion-group>
```

```php
<x-cauri-accordion title="Title">
    <p>Content for slot</p>
</x-cauri-accordion>
```

### Clipboard

```php
<x-cauri-clipboard :value="$this->user->password" />
```

### Notification Icon

```php
<x-notification-icon type="danger" :logo="$notification->token->logo" />
<x-notification-icon type="success" :logo="$notification->token->logo" />
<x-notification-icon type="warning" :logo="$notification->token->logo" />
<x-notification-icon type="warning" :logo="$notification->token->logo" state-color="bg-green-100" />
```

### Simple Footer

> Only contains date, copyright notice and an cauri.cm link

`<x-cauri-simple-footer />`

### Settings Dropdown

```php
<div class="relative">
    <x-settings-dropdown button-class="icon-button w-10 h-10">
        <button class="settings-dropdown-entry">@lang('actions.start')<x-cauri-icon name="plus" size="xs" class="ml-2" /></button>
        <button class="settings-dropdown-entry">@lang('actions.stop')<x-cauri-icon name="minus" size="xs" class="ml-2" /></button>
        <button class="settings-dropdown-entry">@lang('actions.reboot')<x-cauri-icon name="reload" size="xs" class="ml-2" /></button>
    </x-settings-dropdown>
</div>
```
