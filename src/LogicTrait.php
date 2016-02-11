<?php

namespace Kata;

trait LogicTrait
{
    protected function _inInventory(float $product): bool
    {
        return in_array($product, $this->_inventory);
    }

    protected static function _isValidProduct(float $product): bool
    {
        return in_array($product, [self::CANDY, self::CHIPS, self::COLA]);
    }
}
