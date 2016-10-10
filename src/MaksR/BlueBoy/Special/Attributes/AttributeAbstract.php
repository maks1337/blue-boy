<?php

namespace MaksR\BlueBoy\Special\Attributes;

use Colors\InvalidArgumentException;

abstract class AttributeAbstract
{
    const POINT_UNIT = 1;

    private $points = self::POINT_UNIT;

    /**
     * @return mixed
     */
    public function getName()
    {
        return self::NAME;
    }

    /**
     * @param int $points
     * @return AttributeAbstract
     * @throws InvalidArgumentException
     */
    public function setPoints(int $points): AttributeAbstract
    {
        $this->validatePoints($points);
        $this->points = $points;
        return $this;
    }

    /**
     *  Validates attribute points before they are set
     *
     * @param int $points
     * @return void
     */
    private function validatePoints(int $points): void
    {
        if ($this->points > $points) {
            throw new InvalidArgumentException('Cannot set attribute points lower than they already are');
        }
        if ($points < 1) {
            throw new InvalidArgumentException('Cannot set attribute points lower than 1');
        }
    }

    /**
     * Returns current attribute Point
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * Increments points
     * @param int $incrementBy
     */
    public function incrementPoints(int $incrementBy = 0): void
    {
        $this->setPoints(
            $this->points + ($incrementBy >  0 ? $incrementBy: self::POINT_UNIT)
        );
    }

}
