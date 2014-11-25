<?php

App::uses('AppController', 'Controller');

/**
 * Main controller of our small application
 *
 * @author ...
 * @todo 
 */

//A COMMENTER 

class ArenasController extends AppController
{   
    public function beforeFilter()
    {

            if ($this->Session->read('Connected') == null AND ($this->request->params['action'] != 'login' AND $this->request->params['action'] != 'index')) 
            {
                $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
            }
        }
        


     public $uses = array('Player', 'Fighter', 'Event','Sight');

    /**
     * index method : first page
     *
     * @return void
     */
    public function index()
    {
        
    }
    
    public function login()
    {
        
        //$processingResult = '';
        $this->Fighter->find('all');
        if ($this->request->is('post'))
        {
            if (isset($this->request->data['Inscription']))
            {
                $this->Player->createNew($this->request->data['Inscription']['Email'],$this->request->data['Inscription']['Mot de passe']);
            }
            // Is it from the form for attacking?
            if (isset($this->request->data['Connexion']))
            {
                $processingResult=$this->Player->checkLogin($this->request->data['Connexion']['Email'],$this->request->data['Connexion']['Mot de passe']);
                $this->Session->write('Connected', $processingResult);
            }
            if (isset($this->request->data['Deconnexion']))
            {

                $this->Session->delete('Connected');
                //$this->Session->write('Connected', null);
                //$this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
            }
        }
        
        $this->set('raw', $this->Player->find('all'));
    }
    
    public function character()
    {
        if ($this->request->is('post'))
        {
            if (isset($this->request->data['Newfighter']))
            {
                $this->Fighter->createNewFighter($this->Session->read('Connected'), $this->request->data['Newfighter']['Nom']);
            }
        }
        $this->set('raw', $this->Fighter->find('all'));
    }
    
    public function log($msg, $type = LOG_ERR, $scope = NULL)
    {
        
    }
    
public function sight()
    {
        
        
        // form processing 
        //$this->Sight->tableau();
        $processingResult = '';
        $this->Fighter->find('all');
        // Does it come from a from (with a post method) ?
        if ($this->request->is('post'))
        {
            // What are the recieved datas?
            //pr($this->request->data);
            // Is it from the form for moving?
            if (isset($this->request->data['Fightermove']))
            {
                $processingResult = $this->Fighter->doMove(1, $this->request->data['Fightermove']['direction']);
                if($processingResult)
                {
                    $this->Session->setFlash('Déplacement réalisé');
                    
                }
                else 
                {
                    $this->Session->setFlash('Mouvement impossible');
                }
                
            }
            // Is it from the form for attacking?
            if (isset($this->request->data['Figherattack']))
            {
                $processingResult = $this->Fighter->doAttack(1, $this->request->data['Figherattack']['direction']);
                if($processingResult){$this->Session->setFlash('Attaque réalisée');}
                else $this->Session->setFlash('Attaque impossible');
            }
            
            
        }
        //$this->Sight->remplir_tableau();
        //Modifier le plateau de jeu
        $this->set('plateau',$this->Sight->remplir_tableau($this->Fighter->find('all')));
        

        $this->set('processingResult', $processingResult);
        $this->set('raw', $this->Fighter->find('all'));
        
    }
    
    public function diary()
    {
        $this->set('raw',$this->Event->find());
    }   
    
   
    
    

}
?>