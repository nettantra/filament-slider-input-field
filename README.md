# Slider Input Field for Filament Forms

This is a wrapper around [noUiSlider](https://refreshless.com/nouislider/) which allows creating a slider field on Filament Forms.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nettantra/filament-slider-input-field.svg?style=flat-square)](https://packagist.org/packages/nettantra/filament-slider-input-field)
[![Total Downloads](https://img.shields.io/packagist/dt/nettantra/filament-slider-input-field.svg?style=flat-square)](https://packagist.org/packages/nettantra/filament-slider-input-field)

## Installation

You can install the package via composer:

```bash
composer require nettantra/filament-slider-input-field
```

## Usage

```php
use NetTantra\FilamentSliderInputField\Forms\Components\SliderInput;

// admin panel
    public static function form(Form $form): Form
    {
        return $form->schema([
                    ...
                    SliderInput::make('rating')
                                ->minValue(0)
                                ->maxValue(5)
                                ->step(0.05);
                ]);
     }

//frontend-forms 
    protected function getFormSchema(): array
    {
        return [
            ....
             SliderInput::make('rating')
                        ->minValue(0)
                        ->maxValue(5)
                        ->step(0.05);
        ];
    }
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on latest changes.

## Security Vulnerabilities

Please report any security vulnerabilities by raising an issue [here](https://github.com/nettantra/filament-slider-input-field/issues/new)

## Credits

- [NetTantra Technologies](https://github.com/nettantra)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
