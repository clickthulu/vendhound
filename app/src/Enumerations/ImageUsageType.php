<?php

namespace App\Enumerations;

class ImageUsageType implements OptionEnumerationInterface
{
    const IMAGE_LOGO = 'Logo';
    const IMAGE_BANNER = 'Banner';
    const IMAGE_SETUP = 'Example of prior display/setup';
    const IMAGE_PORTFOLIO = 'Wares, portfolio, examples of closeups';
    const IMAGE_AD = 'Advertisement';
    const IMAGE_OTHER = 'Some other purpose';

public function toArray(): array
    {
        return [
            self::IMAGE_LOGO => self::IMAGE_LOGO,
            self::IMAGE_BANNER => self::IMAGE_BANNER,
            self::IMAGE_SETUP => self::IMAGE_SETUP,
            self::IMAGE_PORTFOLIO => self::IMAGE_PORTFOLIO,
            self::IMAGE_AD => self::IMAGE_AD,
            self::IMAGE_OTHER => self::IMAGE_OTHER
        ];
    }

}