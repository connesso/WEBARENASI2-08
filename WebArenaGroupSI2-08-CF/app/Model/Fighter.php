<?php

App::uses('AppModel', 'Model');

class Fighter extends AppModel {

    public $displayField = 'name';

    public $belongsTo = array(

        'Player' => array(

            'className' => 'Player',

            'foreignKey' => 'player_id',

            'conditions' => '',

            'fields' => '',

            'order' => ''

        ),

   );
     function doMove($fighterId, $direction)
    {
         
       //récupérer la position et fixer l'id de travail
        $datas = $this->read(null, $fighterId);
        
        //On récupère les données des personnages aux alentours s'ils existent
        $positionEnnemy=$this->getPositionEnnemy($fighterId);

       //falre la modif + vérification que la case est innocupée 
        if ($direction == 'north' && $positionEnnemy['north']==null)
            $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] + 1);
        elseif ($direction == 'south' && $datas['Fighter']['coordinate_y']!=0 && $positionEnnemy['south']==null)
            $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] - 1);
        elseif ($direction == 'east' && $positionEnnemy['east']==null)
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] + 1);
        elseif ($direction == 'west' && $datas['Fighter']['coordinate_x']!=0 && $positionEnnemy['west']==null)
            $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] - 1);
        else
            return false;

       //sauver la modif
        $this->save();
        return true;
    }
    
    function doAttack($fighterId, $direction)
    {
        $datas = $this->read(null, $fighterId);
        
        $positionEnnemy=$this->getPositionEnnemy($fighterId);
        
        if ($direction == 'north' && $positionEnnemy['north']!=null && $this->getRandomNumber($positionEnnemy['north']['Fighter']['id'], $datas['Fighter']['level']))
        {
             $this->doDamage($positionEnnemy['north']['Fighter']['id'], $datas['Fighter']['skill_strength']);


        }
        elseif ($direction == 'south' && $positionEnnemy['south']!=null && $this->getRandomNumber($positionEnnemy['south']['Fighter']['id'], $datas['Fighter']['level']))        
        {
             $this->doDamage($positionEnnemy['south']['Fighter']['id'], $datas['Fighter']['skill_strength']); 
        
             
        }
        elseif ($direction == 'east' && $positionEnnemy['east']!=null && $this->getRandomNumber($positionEnnemy['east']['Fighter']['id'], $datas['Fighter']['level']))        
        {
             $this->doDamage($positionEnnemy['east']['Fighter']['id'], $datas['Fighter']['skill_strength']);  

        }
        elseif ($direction == 'west' && $positionEnnemy['west']!=null && $this->getRandomNumber($positionEnnemy['west']['Fighter']['id'], $datas['Fighter']['level']))
        {
             $this->doDamage($positionEnnemy['west']['Fighter']['id'], $datas['Fighter']['skill_strength']);
    
        }
        else return false;
        
        $this->save();
        return true;
        
        
    }
       
    //Inflige les dommages "strength" à Fighter identifié par fighterId 
    function doDamage ($fighterId, $strength)
    {
        $datas = $this->read(null, $fighterId);
        $this->set('current_health', $datas['Fighter']['current_health'] - $strength);
        $this->save();
        return true;
    }
    
    function getPositionEnnemy($fighterId)
    {
        $datas = $this->read(null, $fighterId);
        $Fighternorth = $this->find('first', array(
        'conditions' => array('Fighter.coordinate_y' => $datas['Fighter']['coordinate_y']+1, 'Fighter.coordinate_x' => $datas['Fighter']['coordinate_x'])));
        $Fightersouth = $this->find('first', array(
        'conditions' => array('Fighter.coordinate_y' => $datas['Fighter']['coordinate_y']-1, 'Fighter.coordinate_x' => $datas['Fighter']['coordinate_x'])));
        $Fightereast = $this->find('first', array(
        'conditions' => array('Fighter.coordinate_x' => $datas['Fighter']['coordinate_x']+1, 'Fighter.coordinate_y' => $datas['Fighter']['coordinate_y'])));
        $Fighterwest = $this->find('first', array(
        'conditions' => array('Fighter.coordinate_x' => $datas['Fighter']['coordinate_x']-1, 'Fighter.coordinate_y' => $datas['Fighter']['coordinate_y'])));
        
        $postionEnnemy = array(
            'north'=> $Fighternorth,
            'south'=> $Fightersouth,
            'east'=> $Fightereast,
            'west'=> $Fighterwest,    
        );
        
        return $postionEnnemy;
    }
    
    function getRandomNumber($fighterId, $levelattaquant)
    {
        $datas = $this->read(null, $fighterId);
        $randomnumber=(rand()%19)+1;
        $logicalcompute=10+$datas['Fighter']['level']-$levelattaquant;
        
        if($logicalcompute>$randomnumber)
        {
            return true;
        }
        else{return false;}
        
    }
    
    public function createNewFighter($playerId, $Fightername)
    {
        $infos=array( 'player_id' => $playerId, 
            'name' => $Fightername,
            'level' => 1,
            'coordinate_x' => 0,
            'coordinate_x' => 0,
            'skill_sight' => 0,
            'skill_strength' => 1,
            'skill_health' => 3,
            'current_health' => 1,
            );
        $this->create();
        $this->save($infos);
    }
    

    

}   

