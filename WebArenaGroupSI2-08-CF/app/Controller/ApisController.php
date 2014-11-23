<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class ApisController extends AppController
{
    public $uses = array('Player', 'Fighter', 'Event');
    
    public function fighterview($id)
    {
        $this->layout = 'ajax'; 
        $this->set('datas', $this->Fighter->findById($id));
    }
    
    public function fighterdomove($id, $direction)
    {
        $this->layout = 'ajax';
        //On applique la fonction domove défini dans fighter.php
        $this->Fighter->doMove($id, $direction);
        //On retourne l'ensemble dans la variable datas que l'on affichera dans la vue
        $this->set('datas', $this->Fighter->findById($id));
    }
    
    public function fighterdoattack($id, $direction)
    {
        $this->layout = 'ajax';
        $this->Fighter->doAttack($id, $direction);
        $this->set('datas', $this->Fighter->findById($id));
    }
}
