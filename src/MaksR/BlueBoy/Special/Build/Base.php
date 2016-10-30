<?php

namespace MaksR\BlueBoy\Special\Build;

use MaksR\BlueBoy\Special\Attributes\{
    AttributeAbstract, AttributeInterface, AttributeList, AttributeFactory
};

class Base
{
    const ATTRIBUTE_POINTS_AT_START = AttributeAbstract::POINT_UNIT * 28;
    const ATTRIBUTE_MAX_ASSIGN_VALUE = AttributeAbstract::POINT_UNIT * 10;

    const AVAILABLE_ATTRIBUTES = [
        AttributeList::AGILITY,
        AttributeList::CHARISMA,
        AttributeList::ENDURANCE,
        AttributeList::INTELLIGENCE,
        AttributeList::LUCK,
        AttributeList::PERCEPTION,
        AttributeList::STRENGTH,
    ];

    private $attributes;

    public function __construct(array $initialPoints = [])
    {
        $this->loadAttributes();

        /*
         * Generate random build if there is no points provided
         * */
        if (empty($initialPoints)) {
            $initialPoints = $this->generateRandomBuild();
        }

        $this->distributeInitialPoints($initialPoints);
    }

    /**
     *
     */
    private function loadAttributes(): void
    {
        $this->attributes = AttributeFactory::load(
            self::AVAILABLE_ATTRIBUTES
        );
    }

    /**
     * Returns random build points
     */
    private function generateRandomBuild(): array
    {
        $randomBuild = new RandomBuild(
            self::AVAILABLE_ATTRIBUTES,
            self::ATTRIBUTE_POINTS_AT_START,
            self::ATTRIBUTE_MAX_ASSIGN_VALUE
        );
        return $randomBuild->getArrayCopy();
    }

    /**
     * Returns all attributes
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes->getArrayCopy();
    }

    /**
     * @param string $name
     * @return AttributeAbstract
     */
    public function getAttribute(string $name): AttributeAbstract
    {
        return $this->attributes[$name];
    }

    /**
     * Validates points for initial build
     * @param array $initialPoints
     * @throws \Exception
     */
    private function initialPointsValidate(array $initialPoints): void
    {
        $initialPointsKeys = array_keys($initialPoints);
        $checkKeys = array_diff(
            self::AVAILABLE_ATTRIBUTES,
            $initialPointsKeys
        );
        if (count($checkKeys) > 0) {
            throw new \Exception(
                vsprintf(
                    "Missing points for attributes: %s",
                    implode(", ", $checkKeys)
                )
            );
        }
        if (array_sum($initialPoints) > self::ATTRIBUTE_POINTS_AT_START) {
            throw new \Exception(
                vsprintf(
                    "Too many initial points for attributes: %s",
                    array_sum($initialPoints)
                )
            );
        }
    }

    /**
     * @param array $initialPoints
     */
    private function distributeInitialPoints(array $initialPoints): void
    {
        $this->initialPointsValidate($initialPoints);
        foreach ($initialPoints as $attribute => $points) {
            $this->getAttribute($attribute)->setPoints($points);
        }
    }
}
