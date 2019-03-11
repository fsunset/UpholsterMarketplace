<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('phoneNumber', [$this, 'formatPhoneNumber']),
        ];
    }

    public function formatPhoneNumber($number)
    {
        return '('.substr($number,0,3).') '.substr($number,3,3).'-'.substr($number,6,4);
    }
}
