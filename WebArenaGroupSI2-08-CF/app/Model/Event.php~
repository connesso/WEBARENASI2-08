<?php
/**
 * Created by PhpStorm.
 * User: rconnesson
 * Date: 27/11/14
 * Time: 20:04
 */

class Event extends AppModel{

    /**
     *
     * Insert un event en BDD.
     *
     * @param $description
     * @param $date (en regle générale now() )
     * @param $coordX
     * @param $coordY
     */


    public function add($description,$date,$coordX,$coordY)
    {
        //@TODO : blinder

        if($date = 'NOW')
        {
            $date = date('Y-m-d H:i:s');
        }
        $event = array(
            'Event' => array(
                'name' => $description,
                'date' => $date,
                'coordinate_x' => $coordX,
                'coordinate_y' => $coordY
            )
        );

        $this->save($event);
    }

    /**
     *
     * @param $nameF nom du fighter
     * @param $limit nombre d'event a retourné
     * @return array|null retourne un array si le joueur a jamais joué
     */
    public function getLastMoves($nameF, $limit)
    {
        $eventArray = $this->find('all',
            array(
                'conditions' => array('OR' => array( array('name LIKE' => 'ATK : '.$nameF.' %'), array( 'name LIKE' => 'MVT : '.$nameF.' %'))),
                'order' => array('date DESC'),
                'limit' => $limit
            )
        );
        return $eventArray;
    }

    /**
     * Sensé
     * @param $idPlayer
     */
    public function lastEventPlayer($idPlayer)
    {

    }
} 
