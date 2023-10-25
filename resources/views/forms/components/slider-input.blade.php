@once
<x-livewire-range-slider::scripts />
@endonce

@php
$datalistOptions = $getDatalistOptions();
$extraAlpineAttributes = $getExtraAlpineAttributes();
$id = $getId();
$isConcealed = $isConcealed();
$isDisabled = $isDisabled();
$isPrefixInline = $isPrefixInline();
$isSuffixInline = $isSuffixInline();
$mask = $getMask();
$prefixActions = $getPrefixActions();
$prefixIcon = $getPrefixIcon();
$prefixLabel = $getPrefixLabel();
$suffixActions = $getSuffixActions();
$suffixIcon = $getSuffixIcon();
$suffixLabel = $getSuffixLabel();
$statePath = $getStatePath();

$min = floatval($getMinValue());
$max = floatval($getMaxValue());
$twenty_percent = (($min+$max)*20)/100;
$forty_percent = (($min+$max)*40)/100;
$sixty_percent = (($min+$max)*60)/100;
$eighty_percent = (($min+$max)*80)/100;

$range_slider_options = [
'start' => $getState(),
'range' => [
'min' => $min,
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

<x-dynamic-component :component="$getFieldWrapperView()" :field="$field">
    <x-filament::input.wrapper :disabled="$isDisabled" :inline-prefix="$isPrefixInline" :inline-suffix="$isSuffixInline" :prefix="$prefixLabel" :prefix-actions="$prefixActions" :prefix-icon="$prefixIcon" :suffix="$suffixLabel" :suffix-actions="$suffixActions" :suffix-icon="$suffixIcon" :valid="! $errors->has($statePath)" class="fi-fo-text-input" :attributes="
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class(['overflow-hidden'])
        ">
        <div class="flex-1 relative">
            <div class="filament-slider-input py-12 px-4 rounded border relative z-10" >
                <x-range-slider id="{{ $field_id }}" :options="$range_slider_options" :disabled="$isDisabled" wire:model.defer="{{ $getStatePath() }}" wire:key="oa-slider-{{ $field_id }}" />
                @if ($isDisabled)
                <div class="filament-slider-input-disable-block-ui absolute w-full h-full inset-0 z-10 cursor-not-allowed"></div>
                @endif
            </div>

            <div style="opacity: 0;" class="absolute inset-0 z-0">
                <x-filament::input :attributes="
                \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                    ->merge($extraAlpineAttributes, escape: false)
                    ->merge([
                        'autocapitalize' => $getAutocapitalize(),
                        'autocomplete' => $getAutocomplete(),
                        'autofocus' => $isAutofocused(),
                        'disabled' => $isDisabled,
                        'id' => $id,
                        'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                        'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                        'inputmode' => $getInputMode(),
                        'list' => $datalistOptions ? $id . '-list' : null,
                        'max' => (! $isConcealed) ? $getMaxValue() : null,
                        'maxlength' => (! $isConcealed) ? $getMaxLength() : null,
                        'min' => (! $isConcealed) ? $getMinValue() : null,
                        'minlength' => (! $isConcealed) ? $getMinLength() : null,
                        'placeholder' => $getPlaceholder(),
                        'readonly' => $isReadOnly(),
                        'required' => $isRequired() && (! $isConcealed),
                        'step' => $getStep(),
                        'type' => blank($mask) ? $getType() : 'text',
                        $applyStateBindingModifiers('wire:model') => $statePath,
                        'x-data' => (count($extraAlpineAttributes) || filled($mask)) ? '{}' : null,
                        'x-mask' . ($mask instanceof \Filament\Support\RawJs ? ':dynamic' : '') => filled($mask) ? $mask : null,
                    ], escape: false)
            " />
            </div>
        </div>

    </x-filament::input.wrapper>

    @if ($datalistOptions)
    <datalist id="{{ $id }}-list">
        @foreach ($datalistOptions as $option)
        <option value="{{ $option }}" />
        @endforeach
    </datalist>
    @endif
</x-dynamic-component>