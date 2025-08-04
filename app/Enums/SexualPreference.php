<?php

namespace App\Enums;

enum SexualPreference: string
{
    case Heterosexual = 'heterosexual';
    case Homosexual = 'homosexual';
    case Bisexual = 'bisexual';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Heterosexual => 'Heterosexual',
            self::Homosexual => 'Homosexual',
            self::Bisexual => 'Bisexual',
            self::Other => 'Other',
        };
    }
}