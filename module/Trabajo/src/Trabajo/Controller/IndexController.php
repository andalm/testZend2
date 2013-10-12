<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Trabajo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Soap\Client;
use Trabajo\Model\Entity\MiModelo;

class IndexController extends AbstractActionController
{
	protected $albumTable;
	
    public function indexAction()
    {
		$model = new MiModelo();
		
        return new ViewModel(array('mensaje' => $model->mensaje()));
    }
	
	public function webServiceAction()
    {
		$client = new Client("http://www.webservicex.net/periodictable.asmx?WSDL", array(
			'soap_version' => SOAP_1_2,
		));
		
		$element = 'hydrogen';
		
		$stringResponse = $client->GetElementSymbol(array('ElementName' => $element));		
		$domResponse = new \Zend\Dom\Query('<?xml version="1.0" encoding="UTF-8" ?>' . 
										   $stringResponse->GetElementSymbolResult);
										   
		$result = $domResponse->execute('NewDataSet');
		
        return new ViewModel(array(
			'symbol' => $result->getDocument()->textContent, 
			'element' => $element
		));
    }
	
	public function pruebaModeloAction()
	{
		return new ViewModel(
			array(
				'albums' => $this->_getAlbumTable(),
			)
		);
	}	
	
	protected function _getAlbumTable()
	{
		if(!$this->albumTable)
		{
			$sm = $this->getServiceLocator();
			$this->albumTable = $sm->get('Trabajo\Model\Entity\AlbumTable');
		}
		
		return $this->albumTable;
	}
}
