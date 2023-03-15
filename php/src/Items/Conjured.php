<?php

declare(strict_types=1);

namespace GildedRose\Items;

class Conjured extends Item
{
    public function updateQuality(): void
    {
        if ($this->quality > 0) {
            $this->decreaseQuality(2);
        }

        $this->decreaseSellIn();
    }
}