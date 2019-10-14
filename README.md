# Magento2 Cache Management Selective extension

[![Latest Stable Version](https://poser.okvpn.org/pierzakp/magento2-cache-management-selective/v/stable)](https://packagist.org/packages/pierzakp/magento2-cache-management-selective)
[![License](https://poser.okvpn.org/pierzakp/magento2-cache-management-selective/license)](https://packagist.org/packages/pierzakp/magento2-cache-management-selective)

## Description

**Cache Management Selective** is an extension for Magento2 which extends cache 
management with option to selectively flush invalidated cache.

In default Magento2 cache management admin page we are unable to easily flush only 
invalidated cache. To do such operation we have to select in the grid cache types 
which are invalidated and execute refresh action for them. It is worth to remind 
that this option is unavailable when Magento2 is running in production mode.

This extension introduces new button in cache management admin page top toolbar 
section called "Flush Invalidated Cache", which also became a primary button.
Whenever cache become invalidated Magento displays a message informing about that, 
extension will append a link to this message using which you will be able to 
quickly flush invalidated cache with out navigating to cache management page.

Extension offers also a CLI command:
```php
bin/magento pierzakp:cache:flush-invalidated
```

It is a simple extension, especially great for merchants!

It includes PHPUnit tests coverage.

## Preview

#### Flush invalidated cache button:
![Flush invalidated cache button](https://github.com/pierzakp/github-assets/raw/master/magento2/extensions/magento2-cache-management-selective/flush-invalidated-cache-button.png) 

Flush invalidated cache quick link:
![Flush invalidated cache button](https://github.com/pierzakp/github-assets/raw/master/magento2/extensions/magento2-cache-management-selective/flush-invalidated-cache-link.png) 

CLI command example result:
![CLI command example result](https://github.com/pierzakp/github-assets/raw/master/magento2/extensions/magento2-cache-management-selective/flush-invalidated-cache-cli.png)

## Installation

Composer install:
```bash
composer require pierzakp/magento2-cache-management-selective
```

Please remember to enable the extension:
```php
bin/magento module:enable Pierzakp_CacheManagementSelective
```

## Questions or ideas?

Find me on Twitter [@pierzakp](https://twitter.com/pierzakp) or simply type an email!