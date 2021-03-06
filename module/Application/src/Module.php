<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\ModuleManager\ModuleManager;
use Zend\Mvc\MvcEvent;
use Zend\Session\Container;

class Module
{
    const VERSION = '3.0.3-dev';

    public function onBootstrap(MvcEvent $event)
    {
        $serviceManager = $event->getApplication()->getServiceManager();
        $viewModel = $event->getApplication()->getMvcEvent()->getViewModel();

        $translator = $serviceManager->get('translator');
        $viewModel->translator = $translator;

        $aclService = $serviceManager->get('acl');
        $authentication = $serviceManager
            ->get(\Authentication\Services\AuthenticationService::class);
        $requestUri = $serviceManager->get('request')->getRequestUri();

        $this->checkUserPermission(
            $serviceManager,
            $aclService,
            $authentication,
            $requestUri
        );
    }

    public function checkUserPermission(
        $serviceManager,
        $aclService,
        $authentication,
        $requestUri
    ) {
        $identity = $authentication->getIdentity();

        $roles = $authentication->getRoles($identity);

        $aclService->setUserRoles($roles);

        $module = explode('/', $requestUri)[1];
        $isAllowed = $aclService->isAllowed($module);

        if (! $isAllowed) {
            $response = $serviceManager->get('response');
            $response->getHeaders()->addHeaderLine('Location', 'authentication');
            $response->setStatusCode(302);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}
