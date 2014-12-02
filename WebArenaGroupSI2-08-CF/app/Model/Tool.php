<?php
/**
 * Created by PhpStorm.
 * User: rconnesson
 * Date: 01/12/14
 * Time: 14:10
 */

App::uses('AppModel', 'Model');

class Tool extends AppModel{
    
    public $displayField = 'name';
    
    
    public $belongsTo = array(
        
        'Fighter' => array(
            
            'className' => 'Fighter',
            
            'foreignKey' => 'fighter_id',
            
            'conditions' => '',
            
            'fields' => '',
            
            'order' => ''
        ),
    );


    /**
     *  CETTE LIGNE PERMET DE COMPTER LE NOMBRE D'OBJET NON EQUIPE
     *  $this->find('count', array('conditions' => array('fighter_id' => null))));
     * IL FAUT JUSTE VERIFIER QUE TOUT EST INFERIEUR A UNE LIMITE (MAX150)
     * SINON NE RIEN FAIRE.
     */

    /**
     * Génère un objet aléatoirement.
     * @throws Exception
     */
    public function randomGen()
    {
        if($this->countObject()==0){

        /**
         * gen alea.
         */
        $type = 'null';
        switch(rand(0,2))
        {
            case 0:
                $type = 'life';
                break;
            case 1:
                $type = 'force';
                break;
            case 2:
                $type = 'vue';
                break;
        }

        $bonus = rand(1,3);



        /**
         * Check space
         */
        do {

            $randomX = (rand() % 15);
            $randomY = (rand() % 10);

            $occupationCase = $this->find('first', array('conditions' => array(
                    'Tool.coordinate_x' => $randomX,
                    'Tool.coordinate_y' => $randomY
                ))
            );
        }while($occupationCase != null);

        /**
         * Save
         */
        $info=array(
            'type' => $type ,
            'bonus' => $bonus,
            'coordinate_x' => $randomX,
            'coordinate_y' => $randomY,
            'fighter_id' => null
        );

        $this->create();
        $this->save($info);
        }
    }
    
    //Retourne le nombre d'objet non inutilisé
    public function countObject(){
        $i=0;
        $datas=$this->find('all');
        foreach($datas as $d){
            if($d['Tool']['fighter_id']==null){
                $i++;
            }
        }
        return $i;
        
        
    }

    /**
     * Vérifie présence d'object sur la case.
     * @param $x coordonnée
     * @param $y coordonnée
     * @return array si object sur la case | null si pas object
     */
    public function findByCoord($x,$y)
    {
        $tool = $this->find('all');
        foreach($tool as $value)
        {
            //foreach($value as $value2)
            {
                if ( $value['Tool']['coordinate_x']==$x AND $value['Tool']['coordinate_y']==$y)
                {
                    return $value['Tool']['id'];
                }
            }
            
        }

        return null;
    }

   
    //Fonction refaite
    public function equip($fighter_id, $tool_id)
    {
        $tool=$this->read(null, $tool_id);
        $this->set('coordinate_x', -3);
        $this->set('coordinate_y', -3);
        $this->set('fighter_id', $fighter_id);
        $this->save();
        $this->equip_fighter($tool_id);
       
    }
    
    
    public function equip_fighter($tool_id)
            
    {
        $tool=$this->read(null, $tool_id);
        
        // TROUVER TYPE ET BONUS
        $type = $tool ['Tool']['type'] ;
        $bonus = $tool ['Tool']['bonus'] ; 
        
        switch ($type){
            case 'life':
                    $type = 'health';
                break;
            case 'force' :
                    $type = 'strength';
                break;
            case 'vue' :
                    $type = 'sight';
                break;
        }
        //UP LE FIGHTER
        $hdlFig = new Fighter();
        
        $fid = $tool['Tool']['fighter_id'];
      
        for($i=0;$i<$bonus;$i++)
            $hdlFig->statsChg($fid, $type);
        

    }
    
   
    
   
    
}