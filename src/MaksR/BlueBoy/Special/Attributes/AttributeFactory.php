<?php

namespace MaksR\BlueBoy\Special\Attributes;

use MaksR\BlueBoy\Exceptions\BlueBoyException;

class AttributeFactory
{

    public static function create(string $attribute)
    {
        $attributeClassName = implode('\\', [__NAMESPACE__, $attribute]);
        try {
            return new $attributeClassName();
        } catch (\Throwable $error) {
            throw new BlueBoyException(
                "Cannot attach %s as attribute to a build \n%s",
                [
                    $attribute,
                    $error
                ]
            );
        }
    }

    public static function load(array $list): \ArrayObject
    {
        $attributeList = new \ArrayObject();
        foreach ($list as $attribute) {
            $attributeList[$attribute] = self::create($attribute);
        }
        return $attributeList;
    }
}
