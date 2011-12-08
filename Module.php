<?php

namespace FacebookBundle;

use Zend\Module\Manager,
    Zend\Module\Consumer\AutoloaderProvider,
    Zend\EventManager\StaticEventManager;

class Module implements AutoloaderProvider
{
    /**
     * @var \Zend\Di\Di
     */
    protected $locator;

    protected $config = array(
        'setAppIdInHeadScript' => true,
    );

    protected $moduleManager;

    public function init(Manager $moduleManager)
    {
        $this->moduleManager = $moduleManager;

        # pre bootstrap
        $events = StaticEventManager::getInstance();
        $events->attach('bootstrap', 'bootstrap', array($this, 'preBootstrapListner'), 20);
    }

    /**
     * Return an array for passing to Zend\Loader\AutoloaderFactory.
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
        );
    }

    public function initOptions(Manager $moduleManager)
    {
        /** @var $config \Zend\Config\Config */
        $config = $moduleManager->getMergedConfig(false);
        $this->config = array_merge(
            $this->config,
            isset($config[__NAMESPACE__]) ? $config[__NAMESPACE__] : array()
        );
    }

    /*
     * Listners
     */

    public function preBootstrapListner(\Zend\EventManager\Event $e)
    {
        /* @var $app \Zend\Mvc\Application */
        $app = $e->getParam('application');
        $this->locator = $app->getLocator();

        $this->initOptions($this->moduleManager);

        # add post dispatch action
        if ($this->isAppIdInHeadScript()) {
            $app->events()->attach('dispatch', array($this, 'postDispatchListner'), 32);
        }
    }

    public function postDispatchListner(\Zend\Mvc\MvcEvent $e)
    {
        $script = sprintf('var FB_APP_ID = "%s";', $this->getAppId());

        /** @var $view \Zend\View\PhpRenderer */
        $view = $this->locator->get('view');
        /** @var $headScript \Zend\View\Helper\HeadScript */
        $headScript = $view->plugin('HeadScript');
        $headScript->prependScript($script);
    }

    /*
     * Configuration methods
     */

    public function isAppIdInHeadScript()
    {
        return $this->config['setAppIdInHeadScript'];
    }

    public function getAppId()
    {
        $config = $this->locator
             ->instanceManager()
             ->getConfiguration('Facebook');
        return $config['parameters']['config']['appId'];
    }

    /*
     * Module options
     */

    public function getProvides()
    {
        return array(
            __NAMESPACE__ => array(
                'version' => '1.1.0'
            ),
        );
    }

    public function getConfig($env = null)
    {
        return include __DIR__ . '/configs/module.config.php';
    }
}
