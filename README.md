# Okaeli_Giftbox

----------------------

```
@category   Okaeli  
@package    Okaeli_Giftbox  
@author     Julien Loizelet <julienloizelet@okaeli.com>  
@copyright  Copyright (c)  2017 Julien Loizelet  
@license    GNU GENERAL PUBLIC LICENSE Version 3
  
```

## Description

`Okaeli_Giftbox` is a Magento 1 extension that allowS you to add an sku (of a single product) in the cart.
It can be usefull when the logistic needs an sku for a "giftbox" instead of the native gift wrap feature.

## Warning
This extension is not a "plug and play" extension : you will need to do some css and probably other developments in order to satisfy your needs.
As explain in the 'Installation' paragraph, you have to modify your source code too.

## Installation

This extension can be installed with `modman` or `composer`.

### Requirements

- Magento >= 1.6 (probably much earlier, but I didn't test)

### Modman

Run `modman link /path/to/your/clone/of/this/repo` at root of your Magento Project.


### Composer

In your `composer.json` file, add
```
 {
"type": "vcs",
"url": "https://github.com/julienloizelet/magento1-giftbox"
 }
```
in the `repositories` part and
```
"okaeli/magento1-giftbox":"dev-master"
```
in the `require` part.

## Usage

### Configuration

This extension comes with some configurations : `System Config > Okaeli > Okaeli Giftbox`

0. Enable / Disable Feature
0. Define sku of the "Giftbox" (must be a single product sku)


### How to use it ?

* Add `<?php echo $this->getChildHtml('okaeli.giftbox.form'); ?>` somewhere in your 
'{your_theme}/template/checkout/cart.phtml' in order to call the Giftbox form.
* Add `<?php  $_additional = unserialize($_item->getOptionByCode('info_buyRequest')->getValue());?>`
at the top of your '{your_theme}/template/checkout/cart/item/default.phtml'.
With this, you will be able to manage a different design for the giftbox by testing with : `<?php if(isset($_additional['giftbox'])):?>`
* For example : if you do not want to display the giftbox in the list of the item, you can wrap the full html of '{your_theme}/template/checkout/cart/item/default.phtml'
with `<?php if(!isset($_additional['giftbox'])):?>`.


## Technical Notes

### No rewrite. Events driven development.

This extension is **0 rewrite**  guaranteed. The following event is listened:

  * `sales_quote_remove_item` : used to remove giftbox if there is no other product in cart.


### Coding Standards

This extension has been checked with the [Magento Extension Quality Program Coding Standard](https://github.com/magento/marketplace-eqp).
You can find the output of the command `phpcs /path/to/Okaeli/Giftbox/sources --standard=MEQP1` in [this file](doc/coding-standard/magento-eqp.txt).
    
## Support
If you encounter any problems or bugs, please create an issue on
[GitHub](https://github.com/julienloizelet/magento1-giftbox/issues).

## Contribution
Any contribution is highly welcome. The best possibility to provide any code is to open
a [pull request on GitHub](https://help.github.com/articles/using-pull-requests).

## License
[GNU General Public License, version 3 (GPLv3)](http://opensource.org/licenses/gpl-3.0)