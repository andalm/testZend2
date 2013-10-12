<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ListsController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
	
	public function otroMetodoAction()
	{
		return new ViewModel();
	}
	
	public function recibeParametrosAction()
	{
		$layout = $this->layout();
        $layout->setTemplate('layout/otroLayout');
		$layout->title = "Recibe Parametros";
		
		$parameters = array(
			'saludo' => 'Saludo desde el controlador Lists - método recibe parámetros',
			'otro' => 'Este es otro parámetro',
			'nombres' => array('Andrés', 'Daniel', 'Natalia', 'Carolina', 'Francisco'),
			'parametro' => $this->getEvent()->getRouteMatch()->getParam('params', 'No hay')
		);
		
		return new ViewModel($parameters);
	}
	
	public function parametrosUrlAction()
	{
		$id = (int) $this->params()->fromRoute('id', false);
		$id2 = (int) $this->params()->fromRoute('id2', false);
		
		return new ViewModel(array(
			'id' => $id,
			'id2' => $id2
		));
	}
	
	public function otraVistaAction()
	{
		return $this->forward()
			->dispatch('Application\Controller\Lists', array('action' => 'recibeParametros',
				'params' => array('parametro' => 'parametro')
			));
	}
	
	public function otroLayoutAction()
	{
		//Seleccion de layout
		$layout = $this->layout();
        $layout->setTemplate('layout/otroLayout');
		$layout->title = "Otro layout";
		
		//Seleccion de vista
		//$view = new ViewModel();
		//$view->setTemplate('application/lists/index');
		//En este caso uso la que esta por defecto
		return new ViewModel();
	}
}
