<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\ServiceManager\ServiceManager;

class IndexController extends AbstractActionController {
	/**
	 * @var ServiceManager
	 */
	protected $sm;
	
	public function __construct(ServiceManager $sm)
	{
		$this->sm = $sm;
	}
	
	public function indexAction() {
		return new ViewModel ([
				'produtos' => $this->sm->get('ProdutoTable')->getAll()
		]);
	}
}