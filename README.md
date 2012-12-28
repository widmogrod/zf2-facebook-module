# FacebookBundle - NOT MAINTAINED.
## Introduction
FacebookBundle is simple integration with [Facebook php-sdk](https://github.com/facebook/facebook-php-sdk) library.

P.S. Sorry for my english. If You wish to help me with this project or correct my english description - You are welcome :)

## Requirements

  * Zend Framework 2 (https://github.com/zendframework/zf2). Tested on Zend Framework 2.0.0beta4.
  * PHP 5.3 or gather

## Installation

  1. `cd my/project/directory`
  2. Create a `composer.json` file with following content:

``` json
{
    "require": {
        "widmogrod/zf2-facebook-module": "dev-master"
    }
}
```

  3. Run `php composer.phar install`
  4. Open ``my/project/folder/configs/application.config.php`` and add ``'FacebookBundle'`` to your ``'modules'`` parameter.

## How to use

``` php
// in controller
$this->getLocator()->get('facebook') // Facebook object
```

## How to setup
``` php
<?php
return array(

    /*
     * Is not required IF 'di->instance->facebook' config section is set.
     * User configuration layout will be propagated to 'di->instance->facebook' IF 'di->instance->facebook->config' is not set.
     */
    'FacebookBundle' => array(
        'setAppIdInHeadScript' => true,

        'appId'                => 'your_app_id',
        'secret'               => 'your_secret',
    ),

    'di' => array(
        'instance' => array(
            'alias' => array(
                'facebook' => 'Facebook',
            ),

            /*
             * Is not required, IF 'FacebookBundle' config section is set.
             */
            'facebook' => array(
                'config' => array(
                    'appId'                => 'your_app_id',
                    'secret'               => 'your_secret',
                )
            )
        ),
    ),
);
?>
```