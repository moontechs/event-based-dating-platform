<?php

namespace App\Enums;

enum RelationshipIntent: string
{
    case SeriousRelationship = 'serious_relationship';
    case Marriage = 'marriage';
    case CasualDates = 'casual_dates';
    case DontKnow = 'dont_know';

    public function label(): string
    {
        return match ($this) {
            self::SeriousRelationship => 'Serious relationship',
            self::Marriage => 'Marriage',
            self::CasualDates => 'Casual dates',
            self::DontKnow => 'I do not know',
        };
    }
}
