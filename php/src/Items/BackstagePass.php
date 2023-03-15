<?php

declare(strict_types=1);

namespace GildedRose\Items;

class BackstagePass extends Item
{
    public function updateQuality(): void
    {
        if ($this->qualityIsBelowLimit()) {
            $this->increaseQuality();

            if ($this->valueIsEqualOrBelowSellIn(10)) {
                $this->increaseQuality();
            }

            if ($this->valueIsEqualOrBelowSellIn(5)) {
                $this->increaseQuality();
            }
        }

        $this->decreaseSellIn();

        if ($this->valueIsEqualOrBelowSellIn(0)) {
            $this->quality = 0;
        }
    }

    public function valueIsEqualOrBelowSellIn($value): bool
    {
        return $this->sellIn <= $value;
    }

    public function increaseQuality(): void
    {
        $this->quality++;
    }
}