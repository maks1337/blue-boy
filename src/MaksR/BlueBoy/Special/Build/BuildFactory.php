<?php

namespace MaksR\BlueBoy\Special\Build;

use MaksR\BlueBoy\Special\Build\Templates as Templates;

class BuildFactory
{
    /**
     * Creates random build
     *
     * @return Base
     * @throws BuildException
     */
    public static function create()
    {
        self::createFromAttributes([]);
    }
    /**
     * Creates build from given template type or subtype
     *
     * @param string|null $type
     * @param string|null $subtype
     * @return Base
     * @throws BuildException
     */
    public static function createFromTemplate(string $type = null, string $subtype = null): Base
    {
        try {
            return new Base(
                Templates::get($type, $subtype)
            );
        } catch (\Throwable $error) {
            throw new BuildException(
                vsprintf(
                    "CANNOT CREATE BUILD FROM TEMPLATE: %s %s %s",
                    [
                        $type,
                        $subtype,
                        $error
                    ]
                )
            );
        }
    }

    /**
     * Creates build from given attribute list
     *
     * @param array $attributes
     * @return Base
     * @throws BuildException
     */
    public static function createFromAttributes(array $attributes): Base
    {
        try {
            return new Base(
                $attributes
            );
        } catch (\Throwable $error) {
            throw new BuildException(
                vsprintf(
                    "CANNOT CREATE BUILD FROM ATTRIBUTES: %s",
                    [
                        $error
                    ]
                )
            );
        }
    }
}
