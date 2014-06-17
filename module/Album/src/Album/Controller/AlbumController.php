<?php
/**
 * Created by PhpStorm.
 * User: boozz
 * Date: 15.06.14
 * Time: 18:19
 */
// module/Album/src/Album/Controller/AlbumController.php:
namespace Album\Controller;

use Zend\Mvc\Application;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class AlbumController extends AbstractActionController
{
    protected $albumTable;

    public function getAlbumTable(){
        if(!$this->albumTable){
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }
    public function indexAction()
    {
//        \Zend\Debug\Debug::dump($this->params('id'));
        return new ViewModel(array(
            'albums' => $this->getAlbumTable()->fetchAll(),
        ));
    }

    public function addAction()
    {
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id',0);
        if(!$id){
            return $this->redirect()->toRoute('album',array('action'=>'add'));
        }

        try{
            $album = $this->getAlbumTable()->getAlbum($id);
        }
        catch(\Exception $ex){
            return $this->redirect()->toRoute('album',array('action','index'));
        }
        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value','Edit');

        $request = $this->getRequest();
        if($request->isPost()){
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if($form->isValid()){
                $this->getAlbumTable()->saveAlbum($album);
                return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id'=>$id,
            'form'=>$form,
        );
    }

    public function deleteAction()
    {
    }
}