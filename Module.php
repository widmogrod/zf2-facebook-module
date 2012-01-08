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
        'appId'                => 'your_app_id',
        'secret'               => 'your_secret'
    );


    public function init(Manager $moduleManager)
    {
        $events = StaticEventManager::getInstance();
        # post configuration merge
        $events->attach('Zend\Module\Manager', 'loadModules.post', array($this, 'postModulesLoadsListener'), 8);
        # pre bootstrap
        $events->attach('bootstrap', 'bootstrap', array($this, 'preBootstrapListener'), 20);
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


    /*
     * Listeners
     */

    public function postModulesLoadsListener(\Zend\Module\ModuleEvent $event)
    {
        /** @var $cl \Zend\Module\Listener\ConfigMerger */
        $cl = $event->getConfigListener();
        $config = $cl->getMergedConfig(false);
        $this->config = array_merge(
            $this->config,
            isset($config[__NAMESPACE__]) ? $config[__NAMESPACE__] : array()
        );
    }

    public function preBootstrapListener(\Zend\EventManager\Event $e)
    {
        /* @var $app \Zend\Mvc\Application */
        $app = $e->getParam('application');
        $this->locator = $app->getLocator();

        # setup facebook instance configuration
        if ($this->canPropagateUserConfigToDi())
        {
            $this
                ->locator
                ->instanceManager()
                ->setConfiguration('Facebook',  array('parameters' => array('config' => $this->getFacebookUserConfig())));
        }

        # add post dispatch action
        if ($this->isAppIdInHeadScript()) {
            $app->events()->attach('dispatch', array($this, 'postDispatchListener'), 32);
        }
    }

    public function postDispatchListener(\Zend\Mvc\MvcEvent $e)
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

    public function canPropagateUserConfigToDi()
    {
        $config = $this->locator
             ->instanceManager()
             ->getConfiguration('facebook');

        return (false === isset($config['parameters']['config']['appId']));
    }

    public function getFacebookUserConfig()
    {
        return array(
            'appId'  => $this->config['appId'],
            'secret' => $this->config['secret']
        );
    }

    public function getAppId()
    {
        $config = $this->locator
            ->instanceManager()
            ->getConfiguration('facebook');

        return $this->canPropagateUserConfigToDi()
            ? $this->config['appId']
            : $config['parameters']['config']['appId'];
    }

    /*
     * Module options
     */

    public function getProvides()
    {
        return array(
            __NAMESPACE__ => array(
                'version' => '1.2.0'
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/configs/module.config.php';
    }
}
