<?php

declare(strict_types=1);

namespace GildedRose;

use GildedRose\Items\AgedBrie;
use GildedRose\Items\BackstagePass;
use GildedRose\Items\Conjured;
use GildedRose\Items\Item;
use GildedRose\Items\Sulfuras;

final class GildedRose
{
    private const ITEM_LOOKUP = [
        'Aged Brie' => AgedBrie::class,
        'Sulfuras, Hand of Ragnaros' => Sulfuras::class,
        'Backstage passes to a TAFKAL80ETC concert' => BackstagePass::class,
        'Conjured Mana Cake' => Conjured::class,
    ];

    /**
     * @param Item[] $items
     */
    public function __construct(private array $items)
    {
        foreach ($this->items as $key => $item) {
            if (array_key_exists($item->name, self::ITEM_LOOKUP)) {
                $this->items[$key] = new (self::ITEM_LOOKUP[$item->name])($item->name, $item->sellIn, $item->quality);
            }
        }
    }

    public function updateQuality(): void
    {
        foreach ($this->items as $item) {
            $item->updateQuality();
        }
    }

    /**
     * @return Item[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}