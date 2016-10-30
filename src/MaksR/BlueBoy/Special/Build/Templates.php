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
        'HEAVY' => 'S10 P5 E7 C1 I3 A2 L3',
        'SURVIVAL' => 'S3 P3 E5 C5 I6 A1 L5',
    ];

    const LIST = [
        'HUMAN' => self::HUMAN,
    ];

    /**
     * Returns attributes from requested template
     *
     * @param string $type
     * @param string|null $subtype
     * @throws BuildException
     * @return array
     */
    public static function get(string $type = null, string $subtype = null): array
    {

        $build = [];
        if ($type == null) {
            return $build;
        }

        $subtypeCheck = self::LIST[$type][$subtype] ?? null;
        $typeCheck = self::LIST[$type] ?? null;
        $list = $subtypeCheck ?? $typeCheck;

        if (empty($list)) {
            throw new BuildException("EMPTY BUILD TEMPLATE");
        }

        if (is_array($list) > 0) {
            $attributes = $list[array_rand($list)];
        } else {
            $attributes = $list;
        }

        return self::prepareAttributes($attributes);
    }

    private static function attributeGenerator(string $attributes)
    {
        foreach (explode(' ', $attributes) as $item) {
            yield [
                self::SHORT_NOTATION[$item[0]],
                $item[1]
            ];
        }
    }

    private static function prepareAttributes(string $attributes)
    {
        $build = [];
        if (!empty($attributes)) {
            foreach (self::attributeGenerator($attributes) as $value) {
                $build[$value[0]] = $value[1];
            }
        } else {
            throw new BuildException("EMPTY BUILD TEMPLATE");
        }

        $generatedAttributesCount = count($build);
        $expectedAttributesCount = count(self::SHORT_NOTATION);

        if ($generatedAttributesCount !== $expectedAttributesCount) {
            throw new BuildException(
                sprintf(
                    "INVALID BUILD TEMPLATE: Expected %d attributes, got %d",
                    $expectedAttributesCount,
                    $generatedAttributesCount
                )
            );
        }

        return $build;
    }

}

