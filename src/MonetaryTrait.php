<?php

namespace Kata;

trait MonetaryTrait
{
    protected function _getBalance(): float
    {
        if (empty($this->_coinage)) {
            return 0;
        }

        return array_sum($this->_coinage);
    }

    protected function _getSortedCoinage(): array
    {
        $coins = ['dimes' => [], 'nickels' => [], 'quarters' => []];

        foreach ($this->_coinage as $coin) {
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
        $coins    = [];
        $cost     = $product;
        $dimes    = $this->_getSortedCoinage()['dimes'];
        $nickels  = $this->_getSortedCoinage()['nickels'];
        $quarters = $this->_getSortedCoinage()['quarters'];

        foreach ([$quarters, $dimes, $nickels] as $sortedCoins) {
            foreach ($sortedCoins as $index => $coin) {
                if ($cost == 0) {
                    $change[] = $coin;
                } else {
                    $cost    -= $coin;
                    $coins[]  = $coin;
                }
            }
        }

        return ['cost' => $coins, 'change' => $change];
    }

    protected function _removeConsumedCoins(float $product)
    {
        foreach ($this->_makeChange($product)['cost'] as $consumedCoin) {
            $index = array_search($consumedCoin, $this->_coinage);

            unset($this->_coinage[$index]);
        }
    }
}
