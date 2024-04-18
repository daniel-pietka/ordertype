# Magento 2 Order Type module
Module for Magento 2 that adds Order Type selection to the checkout page

## Features
* Add your own order type names for each store view
* Filter orders by order type value
* Adds an input type radio to checkout with the selection of order type

## Project status
The project is currently under development, planned to development:
* Configuration and logic for enable/disable module
* Configuration for default Order Type value in checkout
* Add to order form in admin panel checkbox for selecting Order Type value
* Order Type sorting options for checkout
* Select the store view for different versions of Order Type translations for sores
* Added the ability to edit the Order Type in the Administrator Panel

## Installation
To install the GLS Poland Shipping module use composer.

### Add repository
Add new repository to your composer.json file with:

```
composer config repositories.ordertype vcs https://github.com/daniel-pietka/ordertype.git
```

### Require repository
Then you can require the repo with:

```
composer require danielpietka/ordertype
```

### Module Setup
To install the module, you need to run the following CLI commands in magento root directory.

Enable module in Magento
```
php bin/magento module:enable DanielPietka_OrderType
```

Setup Magento
```
php bin/magento setup:upgrade
```

Compile code
```
php bin/magento setup:di:compile
```

Deploy static content
```
php bin/magento setup:static-content:deploy
```

Flush cache
```
php bin/magento cache:flush
```

## Tested with Magento 2 versions
* Adobe Commerce (Enterprise Edition)
    * ver. 2.4.6-p4
* Magento 2  (Community Edition)
    * ver. 2.4.6-p4

## Require
* PHP 8.1.0 || 8.2.0
