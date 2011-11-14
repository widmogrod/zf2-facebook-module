# Introduction
FacebookBundle is simple integration with [Facebook php-sdk](https://github.com/facebook/php-sdk) library

# Requirements

  * Zend Framework 2 (https://github.com/zendframework/zf2)

# Installation

Simplest way:

  1. cd my/project/folder
  2. git clone git://github.com/widmogrod/zf2-facebook-module.git modules/FacebookBundle --recursive
  3. open my/project/folder/configs/application.config.php and add 'FacebookBundle' to your 'modules' parameter.

# How to use

``` php
// in controller
$this->getLocator()->get('facebook') // Facebook object
```

# How to setup
``` php
// modules/Application/configs/module.config.php
return array(
    'di' => array(
        'instance' => array(

            'facebook' => array(
                'parameters' => array(
                    'config' => array(
                        'appId'  => 'your_app_id',
                        'secret' => 'your_secret',
                    )
                )
            ),
    // (...)
```


P.S. Sory for my english.


