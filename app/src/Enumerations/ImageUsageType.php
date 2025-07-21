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

}