<?php

namespace Kata;

trait OperationalTrait
{
    protected function _getMessage(string $message = null, float $money = null): string
    {
        if (!$message && !$money) {
            if ($this->_balance == 0) {
                return 'INSERT COIN';
            }

            return sprintf('$%.2f', $this->_balance);
        }

        if ($money) {
            $message .= sprintf('$%.2f', $money);
        }

        return $message;
    }

    protected function _removeItemFromInventory(float $product)
    {
        $this->_state = self::STATE_DISPENSE;
        $item         = array_search($product, $this->_inventory);

        unset($this->_inventory[$item]);
    }

    protected function _soldOut(): array
    {
        return $this->checkDisplay('SOLD OUT');
    }

    protected function _vendProduct(float $product): array
    {
        $this->_removeConsumedCoins($product);
        $this->_removeItemFromInventory($product);

        if ($this->_balance == 0.0) {
            return $this->checkDisplay('THANK YOU');
        }

        $balance = $this->_makeChange($product)['balance'];
        $change  = $this->_makeChange($product)['change'];
        $display = $this->checkDisplay('THANK YOU');

        $display['change']  = $display['balance'];
        $display['balance'] = '$0.00';

        return $display;
    }
}
