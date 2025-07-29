<?php

namespace App\Enums;

enum RelationshipIntent: string
{
    case DontKnow = 'dont_know';
    case Monogamous = 'monogamous';
    case OpenRelationship = 'open_relationship';
    case CasualFling = 'casual_fling';

    public function label(): string
    {
        return match ($this) {
            self::DontKnow => "Don't know",
            self::Monogamous => 'Monogamous relationships',
            self::OpenRelationship => 'Open relationship',
            self::CasualFling => 'Casual fling',
        };
    }
}
