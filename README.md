Vending Machine Kata (PHP)
==========================
> The kata of machines, their vending and stuff.

In this exercise you will build the brains of a vending machine. It will accept 
money, make change, maintain inventory, and dispense products. All the things 
that you might expect a vending machine to accomplish.

The point of this kata to to provide a larger than trivial exercise that can be
used to practice TDD. A significant portion of the effort will be in 
determining what tests should be written and, more importantly, written next.

How to Install
--------------

The recommended way to run this exercise is via [Vagrant](https://www.vagrantup.com/)
but it can be installed locally if your workstation is running PHP 7.

### Vagrant Install

Download [VirtualBox](https://www.virtualbox.org/) and 
[Vagrant](https://www.vagrantup.com/) if you do not already have them. If you 
have [Homebrew](http://brew.sh/) w/[Cask](http://caskroom.io/) on OS X you can 
install it from the terminal via:

```sh
brew cask install virtualbox vagrant
```

Then run the following from the project directory root:

```sh
vagrant up
vagrant ssh
cd /vagrant
```

Once you are done with the Vagrant box to exit the SSH session enter:

```sh
exit
```

Then to shutdown the VM type:

```sh
vagrant halt
```

And lastly, when you are ready to delete the Vagrant box VM:

```sh
vagrant destroy
```

### Standard Install

Get [Composer](https://getcomposer.org/) if you do not have it already. Then 
from the project directory root in the terminal:

- If you have a system wide install of Composer...

  ```sh
  composer install
  ```

- If you have a PHAR download of Composer...

  ```sh
  php composer.phar install
  ```
  
How to Test
-----------

From inside the project root in your terminal:

```sh
bin/phpspec run
```

Features
--------

### Accept Coins

_As a vendor_  
_I want a vending machine that accepts coins_  
_So that I can collect money from the customer_  

The vending machine will accept valid coins (nickels, dimes, and quarters) and 
reject invalid ones (pennies). When a valid coin is inserted the amount of the 
coin will be added to the current amount and the display will be updated. When 
there are no coins inserted, the machine displays "INSERT COIN". Rejected coins 
are placed in the coin return.

NOTE: The temptation here will be to create Coin objects that know their value.  
However, this is not how a real vending machine works. Instead, it identifies 
coins by their weight and size and then assigned a value to what was inserted.  
You will need to do something similar. This can be simulated using strings, 
constants, enums, symbols, or something of that nature.

- [x] Accept nickels.
- [x] Accept dimes.
- [x] Accept quarters.
- [x] Reject pennies.

### Select Product

_As a vendor_  
_I want customers to select products_  
_So that I can give them an incentive to put money in the machine_  

There are three products: cola for $1.00, chips for $0.50, and candy for $0.65.  
When the respective button is pressed and enough money has been inserted, the 
product is dispensed and the machine displays "THANK YOU".  If the display is 
checked again, it will display "INSERT COIN" and the current amount will be set 
to $0.00.  If there is not enough money inserted then the machine displays 
PRICE and the price of the item and subsequent checks of the display will 
display either "INSERT COIN" or the current amount as appropriate.

- [x] Sell cola for $1.00.
- [x] Sell chips for $0.50.
- [x] Sell candy for $0.65.
- [x] Display "INSERT COIN" and a zero balance if checked after purchase.
- [x] If there is not enough money inserted then the machine displays "PRICE" and the price of the item.
- [x] Display "INSERT COIN" if no money was inserted.
- [x] Display the current balance if any money was inserted.

### Make Change

_As a vendor_  
_I want customers to receive correct change_  
_So that they will use the vending machine again_  

When a product is selected that costs less than the amount of money in the 
machine, then the remaining amount is placed in the coin return.

- [x] Return change after a purchase.

### Return Coins

_As a customer_  
_I want to have my money returned_  
_So that I can change my mind about buying stuff from the vending machine_  

When the return coins is selected, the money the customer has placed in the 
machine is returned and the display shows "INSERT COIN".

- [x] Return deposited coins when the change return is pressed and display "INSERT COIN".

### Sold Out

_As a customer_  
_I want to be told when the item I have selected is not available_  
_So that I can select another item_  

When the item selected by the customer is out of stock, the machine displays 
"SOLD OUT".  If the display is checked again, it will display the amount of 
money remaining in the machine or "INSERT COIN" if there is no money in the 
machine.

- [x] When a selected item is sold out display "SOLD OUT".

### Exact Change Only

_As a customer_  
_I want to be told when exact change is required_  
_So that I can determine if I can buy something with the money I have before inserting it_  

When the machine is not able to make change with the money in the machine for 
any of the items that it sells, it will display "EXACT CHANGE ONLY" instead of 
"INSERT COIN".

- [x] When unable to make change for any of the items it sells the display should read "EXACT CHANGE ONLY".
