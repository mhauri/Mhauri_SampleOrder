Mhauri_SampleOrder
==================

This is my first free Magento extension who provides a solution to order a free sample through the normal checkout pro,,cess of any product in the catalog, configured by a custom attribute.

It doesn’t provide frontend adaptions.
To make it work just add a link like */sampleorder/add/product/id/{product_id}* in your template file or use the following example instead:

```php
<?php if ($this->helper('sampleorder')->isSampleOrderAllowed($_product)) : ?>
<?php $_sampleorderUrl = $this->helper('sampleorder')->getAddUrl($_product); ?>
    <a href="<?php echo $_sampleorderUrl ?>" class="link-sampleorder"><?php echo $this->helper('sampleorder')->__('Sample Order') ?></a>
<?php endif; ?>
```


Donation
========

This extension is absolutely free to use, but if you like it I would appreciate a small donation.

[![PayPayl donate button](http://img.shields.io/paypal/donate.png?color=blue)](https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=HFQABVHGFSQ22&lc=CH&item_name=Magento%20Extension%3a%20Mhauri_SampleOrder&item_number=Mhauri_SampleOrder&currency_code=CHF&bn=PP%2dDonationsBF%3abtn_donate_SM%2egif%3aNonHosted "Donate once-off to this project using Paypal")


Changelog
=========
* **1.0.5**
  - Several bugfixes
  - CE 1.9 compatible
  - Fix controller filename

* **1.0.4**
  - Add german translations
  - update attribute from type select to type boolean
  - PHP Coding Standards
