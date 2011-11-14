<?php

namespace FacebookBundle;

use Zend\Module\Manager,
    Zend\Loader\AutoloaderFactory;

class Module
{
    public function init(Manager $moduleManager)
    {
        $this->initAutoloader();
    }

    public function initAutoloader()
    {
        AutoloaderFactory::factory(array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        ));
    }

    public function getProvides()
    {
        return array(
            __NAMESPACE__ => array(
                'version' => '1.0.0'
            ),
        );
    }

    public function getConfig($env = null)
    {
        return include __DIR__ . '/configs/module.config.php';
    }
}
