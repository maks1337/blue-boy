<?php

namespace MaksR\BlueBoy\Special\Build;

class RandomBuild extends \ArrayObject
{
    /**
     * @var array
     */
    private $attributes;
    /**
     * @var int
     */
    private $points;
    /**
     * @var int
     */
    private $max;
    /**
     * @var int
     */
    private $startPoints;

    /**
     * RandomBuild constructor.
     * @param array $attributes
     * @param int $points
     * @param int $max
     */
    public function __construct(array $attributes, int $points, int $max)
    {
        $this->attributes = $attributes;
        $this->points = $points;
        $this->startPoints = $points;
        $this->max = $max;
        $this->randomizePoints();
    }

    /**
     * Decrease availble amount of points to distribute
     * by number of all attributes
     */
    private function distributeInitialPoint(): void
    {
        $this->points = $this->points - count($this->attributes);
    }

    /**
     * Calculates ceiling for random point calculation
     * @return int
     */
    private function getCeiling(): int
    {
        $ceiling = ($this->points < $this->max ? $this->points : $this->max);
        return ($ceiling <= 0 ? 1 : $ceiling);
    }

    /**
     * Generates random point value
     * @return int
     */
    private function getRandomPointValue(): int
    {
        return mt_rand(1, $this->getCeiling());
    }

    /**
     * @param int $randomPoint
     */
    private function reducePointsByAssignedValue(int $randomPoint): void
    {
        $this->points = $this->points - $randomPoint;
    }

    /**
     * Assigns unassigned amount of points to a random attribute
     */
    private function assignLeftoverPoints(): void
    {
        $attributeName = $this->attributes[
            array_rand($this->attributes)
        ];
        $attributeValue = $this->offsetGet($attributeName);
        $this->offsetSet(
            $attributeName,
            $attributeValue + ($this->startPoints - array_sum($this->getArrayCopy()))
        );
    }

    /**
     *
     */
    private function randomizePoints()
    {
        $i = 0;
        $this->distributeInitialPoint();
        shuffle($this->attributes);
        foreach ($this->attributes as $attribute) {
            $randomPoint = $this->getRandomPointValue();
            $this->offsetSet($attribute, $randomPoint);
            $this->reducePointsByAssignedValue($randomPoint);
            $i++;
        }
        $this->assignLeftoverPoints();
        $this->ksort();
    }
}
