<?php

declare(strict_types=1);

namespace GildedRose\Items;

class Item
{
    public const QUALITY_LIMIT = 50;

    public function __construct(
        public string $name,
        public int    $sellIn,
        public int    $quality
    )
    {
    }

    public function updateQuality(): void
    {
        $this->decreaseQuality();

        $this->decreaseSellIn();

        if ($this->sellIn < 0) {
            $this->decreaseQuality();
        }
    }

    public function __toString(): string
    {
        return "$this->name, $this->sellIn, $this->quality";
    }

    public function decreaseSellIn(): void
    {
        if ($this->sellIn !== -1) {
            $this->sellIn--;
        }
    }

    public function decreaseQuality(int $value = 1): void
    {
        if ($this->quality > 0) {
            $this->quality = $this->quality - $value;
        }
    }

    public function qualityIsBelowLimit(): bool
    {
        return $this->quality < self::QUALITY_LIMIT;
    }
}