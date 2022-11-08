<?php

namespace NetTantra\FilamentSliderInputField;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use NetTantra\FilamentSliderInputField\Commands\FilamentSliderInputFieldCommand;

class FilamentSliderInputFieldServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-slider-input-field')
            ->hasConfigFile()
            ->hasViews();
    }
}
