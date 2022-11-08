<?php

namespace NetTantra\FilamentSliderInputField\Forms\Components;

use Filament\Forms\Components\TextInput;

class SliderInputInput extends TextInput
{
    protected string $view = 'filament-slider-input-field::forms.components.slider-input';

    protected $minValue = null;

    protected $maxValue = null;

    protected $showTooltips = true;

    public function showTooltips($showTooltips): static
    {
        $this->showTooltips = $showTooltips;

        return $this;
    }

    public function getShowTooltips(): bool
    {
        return $this->showTooltips;
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->minValue = config('filament-slider-input-field.default_min_value', 0);
        $this->maxValue = config('filament-slider-input-field.default_max_value', 10);
        $this->showTooltips = config('filament-slider-input-field.show_tooltips', true);
    }

    public function getConfigurations(): array
    {
        return [
            'minValue' => $this->minValue,
            'maxValue' => $this->maxValue,
            'showTooltips' => $this->showTooltips,
        ];
    }

}
