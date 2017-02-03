<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class IndexController extends AbstractActionController {

	public function indexAction() {
		$this->layout()->setVariable('maVariable', 'ta mere');
		//Adapter connexion BDD
		$adapter = new Adapter(array(
			'driver' => 'mysqli',
			'database' => 'bdd_test',
			'username' => 'root',
			'password' => ''
		));
		//$sql = new Sql($adapter);
		//$select = $sql->select()->from('contact')->order('id ASC');
		//$selectString = $sql->getSqlStringForSqlObject($select);
		//$results = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		//$results = $adapter->query('SELECT * FROM contact ORDER BY nom ASC', $adapter::QUERY_MODE_EXECUTE);
		//$data = [];
		//foreach($results as $row) { $data[] = utf8_encode($row['nom']); }
		//print_r($data);
		$sql = new Sql($adapter);

		//tweet
		$select = $sql->select()->from('tweets')->order('id ASC');
		$selectString = $sql->getSqlStringForSqlObject($select);
		$tweet = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		$data = [];
		foreach ($tweet as $row) {
			$data[] = [utf8_encode($row['auteur']), utf8_encode($row['message']), utf8_encode($row['href'])];
		};

		//team
		$select = $sql->select()->from('team')->order('id ASC');
		$selectString = $sql->getSqlStringForSqlObject($select);
		$team = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		$dataTeam = [];
		foreach ($team as $row) {
			$dataTeam[] = [utf8_encode($row['nom']), utf8_encode($row['prenom']), utf8_encode($row['job']), utf8_encode($row['img'])];
		};

		//portfolio
		$select = $sql->select()->from('portfolio')->order('id ASC');
		$selectString = $sql->getSqlStringForSqlObject($select);
		$portfio = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		$dataPort = [];
		foreach ($portfio as $row) {
			$dataPort[] = [utf8_encode($row['text']), utf8_encode($row['img'])];
		};

		//pricing
		$select = $sql->select()->from('pricing')->order('id ASC');
		$selectString = $sql->getSqlStringForSqlObject($select);
		$pricing = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		$dataPrice = [];
		foreach ($pricing as $row) {
			$dataPrice[] = [utf8_encode($row['title']), utf8_encode($row['subtitle']), utf8_encode($row['features']), utf8_encode($row['price'])];
		};
		//pricing features
		foreach ($pricing as $p) {
			$features = [];
			$features = explode(';', $p['features']);
		};

		//Passage variable à la vue
		$viewModel = new ViewModel();
		$viewModel->setVariables(array('tweet' => $data, 'team' => $dataTeam, 'port' => $dataPort, 'price' => $dataPrice, 'features' => $features));
		return $viewModel;
	}

	public function connectBDD() {
		//Adapter connexion BDD
		$adapter = new Adapter(array(
			'driver' => 'mysqli',
			'database' => 'bdd_test',
			'username' => 'root',
			'password' => ''
		));
		return $sql = new Sql($adapter);
	}

	public function albumAction() {
		echo $this->params()->fromRoute('id');
		return new ViewModel();
	}

	public function aboutmeAction() {

		return new ViewModel();
	}

	public function teamAction() {

		$adapter = new Adapter(array(
			'driver' => 'mysqli',
			'database' => 'bdd_test',
			'username' => 'root',
			'password' => ''
		));

		$sql = new Sql($adapter);

		$name = $this->params()->fromRoute('name');

		$select = $sql -> select()->from('team')->order('id ASC');

		if ($this->params()->fromRoute('name')) {
			$select->where(array('nom' => $name));
			echo 'bonjour';
		} else {
			'';
			echo 'il a pas dit bonjour';
		}
		$selectString = $sql->getSqlStringForSqlObject($select);
		print_r($selectString);
		$req = $adapter->query($selectString, $adapter::QUERY_MODE_EXECUTE);
		$dataMember = [];

		foreach ($req as $row) {

			$dataMember[] = [
				utf8_encode($row['nom']),
				utf8_encode($row['prenom']),
				utf8_encode($row['age']),
				utf8_encode($row['ville']),
				utf8_encode($row['job']),
				utf8_encode($row['description']),
				utf8_encode($row['img']),
			];
		}

		$viewModel = new ViewModel();

		$viewModel->setVariables(array('team' => $dataMember, 'name' => $name));
		return $viewModel;
	}

	public function contactAction() {
		return new ViewModel();
	}

//    public function portfolioAction()
//    {
//      return new ViewModel();
//    }
	public function otherAction() {
		return new ViewModel();
	}

}
