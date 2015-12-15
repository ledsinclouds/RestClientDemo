<?php

namespace RestClientDemo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use RestClientDemo\Form\SongForm;
use RestClientDemo\Form\SongFormValidator;
use Zend\Form\FormInterface;
use Zend\Session\Container;
use RestClientDemo\Entity\SongHandler; 

class SongController extends AbstractActionController{

	public function indexAction(){
		$album_id = $this->getEvent()->getRouteMatch()->getParam('album_id');	

		$referer = new Container('album');
		$referer->album_id = $album_id;	
		//var_dump($referer);die;	
				
		$curl = curl_init('http://rest-server-skeleton.local/album/'.$album_id.'/songs');
		//$curl = curl_init('http://rest-server-skeleton.local/album/'.$album_id.'/songs');		
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		$results = json_decode($response, true);

		foreach($results as $result)
		return new ViewModel(array(
			'data' => $result,
		));
    }

	public function createAction(){
		$referer = new Container('album');		
		$album_id = $_SESSION['album']['album_id'];
				
		$form = new SongForm(); 		
		$router = $this->getEvent()->getRouter();
		$redirect = $router->assemble(array(), array(
			'name' => 'songs', 'force_canonical' => true
		));
		$redirectUri = $redirect . '/callback';
		
		$datas = array();
		$request = $this->getRequest(); 
		if($request->isPost()) {
						 
			$user = new SongHandler(); 
			$formValidator = new SongFormValidator(); 
			$form->setInputFilter($formValidator->getInputFilter()); 
			$form->setData($request->getPost()); 
						 
			if($form->isValid()){  
				$user->exchangeArray($form->getData());
				$datas[] = $user->getJsonData(); 
			
				$url = $redirectUri . '?' . http_build_query(array(
					'album_id' => $datas[0]['album_id'],
					'song_title' => $datas[0]['song_title'],
				));	
				
				return $this->redirect()->toUrl($url);							
			}	 
		} 

        return new ViewModel(array(
			'form' => $form,									
        ));		
	}
	
	public function updateAction(){
		$album_id = $this->getSession();
		$song_id = (int)$this->getEvent()->getRouteMatch()->getParam('song_id');		
		$ch = curl_init('http://rest-server-skeleton.local/song/'.$song_id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$decode = json_decode($response, true);				

		
		$form = new SongForm();		
		$song = new \ArrayObject();	
		$song['song_title'] = $decode['data'][0]['song_title'];	
		//var_dump($song);die;				
		$form->bind($song);
			
		$data = array(
			'data' => $this->params()->fromPost()
		);
		//var_dump($data);die;
		if($this->getRequest()->isPost()){
			$form->setData($data['data']);
			if ($form->isValid()) {
				$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
		//var_dump($data);die;				
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
				$response = curl_exec($ch);
			}
			return $this->redirect()->toRoute('songs', array('album_id' => $_SESSION['album']['album_id']));
		}
		return new ViewModel(array(
			'form' => $form
		));			
	}
	
	public function deleteAction(){
		$album_id = $this->getSession();
		
		$song_id = (int)$this->getEvent()->getRouteMatch()->getParam('song_id');			
		$ch = curl_init('http://rest-server-skeleton.local/song/'.$song_id);	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");	
        $response = curl_exec($ch);	
		var_dump($uri);
		return $this->redirect()->toRoute('songs', array('album_id' => $_SESSION['album']['album_id']));	       
        if(!$response) {
            return false;
        }         			
	} 	
	
	public function getSession(){
		$referer = new Container('album');		
		$album_id = $_SESSION['album']['album_id'];
		return $album_id;		
	}	
	
	public function callbackAction(){
		$album_id = $this->getSession();		
		$ch = curl_init('http://rest-server-skeleton.local/album/'.$album_id.'/songs');
		$data = array('album_id' => $_GET['album_id'], 'song_title' => $_GET['song_title']);
		$data_string = json_encode($data);
		
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);
		$result = curl_exec($ch);
		return $this->redirect()->toRoute('songs', array('album_id' => $_GET['album_id']));
	}	
}

