# reverb-magento - Reverb extension for Magento

---

The Magento extension that allows you to connect your store to the Reverb marketing platform.

Extension built by [TrackStreet](https://www.trackstreet.com) 

---

## Requirements

* magento/framework: 102.0.*
* magento/module-sales
* magento/module-checkout

## Install via [composer](https://getcomposer.org/download/) (recommended)
Run the following command under your Magento 2 root directory:

```
composer require trackstreetplatform/reverb-magento
php bin/magento maintenance:enable
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
php bin/magento maintenance:disable
php bin/magento cache:clean
```

## Usage

For support on this extension, please reach out to christophe@trackstreet.com


---

https://www.trackstreet.com

Copyright © 2021 TrackStreet, Inc. All rights reserved.