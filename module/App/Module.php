<?php 
namespace App;

use Zend\Mvc\MvcEvent;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\View\Model\JsonModel;

class Module implements ConfigProviderInterface, AutoloaderProviderInterface
{
	public function onBootstrap(MvcEvent $e)
    {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onDispatchError'), 0);
        $eventManager->attach(MvcEvent::EVENT_RENDER_ERROR, array($this, 'onRenderError'), 0);
    }

    public function onDispatchError($e)
    {
        return $this->getJsonModelError($e);
    }

    public function onRenderError($e)
    {
        return $this->getJsonModelError($e);
    }

    public function getJsonModelError($e)
    {
        $error = $e->getError();
        if (!$error) {
            return;
        }

        // @TODO: check ENV to not send back sensitive data with the exceptions
        // ON DEV we could send the stack and what not, ON PROD generic message
        $errorJson = array();
        $exception = $e->getParam('exception');
        if ($exception) {
            $errorJson = array(
                'message'   => $exception->getMessage()
            );
        }
        
        if ($error == 'error-router-no-match') {
            $errorJson['message'] = 'Resource not found.';
        }

        $model = new JsonModel(array('errors' => array($errorJson)));

        $e->setResult($model);

        return $model;
    }

	public function getAutoloaderConfig()
	 {
		 return array(
			 'Zend\Loader\StandardAutoloader' => array(
				 'namespaces' => array(
					 __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
				 )
			 )
		 );
	 }

	public function getConfig()
	{
		return include __DIR__ . '/config/module.config.php';
	}
}