<?php

declare(strict_types=1);

namespace Tests;

use GildedRose\GildedRose;
use GildedRose\Items\Item;
use PHPUnit\Framework\TestCase;

class GildedRoseTest extends TestCase
{
    private const ITEM_DATA = [
        ['+5 Dexterity Vest', 1, 20],
        ['Aged Brie', 2, 49],
        ['Sulfuras, Hand of Ragnaros', 0, 80],
        ['Backstage passes to a TAFKAL80ETC concert', 15, 30],
        ['Backstage passes to a TAFKAL80ETC concert', 10, 35],
        ['Backstage passes to a TAFKAL80ETC concert', 5, 40],
        ['Backstage passes to a TAFKAL80ETC concert', 0, 50],
        ['Conjured Mana Cake', 3, 6],
    ];

    /** @var Item[] $items */
    private array $items;

    protected function setUp(): void
    {
        $this->items = array_map(fn($entry) => new Item(...$entry), self::ITEM_DATA);
    }

    public function test_that_an_item_has_decreased_quality_and_sell_in(): void
    {
        $SUT = $this->createGildedRose(0);
        $this->passDay($SUT);
        $this->assertEquals(0, $this->getFirstItem($SUT)->sellIn);
        $this->assertEquals(19, $this->getFirstItem($SUT)->quality);
    }

    public function test_that_item_with_passed_sell_in_decreases_quality_twice_as_fast(): void
    {
        $SUT = $this->createGildedRose(0);
        $this->passDay($SUT, 2);
        $this->assertEquals(-1, $this->getFirstItem($SUT)->sellIn);
        $this->assertEquals(17, $this->getFirstItem($SUT)->quality);
    }

    public function test_that_aged_brie_decreases_sell_in_and_increases_quality()
    {
        $SUT = $this->createGildedRose(1);
        $this->passDay($SUT);
        $this->assertEquals(1, $this->getFirstItem($SUT)->sellIn);
        $this->assertEquals(50, $this->getFirstItem($SUT)->quality);
    }

    public function test_that_aged_brie_decreases_sell_in_and_does_not_increase_quality_of_fifty()
    {
        $SUT = $this->createGildedRose(1);
        $this->passDay($SUT, 2);
        $this->assertEquals(0, $this->getFirstItem($SUT)->sellIn);
        $this->assertEquals(50, $this->getFirstItem($SUT)->quality);
    }

    public function test_that_legendary_item_does_not_change(): void
    {
        $SUT = $this->createGildedRose(2);
        $this->passDay($SUT);
        $this->assertEquals(0, $this->getFirstItem($SUT)->sellIn);
        $this->assertEquals(80, $this->getFirstItem($SUT)->quality);
    }

    public function test_that_backstage_pass_increases_quality_and_decreases_sell_in(): void
    {
        $SUT = $this->createGildedRose(3);
        $this->passDay($SUT);
        $this->assertEquals(31, $this->getFirstItem($SUT)->quality);
        $this->assertEquals(14, $this->getFirstItem($SUT)->sellIn);
    }

    public function test_that_backstage_pass_with_ten_sell_in_increases_quality_by_two(): void
    {
        $SUT = $this->createGildedRose(4);
        $this->passDay($SUT);
        $this->assertEquals(37, $this->getFirstItem($SUT)->quality);
        $this->assertEquals(9, $this->getFirstItem($SUT)->sellIn);
    }

    public function test_that_backstage_pass_with_five_sell_in_increases_quality_by_three(): void
    {
        $SUT = $this->createGildedRose(5);
        $this->passDay($SUT);
        $this->assertEquals(43, $this->getFirstItem($SUT)->quality);
        $this->assertEquals(4, $this->getFirstItem($SUT)->sellIn);
    }

    public function test_that_backstage_pass_with_zero_sell_in_decreases_quality(): void
    {
        $SUT = $this->createGildedRose(6);
        $this->passDay($SUT);
        $this->assertEquals(0, $this->getFirstItem($SUT)->quality);
        $this->assertEquals(-1, $this->getFirstItem($SUT)->sellIn);
    }

    public function test_that_conjured_decreases_quality_by_two_and_decreases_sell_in(): void
    {
        $SUT = $this->createGildedRose(7);
        $this->passDay($SUT);
        $this->assertEquals(4, $this->getFirstItem($SUT)->quality);
        $this->assertEquals(2, $this->getFirstItem($SUT)->sellIn);
    }

    public function createGildedRose(int $index): GildedRose
    {
        return new GildedRose([$this->items[$index]]);
    }

    private function passDay(GildedRose $SUT, $amount = 1)
    {
        for ($i = 0; $i < $amount; $i++) {
            $SUT->updateQuality();
        }
    }

    public function getFirstItem(GildedRose $SUT): Item
    {
        return $SUT->getItems()[0];
    }
}