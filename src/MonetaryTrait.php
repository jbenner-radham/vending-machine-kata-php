<?php

namespace Kata;

trait MonetaryTrait
{
    protected function _getSortedCoinage(): array
    {
        $coins = ['dimes' => [], 'nickels' => [], 'quarters' => []];

        foreach ($this->_bank as $coin) {
            switch ($coin) {
                case self::DIME:
                    $coins['dimes'][] = $coin;
                    break;

                case self::NICKEL:
                    $coins['nickels'][] = $coin;
                    break;

                case self::QUARTER:
                    $coins['quarters'][] = $coin;
                    break;
            }
        }

        return $coins;
    }

    protected function _insufficientBalance(float $price): array
    {
        $this->_state = self::STATE_INSUFFICIENT_BALANCE;

        return $this->checkDisplay($this->_getMessage('PRICE ', $price));
    }

    protected function _makeChange(float $product): array
    {
        $change   = [];
        $cost     = $product;
        $dimes    = $this->_getSortedCoinage()['dimes'];
        $nickels  = $this->_getSortedCoinage()['nickels'];
        $quarters = $this->_getSortedCoinage()['quarters'];

        foreach ([$quarters, $dimes, $nickels] as $sortedCoins) {
            foreach ($sortedCoins as $coin) {
                if ($cost == 0) {
                    break 2;
                }

                if (($cost - $coin) >= 0) {
                    $cost     -= $coin;
                    $change[]  = $coin;
                }
            }
        }

        return ['balance' => $cost, 'change' => $change];
    }

    protected static function _parseDollarsToFloat($dollars): float
    {
        return (float) str_replace('$', '', $dollars);
    }

    protected function _removeConsumedCoins(float $product)
    {
        $this->_balance -= $product;
    }
}
