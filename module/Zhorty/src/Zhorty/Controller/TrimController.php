<?php
namespace Zhorty\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class TrimController extends AbstractActionController
{
    public function indexAction()
    {
        $sm = $this->getServiceLocator();
        $form = $sm->get('Zhorty\Form\Trim');

        if ($this->request->isPost()) {
            $form->setData($this->request->getPost());
        	if ($form->isValid()) {
        	    $model = $sm->get('Zhorty\Model\Trim');
        	    $model->save($form->getData());
        	    
        	    return $this->redirect()->toRoute('zhorty-trim/zhorty-trim-list');
        	}      
        }
        
        return new ViewModel(array('form' => $form));
    }
    
    public function listAction()
    {
        $sm = $this->getServiceLocator();
        $model = $sm->get('Zhorty\Model\Trim');
        return array('trimlist' => $model->fetchAll());
    }
    
    public function deleteAction()
    {
        $routeMatch = $this->getEvent()->getRouteMatch();
        $id = $routeMatch->getParam('id');
        
        $sm = $this->getServiceLocator();
        $model = $sm->get('Zhorty\Model\Trim');
        
        $model->delete(array("id = $id"));
        
        return $this->redirect()->toRoute('zhorty-trim/zhorty-trim-list');
    }
}
