<?php
namespace Zhorty;

use Zend\Http\Header\Location;

use Zend\Http\Headers;

use Zend\Http\PhpEnvironment\Response;

use Zend\Stdlib\Hydrator\ClassMethods;
use Zend\Mvc\MvcEvent;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
 	public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
	public function getServiceConfig()
    {
        return array(
            'invokables' => array(
            	'Zhorty\Entity\Trim' => 'Zhorty\Entity\Trim',
            	'Zhorty\Entity\TrimHydrator' => 'Zend\Stdlib\Hydrator\ClassMethods',
            ),
            'factories' => array(
				'Zhorty\Form\Trim' => function($sm) {
                    $form = new Form\Trim();
                    $form->setInputFilter(new Form\TrimFilter());
                    $form->setHydrator($sm->get('Zhorty\Entity\TrimHydrator'));
                    $form->bind($sm->get('Zhorty\Entity\Trim'));
                    return $form;
                },
                'Zhorty\Model\Trim' =>  function($sm) {
                	$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $table = new Model\Trim($dbAdapter);
                    $table->setTableName('trim');
                    $table->setDbAdapter($dbAdapter);
                    $table->setEntityHydrator($sm->get('Zhorty\Entity\TrimHydrator'));
                    $table->setResultSetPrototype($sm->get('Zhorty\Entity\Trim'));
                    return $table;
                },
            ),
        );
    }
    
	public function onBootstrap(MvcEvent $e) {
        $eventManager = $e->getApplication()->getEventManager();
        $eventManager->attach(MvcEvent::EVENT_DISPATCH_ERROR, array($this, 'onRouteCheckForRedirect'), 999);
    }
    
    public function onRouteCheckForRedirect(MvcEvent $e) {
        $uri = $e->getRequest()->getRequestUri();
        $uri = ltrim($uri, '/');
        
        $sm = $e->getApplication()->getServiceManager();
        $model = $sm->get('Zhorty\Model\Trim');
        
        try {
            $origUri = $model->getOrigUriByTrimPath($uri);
        }
        catch (\Exception $ex) {
            return;
        }
        
        $locationHeader = new Location();
        $locationHeader->setUri($origUri);
        $headers = new Headers();
        $headers->addHeader($locationHeader);
		$response = new Response();
		$response->setHeaders($headers);
		
		$e->setResponse($response);
		$e->stopPropagation();
    }
}