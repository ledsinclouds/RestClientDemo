<?php

namespace RestClientDemo\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use RestClientDemo\Form\AlbumForm;
use RestClientDemo\Form\AlbumFormValidator;
use Zend\Form\FormInterface;
use RestClientDemo\Entity\AlbumHandler; 
use Zend\Session\Container;
use Zend\Debug\Debug;

class IndexController extends AbstractActionController{
	
	public function getSession(){
		$referer = new Container('album');		
		$album_id = $_SESSION['album']['album_id'];
		return $album_id;		
	}
	
    public function indexAction(){	
		$curl = curl_init('http://rest-server-skeleton.local/albums');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($curl);
		$results = json_decode($response, true);
		foreach($results as $result)

        return new ViewModel(array(
			'data' => $result
        ));
	}

	public function createAction(){
		$form = new AlbumForm(); 		
		$router = $this->getEvent()->getRouter();
		$redirect = $router->assemble(array(), array(
			'name' => 'album', 'force_canonical' => true
		));
		$redirectUri = $redirect . '/callback';
		
		$datas = array();
		$request = $this->getRequest(); 
		if($request->isPost()) {
						 
			$user = new AlbumHandler(); 
			$formValidator = new AlbumFormValidator(); 
			$form->setInputFilter($formValidator->getInputFilter()); 
			$form->setData($request->getPost()); 
						 
			if($form->isValid()){  
				$user->exchangeArray($form->getData());
				$datas[] = $user->getJsonData(); 
				$url = $redirectUri . '?' . http_build_query(array(
					'artist' => $datas[0]['artist'],
					'title' => $datas[0]['title'],
				));	
				return $this->redirect()->toUrl($url);							
			}	 
		} 

        return new ViewModel(array(
			'form' => $form,									
        ));		
	}
	
	//public function updateAction(){
		////$album_id = $this->getSession();
		//$album_id = (int)$this->getEvent()->getRouteMatch()->getParam('album_id');		
		//$ch = curl_init('http://rest-server-skeleton.local/albums/'.$album_id);
		//curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		//$response = curl_exec($ch);
		//$decode = json_decode($response, true);				

		
		//$form = new AlbumForm();		
		//$album = new \ArrayObject();	
		//$album['title'] = $decode['data'][0]['title'];
		//$album['artist'] = $decode['data'][0]['artist'];
		////var_dump($song);die;				
		//$form->bind($album);
			
		//$data = array(
			//'data' => $this->params()->fromPost()
		//);
		////var_dump($data);die;
		//if($this->getRequest()->isPost()){
			//$form->setData($data['data']);
			//if ($form->isValid()) {
				//$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
		////var_dump($data);die;				
				//curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				//curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
				//$response = curl_exec($ch);
			//}
			//return $this->redirect()->toRoute('album');
		//}
		//return new ViewModel(array(
			//'form' => $form
		//));			
	//}

	
	public function updateAction(){
		//$album_id = $this->getSession();		
		$id = (int)$this->getEvent()->getRouteMatch()->getParam('album_id');		
		$ch = curl_init('http://rest-server-skeleton.local/albums/' . $id);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		$decode = json_decode($response, true);	
		
		$form = new AlbumForm(); 
		$album = new \ArrayObject();
		//var_dump(count($key));die;
		
		$album['title'] = $decode['data']['title'];
		$album['artist'] = $decode['data']['artist'];
		//var_dump($decode);die;	
					
		$form->bind($album);
			
		$data = array(
			'data'    => $this->params()->fromPost()
		);	
		//Debug::dump($key);die;
		if($this->getRequest()->isPost()){
			$form->setData($data['data']);
			if ($form->isValid()) {
				$data = $form->getData(FormInterface::VALUES_AS_ARRAY);
		//var_dump($data);die;				
				curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
				curl_setopt($ch, CURLOPT_POSTFIELDS,http_build_query($data));
				$response = curl_exec($ch);
			}
			return $this->redirect()->toRoute('album');
		}
		return new ViewModel(array(
			'form' => $form
		));			
	}		

	public function deleteAction(){
		$album_id = $this->getSession();
		
		$id = (int)$this->getEvent()->getRouteMatch()->getParam('album_id');			
		$ch = curl_init('http://rest-server-skeleton.local/albums/'.$id);	
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");	
        $response = curl_exec($ch);	
		var_dump($uri);
		return $this->redirect()->toRoute('album', array('album_id' => $_SESSION['album']['album_id']));	       
        if(!$response) {
            return false;
        }         			
	} 		

	public function callbackAction(){
		$ch = curl_init('http://rest-server-skeleton.local/albums');
		$data = array('artist' => $_GET['artist'], 'title' => $_GET['title']);
		$data_string = json_encode($data);

		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data_string))
		);

		$result = curl_exec($ch);
		return $this->redirect()->toRoute('album');
	}

}

