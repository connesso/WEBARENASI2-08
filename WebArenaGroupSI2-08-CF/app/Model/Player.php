<?php

App::uses('AppModel', 'Model');
App::uses('Security', 'Utility');

class Player extends AppModel {

    public $displayField = 'name';


    public $hasMany = array(

        'Fighter' => array(

            'className' => 'Fighter',

            'foreignKey' => 'player_id',

            'conditions' => '',

            'fields' => '',

            'order' => ''

        ),

   );
    
    public function createNew($email, $password)
    { 
        //On crypte le mot de passe 
        $password=Security::hash($password);
        $infos = array('email' => $email, 'password'=>$password);
        $this->create();
        $this->save($infos);
        
    }
    
    public function checkLogin($email, $password)
    {
        //On crypte le mote de passe
        $password=Security::hash($password);
        
        $playarrays=$this->find('all');
        foreach($playarrays as $play)
        {
            
            if ($play['Player']['email'] == $email && $play['Player']['password'] == $password) {
                return $play['Player']['id'];
            } 
        }
    }

    
    
    
}

?>
