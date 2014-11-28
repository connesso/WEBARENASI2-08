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
            $Taille = 15;

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
        $this->set('test', $this->Session->read('Connected'));
    }
    
    public function character()
    {
        if ($this->request->is('post'))
        {
            if (isset($this->request->data['Newfighter']))
            {
                $this->Fighter->createNew($this->Session->read('Connected'), $this->request->data['Newfighter']['Nom']);
            }
        }
        $this->set('raw', $this->Fighter->find('all'));
    }
    
    public function log($msg, $type = LOG_ERR, $scope = NULL)
    {
        
    }
    
    /**
     *  ATTENTION LE CODE DE SIGHT A ETE MODIFIE
     */
    public function sight()
    {

        $this->Fighter->find('all');
        // Does it come from a from (with a post method) ?
        if ($this->request->is('post'))
        {
            // What are the recieved datas?
            //pr($this->request->data);
            // Is it from the form for moving?
            if (isset($this->request->data['Fightermove']))
            {
                
                // MOUVEMENT MOUVEMENT MOUVEMENT
                // doMove returne une chaine de carractère informant sur l'action effectuée.
                // setFlash affiche le message
                $this->Session->setFlash(
                        $this->Fighter->doMove(
                                1, $this->request->data['Fightermove']['direction']
                        )
                );

            }
            // Is it from the form for attacking?
            if (isset($this->request->data['Figherattack']))
            {
                // ATACK ATACK ATACK
                // doAttack returne une chaine de carractère informant sur l'action effectuée.
                // setFlash affiche le message
                $this->Session->setFlash(
                    $this->Fighter->doAttack(
                        1, $this->request->data['Figherattack']['direction'])
                    );
            }
            
            
        }

        //$this->Sight->remplir_tableau();
        //Modifier le plateau de jeu
        $this->set('plateau',$this->Sight->remplir_tableau($this->Fighter->find('all')));




        $this->set('raw', $this->Fighter->find('all'));

    }
    
    public function diary()
    {
        $this->set('raw',$this->Event->find());
    }   
    
   
    
    

}
?>
