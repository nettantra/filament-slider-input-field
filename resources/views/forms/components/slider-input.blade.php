@once
    @push('scripts')
        <x-livewire-range-slider::scripts />
    @endpush
@endonce

@php
    $datalistOptions = $getDatalistOptions();

    $affixLabelClasses = [
        'whitespace-nowrap group-focus-within:text-primary-500',
        'text-gray-400' => ! $errors->has($getStatePath()),
        'text-danger-400' => $errors->has($getStatePath()),
    ];

    $min = floatval($getMinValue());
    $max = floatval($getMaxValue());
    $twenty_percent = (($min+$max)*20)/100;
    $forty_percent = (($min+$max)*40)/100;
    $sixty_percent = (($min+$max)*60)/100;
    $eighty_percent = (($min+$max)*80)/100;

    $range_slider_options = [
        'start' => $getState(),
        'range' => [
            'min' =>  $min,
            '20%' => $twenty_percent,
            '40%' => $forty_percent,
            '60%' => $sixty_percent,
            '80%' => $eighty_percent,
            'max' => $max
        ],
        'connect' => [true, false],
        'behaviour' => 'tap-drag',
        'tooltips' => $getShowTooltips(),
        'step' => floatval($getStep()),
        'pips' => [
            'mode' => 'range',
            'stepped' => true,
            'density' => 1
        ]
    ];

    $field_id = str_replace('.', '-', $getId());
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-action="$getHintAction()"
    :hint-color="$getHintColor()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>

    <div {{ $attributes->merge($getExtraAttributes())->class(['filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group']) }}>
        @if (($prefixAction = $getPrefixAction()) && (! $prefixAction->isHidden()))
            {{ $prefixAction }}
        @endif

        @if ($icon = $getPrefixIcon())
            <x-dynamic-component :component="$icon" class="w-5 h-5" />
        @endif

        @if ($label = $getPrefixLabel())
            <span @class($affixLabelClasses)>
                {{ $label }}
            </span>
        @endif

        <div class="flex-1 relative">
            <div class="filament-slider-input py-12 px-5 rounded border relative z-10">
                <x-range-slider
                    id="{{ $field_id }}"
                    :options="$range_slider_options"
                    :disabled="$isDisabled()"
                    wire:model="{{ $getStatePath() }}"
                    wire:key="oa-slider-{{ $field_id }}"
                    />
                @if ($isDisabled())
                    <div class="filament-slider-input-disable-block-ui absolute w-full h-full inset-0 z-10 cursor-not-allowed"></div>
                @endif
            </div>

            <div style="opacity: 0;" class="absolute inset-0 z-0">
                <input
                    @unless ($hasMask())
                        x-data="{}"
                        {{ $applyStateBindingModifiers('wire:model') }}="{{ $getStatePath() }}"
                        type="{{ $getType() }}"
                    @else
                        x-data="textInputFormComponent({
                            {{ $hasMask() ? "getMaskOptionsUsing: (IMask) => ({$getJsonMaskConfiguration()})," : null }}
                            state: $wire.{{ $applyStateBindingModifiers('entangle(\'' . $getStatePath() . '\')', lazilyEntangledModifiers: ['defer']) }},
                        })"
                        type="text"
                        wire:ignore
                        {!! $isLazy() ? "x-on:blur=\"\$wire.\$refresh\"" : null !!}
                        {!! $isDebounced() ? "x-on:input.debounce.{$getDebounce()}=\"\$wire.\$refresh\"" : null !!}
                        {{ $getExtraAlpineAttributeBag() }}
                    @endunless
                    dusk="filament.forms.{{ $getStatePath() }}"
                    {!! ($autocapitalize = $getAutocapitalize()) ? "autocapitalize=\"{$autocapitalize}\"" : null !!}
                    {!! ($autocomplete = $getAutocomplete()) ? "autocomplete=\"{$autocomplete}\"" : null !!}
                    {!! $isAutofocused() ? 'autofocus' : null !!}
                    {!! $isDisabled() ? 'disabled' : null !!}
                    id="{{ $field_id }}"
                    {!! ($inputMode = $getInputMode()) ? "inputmode=\"{$inputMode}\"" : null !!}
                    {!! $datalistOptions ? "list=\"{$field_id}-list\"" : null !!}
                    {!! ($placeholder = $getPlaceholder()) ? "placeholder=\"{$placeholder}\"" : null !!}
                    @if (! $isConcealed())
                        {!! $isRequired() ? 'required' : null !!}
                    @endif
                    {{ $getExtraInputAttributeBag()->class([
                        'block w-full transition duration-75 rounded-lg shadow-sm focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70',
                        'dark:bg-gray-700 dark:text-white dark:focus:border-primary-500' => config('forms.dark_mode'),
                    ]) }}
                    x-bind:class="{
                        'border-gray-300': ! (@js($getStatePath()) in $wire.__instance.serverMemo.errors),
                        'dark:border-gray-600': ! (@js($getStatePath()) in $wire.__instance.serverMemo.errors) && @js(config('forms.dark_mode')),
                        'border-danger-600 ring-danger-600': (@js($getStatePath()) in $wire.__instance.serverMemo.errors),
                    }"
                />
            </div>
        </div>

        @if ($label = $getSuffixLabel())
            <span @class($affixLabelClasses)>
                {{ $label }}
            </span>
        @endif

        @if ($icon = $getSuffixIcon())
            <x-dynamic-component :component="$icon" class="w-5 h-5" />
        @endif

        @if (($suffixAction = $getSuffixAction()) && (! $suffixAction->isHidden()))
            {{ $suffixAction }}
        @endif
    </div>

    @if ($datalistOptions)
        <datalist id="{{ $field_id }}-list">
            @foreach ($datalistOptions as $option)
                <option value="{{ $option }}" />
            @endforeach
        </datalist>
    @endif
</x-dynamic-component>