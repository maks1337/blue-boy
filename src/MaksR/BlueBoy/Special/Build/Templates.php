<?php

namespace MaksR\BlueBoy\Special\Build;

use MaksR\BlueBoy\Special\Attributes\{AttributeList};

class Templates
{

    const SHORT_NOTATION = [
        'S' => AttributeList::STRENGTH,
        'P' => AttributeList::PERCEPTION,
        'E' => AttributeList::ENDURANCE,
        'C' => AttributeList::CHARISMA,
        'I' => AttributeList::INTELLIGENCE,
        'A' => AttributeList::AGILITY,
        'L' => AttributeList::LUCK,
    ];

    const HUMAN = [
        'MAD_SCIENTIST' => 'S3 P5 E4 C3 I9 A3 L1',
        'HEAVY' => 'S7 P5 E7 C1 I3 A2 L3',
        'SURVIVAL' => 'S3 P3 E5 C5 I6 A1 L5',
    ];

    const LIST = [
        'HUMAN' => self::HUMAN,
    ];

    public static function get(string $type, string $subtype): array
    {

        $subtypeCheck = isset(self::LIST[$type][$subtype]) ? self::LIST[$type][$subtype] : null;
        $typeCheck = isset(self::LIST[$type]) ? self::LIST[$type] : null;

        $string = $subtypeCheck ?? $typeCheck;

        $build = [];

        if (!empty($string)) {
            $values = array_map(function ($element) {
                $key = self::SHORT_NOTATION[$element[0]];
                $value = $element[1];
                return [$key, $value];
            }, explode(' ', $string));
            foreach ($values as $value) {
                $build[$value[0]] = $value[1];
            }
        }
        return $build;
    }

}

