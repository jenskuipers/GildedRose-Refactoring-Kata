<?php

declare(strict_types=1);

namespace GildedRose\Items;

class AgedBrie extends Item
{
    public function updateQuality(): void
    {

        if ($this->qualityIsBelowLimit()) {
            $this->increaseQuality();
        }

        $this->decreaseSellIn();

        if ($this->sellIn < 0) {
            $this->increaseQuality();
        }
    }

    public function increaseQuality(): void
    {
        $this->quality++;
    }
}