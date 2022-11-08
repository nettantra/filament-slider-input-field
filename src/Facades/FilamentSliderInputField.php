<?php

namespace NetTantra\FilamentSliderInputField\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NetTantra\FilamentSliderInputField\FilamentSliderInputField
 */
class FilamentSliderInputField extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \NetTantra\FilamentSliderInputField\FilamentSliderInputField::class;
    }
}
