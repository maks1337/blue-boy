<?php

namespace MaksR\BlueBoy\Special\Build;

class BuildFactory
{

    public static function create(string $template)
    {
        try {
            return new Base();
        } catch (\Throwable $error) {
            throw new \Exception(
                vsprintf(
                    "Cannot create build \n%s",
                    [$error]
                )
            );
        }
    }

}
