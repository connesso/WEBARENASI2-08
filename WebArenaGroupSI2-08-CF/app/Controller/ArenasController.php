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
    public $Taille = 15;
    public function beforeFilter()
    {

            if ($this->Session->read('Connected') == null AND ($this->request->params['action'] != 'login' AND $this->request->params['action'] != 'index' AND  $this->request->params['action'] != 'facebook')) 

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
                $this->Session->write('Fighter',0);
                //$this->Session->write('Connected', null);
                //$this->redirect(array('controller' => 'Arenas', 'action' => 'login'));
            }
        }
        
        $this->set('raw', $this->Fighter->find('all'));
        $this->set('test', $this->Session->read('Connected'));
    }
    
    public function character()
    {
        $test3=3;
        if ($this->request->is('post'))
        {
            if (isset($this->request->data['Newfighter']))
            {
                $this->Fighter->createNew($this->Session->read('Connected'), $this->request->data['Newfighter']['Nom']);
                
                //($this->request->data['Newfighter']['Avatar_file']['tmp_name'])
                
                
                $tmp=$this->Fighter->find('all');
                $tmp2=0;
                foreach ($tmp as $value)
                {
                    if($value['Fighter']['id']>$tmp2)
                    {
                        $tmp2=$value['Fighter']['id'];
                    }
                    
                }
                
                
                $nom = "../webroot/img/Avatar/{$tmp2}.png";
                //if (isset($this->request->data['Newfighter']['avatar_file']['tmp_name']))
                {
                $resultat = move_uploaded_file($this->request->data['Newfighter']['avatar_file']['tmp_name'],$nom);
                //if ($resultat) echo "Transfert réussi";
                }
               //if ($resultat) echo "Transfert réussi";
                $this->Session->write("Avatar",$nom);
                
                
                
            }
             if (isset($this->request->data['SelectFighter']))
             { 
               
                $this->Session->write('Fighter', $this->request->data['SelectFighter']['id']); 
                $test3=$this->Fighter->degager($this->Session->read('Connected'));
                $this->Fighter->enterTheBattle($this->Session->read('Fighter'), $this->Session->read('Connected'));
             }
        }
        $this->set('available_Fighter', $this->Fighter->list_fighter($this->Session->read('Connected')));
        $this->set("figter_id",$this->Session->read('Fighter'));
       
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
        // Does it come from a form (with a post method) ?
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
                //$this->Session->setFlash(
                        $this->Fighter->doMove(

                                $this->Session->read('Fighter'), $this->request->data['Fightermove']['direction']
                        );
                //);



            }
            // Is it from the form for attacking?
            if (isset($this->request->data['Figherattack']))
            {
                // ATACK ATACK ATACK
                // doAttack returne une chaine de carractère informant sur l'action effectuée.
                // setFlash affiche le message
                //$this->Session->setFlash(
                    $this->Fighter->doAttack(
                        $this->Session->read('Fighter'), $this->request->data['Figherattack']['direction'])
                    //);
                            ;
            }
            if (isset($this->request->data['Figherramasse']))
            {
                
            } 
            
            
            if (isset($this->request->data['Stat']))  
            {
                $this->Fighter->statsUp($this->Session->read('Fighter'), $this->request->data['Stat']['stat']);
            }
            
            
        }


        /* Envoie d'éléments à la vue dynamique de la page combat*/
        //$this->set('etc',$this->Tool->find('all'));

        //Modifier le plateau de jeu
        $this->set('plateau',$this->Sight->remplir_tableau($this->Fighter->find('all'),/*$this->Tool->find('all'),*/$this->Sight->get_taille(),$this->Session->read('Fighter'),$this->Fighter->get_vue($this->Session->read('Fighter'))));
        $this->set('vie',$this->Fighter->get_vie($this->Session->read('Fighter')));
        $this->set('level',$this->Fighter->get_level($this->Session->read('Fighter')));
        $this->set('force',$this->Fighter->get_force($this->Session->read('Fighter')));
        $this->set('vue',$this->Fighter->get_vue($this->Session->read('Fighter')));
        $this->set('xp',$this->Fighter->get_xp($this->Session->read('Fighter')));
        $this->set("fighter_id",$this->Session->read('Fighter'));
        //$this->set('vie', $this->Sight->test());
        




        //$this->set('raw', $this->Fighter->find('all'));


    }
    
    public function diary()
    {
        $this->set('raw',$this->Event->find());
    } 
    
    public function facebook(){
        
        require APPLIBS.'Facebook'.DS.'facebook.php';
        $facebook = new Facebook(array(
           'appId' => '739533262795662',
           'secret' => 'f944711097efbdca6f0d322ee827475f'
        ));
        $user = $facebook->getUser();
        if($user)
        {
            try{
                $infos = $facebook->api('/me');
                debug($infos);
                $d = array(
                    'email' => $infos['email']);
                if($this->Player->userExists($infos['email'])){
                    $playerid=$this->Player->getUserId($infos['email']);
                    $this->Session->write('Connected', $playerid);
                    $this->set('test', $this->Session->read('Connected'));
                }
                else if($this->Player->save($d)){
                    $playerid=$this->Player->getUserId($infos['email']);
                    $this->Session->write('Connected', $playerid);
                    $this->set('test', $this->Session->read('Connected'));
                }
                else{
                    $this->Session->setFlash("L'adresse mail est déja utilisée");
                }
            } catch (FacebookApiException $ex) {
                
                debug($e);

            }
        }else{
            $this->Session->setFlash("Erreur connexion facebook");
            $this->redirect(array('action'=>'login'));
        }
        
        //die();
            
        
    }
    
   
    
    
}
?>
