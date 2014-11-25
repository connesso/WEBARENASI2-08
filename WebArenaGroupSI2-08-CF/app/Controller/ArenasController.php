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

            if ($this->Session->read('Connected') == null AND $this->request->params['action'] != 'login') 
            {
                $this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
            }
    }
        


     public $uses = array('Player', 'Fighter', 'Event');

    /**
     * index method : first page
     *
     * @return void
     */
    public function index()
    {
        $this->Session->write('Connected', null);
    }
    
    public function login()
    {
        
        //$processingResult = '';
        $this->Player->find('all');
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

        $this->set('raw', $this->Fighter->find('all'));

    }
    
    public function diary()
    {
        $this->set('raw',$this->Event->find());
    }   
    
   
    
    

}
?>
