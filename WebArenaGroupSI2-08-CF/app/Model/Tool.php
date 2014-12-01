<?php
/**
 * Created by PhpStorm.
 * User: rconnesson
 * Date: 01/12/14
 * Time: 14:10
 */

App::uses('AppModel', 'Model');

class Tool extends AppModel{
    
    
    public $belongsTo = array(
        
        'Player' => array(
            
            'className' => 'Fighter',
            
            'foreignKey' => 'fighter_id',
            
            'conditions' => '',
            
            'fields' => '',
            
            'order' => ''
        ),
    );



    /**
     * @TODO : IMPORTANT IMPORTANT IMPORTANT
     * @TODO : LIMITER LE NOMBRE D'OBJET LIBRE EN CIRCULATION
     * @TODO : (suite) ET EMPECHER LA GENERATION D'OBJET AINSI QUE LA POSE SI LA LIMITE EST ATTEINTE.
     * @TODO : LIONEL OU VIVENFAIS LE STP APRES AVOIR INTEGRER LA VUE! :)
     */

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

        /**
         * gen alea.
         */
        $type = 'null';
        switch(rand(0,2))
        {
            case 0:
                $type = 'sig';
                break;
            case 1:
                $type = 'str';
                break;
            case 2:
                $type = 'hea';
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
                    'coordinate_x' => $randomX,
                    'coordinate_y' => $randomY))
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

    /**
     * Vérifie présence d'object sur la case.
     * @param $x coordonnée
     * @param $y coordonnée
     * @return array si object sur la case | null si pas object
     */
    public function findByCoord($x,$y)
    {
        $tool = $this->find('first', array('condtions' => array('coordinate_x' => $x, 'coordinate_y' => $y, 'fighter_id' => null)));

        if($tool) return $tool;
        else return null;
    }

    /**
     * Pose l'objet au sol, si la case n'est pas libre alors l'objet rebondit
     * et est jeté aléatoirement dans l'arène.
     * @param $coX
     * @param $coY
     * @param $ignore permet de poser un objet au sol meme si un objet est déjà présent . (Utile pour switcher eq perso)
     */
    public function poser($coX, $coY, $ignore)
    {
        $this->set('fighter_id', null);
        $occupationCase = $this->findByCoord($coX,$coY);


        if(!$occupationCase OR $ignore)
        {
            $this->set('coordinate_x', $coX);
            $this->set('coordinate_Y', $coY);
        }
        else{
            do {

                $randomX = (rand() % 15);
                $randomY = (rand() % 10);

                $occupationCase = $this->find('first', array('conditions' => array(
                        'coordinate_x' => $randomX,
                        'coordinate_y' => $randomY,
                        'fighter_id' => null))
                );
            }while($occupationCase != null);

            $this->set('coordinate_x', $randomX);
            $this->set('coordinate_Y', $randomY);
        }
    }

    /**
     * Equipe l'objet au fighter dont l'ID est passée en paramètre.
     * @param $fighter_id
     */
    public function equip($fighter_id)
    {
        $this->set('coordinate_x', -3);
        $this->set('coordinate_Y', -3);
        $this->set('fighter_id', $fighter_id);
    }
    
    function getPositionObjet($notreId)
    {
        $datas = $this->read(null, $notreId);

        $Objectnorth = $this->find('first', array(
                'conditions' => array(
                    'Tools.coordinate_y' => $datas['Tools']['coordinate_y']+1,
                    'Tools.coordinate_x' => $datas['Tools']['coordinate_x']
                )
            )
        );

        $Objectsouth = $this->find('first', array(
                'conditions' => array(
                    'Tools.coordinate_y' => $datas['Fighter']['coordinate_y']-1,
                    'Tools.coordinate_x' => $datas['Fighter']['coordinate_x'])
            )
        );

        $Objecteast = $this->find('first', array(
                'conditions' => array(
                    'Tools.coordinate_x' => $datas['Fighter']['coordinate_x']+1,
                    'Tools.coordinate_y' => $datas['Fighter']['coordinate_y']
                )
            )
        );

        $Objectwest = $this->find('first', array(
                'conditions' => array(
                    'Tools.coordinate_x' => $datas['Fighter']['coordinate_x']-1,
                    'Tools.coordinate_y' => $datas['Fighter']['coordinate_y']
                )
            )
        );
        $postionObject = array(
            'north'=> $Objectnorth,
            'south'=> $Objectsouth,
            'east'=> $Objecteast,
            'west'=> $Objectwest,
        );
        return $postionObject;
    }
    
    function dorammasage($notreId, $direction)
    {
        $datas = $this->read(null, $notreId);
        $positionEnnemy = $this->getPositionObject($notreId);
        if ($direction == 'north' || $direction == 'south' || $direction == 'east' || $direction == 'west') {

                // Si un enemi est bien à portée dans cette direction.
                if ($positionEnnemy [$direction] != null) 
                {
                      $this->equip($notreId); 
                }
    
                
    
        }
                
    }
    

} 
