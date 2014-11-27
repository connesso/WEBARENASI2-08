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

    /**
     * @todo : CONVENTION : notreId -> id du fighter que l'on manipule / enemyId -> id du fighter ennemi.
     * @todo : CONVENTION : Les coordonnées d'un personnage Hors jeu sont : (-1,-1)
     * @todo : CONVENTION : SI le personnage est mort alors : current_health = 0
     * @todo : CONVENTION : SI le personnage est créé mais pas encore entré dans l'arène alors : level = 0
     * @todo : CONVENTION : Lors d'un level up, (tout les 4 points d'xp), le niveau augmente
     * @todo                mais xp n'est pas remis à 0.
     * @todo                L'xp est déconté quand l'utilisateur choisi d'augmenter les stats de son fighter.
     *
     */

    function doMove($notreId, $direction)
    {
        //récupérer la position et fixer l'id de travail
        $datas = $this->read(null, $notreId);

        //On récupère les données des personnages aux alentours s'ils existent
        $positionEnnemy=$this->getPositionEnnemy($notreId);


        /**
         * POUR CHAQUE DIRECTION :
         * Test (1) de direction
         * puis Test (2) de présence ennemi.
         * puis Test (3) de Bordure
         * puis Déplacement
         *
         */
        /**
         * @ TODO : Tester la présence de piège obstacle et monstre.
         */
        if ($direction == 'north'){ //TEST1
            if($positionEnnemy['north']==null){ //TEST2
                if($datas['Fighter']['coordinate_y'] != 9) { //TEST3
                    $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] + 1);} else return 'Impossible : frontière.';} else return 'Impossible : case occupé';}

        elseif ($direction == 'south'){
            if($positionEnnemy['south']==null){
                if($datas['Fighter']['coordinate_y'] != 0) {
                    $this->set('coordinate_y', $datas['Fighter']['coordinate_y'] - 1);} else return 'Impossible : frontière.';} else return 'Impossible : case occupé';}
        elseif ($direction == 'east'){
            if($positionEnnemy['east']==null){
                if($datas['Fighter']['coordinate_x'] != 14) {
                    $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] + 1);} else return 'Impossible : frontière.';} else return 'Impossible : case occupé';}

        elseif ($direction == 'west'){
            if($positionEnnemy['west']==null){
                if($datas['Fighter']['coordinate_x'] != 0) {
                    $this->set('coordinate_x', $datas['Fighter']['coordinate_x'] + -1);} else return 'Impossible : frontière.';} else return 'Impossible : case occupé';}
        else { return 'WTF???'; } // Cetteligne implique que le code HTML du formulaire a été modifé. (Via inspecter élément)

        $this->save();

        return 'Il a bougé!';
    }

    function xPplusplus($notreId, $xpGagne)
    {
        // TESTATION
        if($xpGagne)
        {
            // RECUPERATION
            $datas = $this->read(null, $notreId);
            $xpActuel = $datas['Fighter']['xp'];
            $xpNouveau = $xpActuel + $xpGagne ;

            // MODIFICATION
            if ($xpNouveau % 4 == 0) $this->set('level',$datas['Fighter']['level'] +1 ); // LEVEL UPP
            $this->set('xp', $xpNouveau) ;

            // SAUVEGARDATION
            $this->save();
        }


    }

    /**
     * Lance une attaque dans une direction.
     * Retourne une chaine de caractère décrivant l'action qui a été réalisé.
     *
     * La fonction prend aussi en charge le gain des points d'expérience en fonction de si l'attaque a réussie et d'aussi
     * si elle a tué son adversaire .
     */

    function doAttack($notreId, $direction)
    {
            $datas = $this->read(null, $notreId);

            $positionEnnemy = $this->getPositionEnnemy($notreId); // récupère les ennemis autour de notre fighter

            $textEvent = ''; // La ligne qui sera inséré dans la bdd event.

            // Vérification au cas ou le htmld u formulaire a été modifié
            if($direction == 'north' || $direction ==  'south' || $direction == 'east' || $direction ==  'west') {

                // Si un enemi est bien à portée dans cette direction.
                if ($positionEnnemy [$direction] != null) {

                    // Calcul savant pour savoir si le coup va porter ou pas.
                    if ($this->getRandomNumber($positionEnnemy[$direction]['Fighter']['id'], $datas['Fighter']['level'])) {

                        $gainxp = 1; // Au moins un point d'xp est gagné

                        // Des dégats sont infligés à l'ennemi,
                        // Si les dégats sont mortels alors , doDamage() renverra true.
                        $killingShot= $this->doDamage(
                            $positionEnnemy [$direction]['Fighter']['id'],
                            $datas['Fighter']['skill_strength']
                        );

                        //@todo Ecrire cette phrase dans la bdd EVENT
                        $textEvent = $datas['Fighter']['name'] . ' a infligé ' . $datas['Fighter']['skill_strength'] . ' dégats à ' . $positionEnnemy[$direction]['Fighter']['name'] . '.';

                        if($killingShot){ //Si l'adversaire a rendu l'âme
                            $gainxp += $positionEnnemy[$direction]['Fighter']['level'];
                            $textEvent .= '[ CRITICAL KILLING HIT BOOOM ] ';
                        }

                        $this->xPplusplus($notreId, $gainxp);

                        return $textEvent;
                    } else
                        return $datas['Fighter']['name'] . ' a rater son attaque sur ' . $positionEnnemy[$direction]['Fighter']['name'] . '.';
                }
                return $datas['Fighter']['name'] . ' frappe dans le vide.';
            }else
                return ' WTF !!!';
    }

    /**
     *
     * Inflige les dommages à l'ennemi en fonction de la force
     * Retourne true si le coup a tué (sert dans le calcul des points d'xp)
     */
    function doDamage ($enemyId, $notreStrength)
    {
            $datas = $this->read(null, $enemyId);

            $pointdevie = $datas['Fighter']['current_health'] - $notreStrength ;

            if($pointdevie > 0) { // COUP NORMAL
                $this->set('current_health', $pointdevie);
                $this->save();
                $killingshot = false;
            } else { // KILLING SHOT ça pisse le sang ma gueule

                $this->kill($enemyId);
                $killingshot = true;
            }



            return $killingshot ; // Sert au calcul des points d'expriences dans doattack().
    }

    function kill($fighterId)
    {
        //@ TODO: Check l'iD
        $datas = $this->read(null, $fighterId);
        $this->set('current_health', 0); // Il EST MORT
        $this->set('coordinate_x', -1); // DONC ON L'ENVOIE AU PARADIS (HORS JEU)
        $this->set('coordinate_y', -1); // (-1;-1) est la coordonnée du paradis.
        $this->save();
    }


    function getPositionEnnemy($notreId)
    {
            $datas = $this->read(null, $notreId);

            $Fighternorth = $this->find('first', array(
                'conditions' => array(
                    'Fighter.coordinate_y' => $datas['Fighter']['coordinate_y']+1,
                    'Fighter.coordinate_x' => $datas['Fighter']['coordinate_x']
                    )
                )
            );

            $Fightersouth = $this->find('first', array(
                'conditions' => array(
                    'Fighter.coordinate_y' => $datas['Fighter']['coordinate_y']-1,
                    'Fighter.coordinate_x' => $datas['Fighter']['coordinate_x'])
                )
            );

            $Fightereast = $this->find('first', array(
                'conditions' => array(
                    'Fighter.coordinate_x' => $datas['Fighter']['coordinate_x']+1,
                    'Fighter.coordinate_y' => $datas['Fighter']['coordinate_y']
                    )
                )
            );

            $Fighterwest = $this->find('first', array(
                'conditions' => array(
                    'Fighter.coordinate_x' => $datas['Fighter']['coordinate_x']-1,
                    'Fighter.coordinate_y' => $datas['Fighter']['coordinate_y']
                    )
                )
            );

            $postionEnnemy = array(
                'north'=> $Fighternorth,
                'south'=> $Fightersouth,
                'east'=> $Fightereast,
                'west'=> $Fighterwest,
            );

            return $postionEnnemy;
    }

    /*
     * @todo : Le nom est mal choisi
     * Renvoie un booléen qui dit si une attaque a réussie enfonction du nivau de l'attaquant et de
     */
    function getRandomNumber($enemyId, $levelattaquant)
    {

        $datas = $this->read(null, $enemyId);

        $randomnumber=(rand()%19)+1;

        $logicalcompute=10+$datas['Fighter']['level']-$levelattaquant;

        if($logicalcompute>$randomnumber)
        {

            return true;
        }
        else{return false;}
    }

    /*
     * Augmente les caracs du fighter si il a assez d'XP en stock.
     */
    public function statsUp($notreId, $statChoisie)
    {
        // RECUPERATION
        $datas = $this->read(null, $notreId);

        // VALIDATION stock d'xp supérieur à 3
        if($datas['Fighter']['xp'] > 3)
        {
            // En fnction de la stat choisie
            switch($statChoisie)
            {
                case 'health' :
                    $this->set('current_health', $datas['Fighter']['current_health'] + 3);
                    $this->set('skill_health', $datas['Fighter']['skill_health'] + 3 );
                    $this->set('xp', $datas['Fighter']['xp'] - 4 );
                    $this->save();
                    break;
                case 'strength' :
                    $this->set('skill_strength', $datas['Fighter']['skill_strength'] + 1 );
                    $this->set('xp', $datas['Fighter']['xp'] - 4 );
                    $this->save();
                    break;
                case 'sight' :
                    $this->set('skill_sight', $datas['Fighter']['skill_sight'] + 1 );
                    $this->set('xp', $datas['Fighter']['xp'] - 4 );
                    $this->save();
                    break;
                default :
                    break;
            }
        }
    }


    /**
     * Créé un nouveau joueur mais ne l'insère pas dans l'arène.
     * @param array|bool $playerId
     * @param bool $Fightername
     * @return array|void
     * @throws Exception
     */

    public function createNew($playerId, $Fightername)
    {
        // @ TODO : HYPER IMPORTANT VERIFIER QUE LE JOUEUR N'A PLUS DE PERSONNAGE DE DISPO (ALL DEAD).
        $infos=array( 'player_id' => $playerId,
            'name' => $Fightername,
            'level' => 0, // VALEUR A 0 => PERSONNAGE NON INSERE DANS LARENE
            'xp' => 0, //BASIC VALUE
            'coordinate_x' => -1, // VALEUR NEGATIVE = PERSO HORS JEU
            'coordinate_y' => -1, // VALEUR NEGATIVE = PErso HORS JEU
            'skill_sight' => 0, // BASIC VALUE
            'skill_strength' => 1, // BASIC VALUE
            'skill_health' => 3, // BASIC VALUE
            'current_health' => 3, // SI = 0 ALORS PERSO MORT
        );
        //@todo : INSERER UN TIMESTAMP : 00000000000.
        $this->create();
        $this->save($infos);
    }

    /**
     *  Insert un personnage tout juste créé dans l'arène.
     *  /!\ : INCOMPLETE
     */

    public function enterTheBattle($notreId)
    {


        /**
         * Avant de commencer il faut s'assurer que :
         * 1) Le perso est nouveau ( level = 0 )
         * 2) @todo : Que le personnage appartient bien à l'utilisateur connecté
         *
         * Il faut insérer le nouveau combattant à un endroit qui correspond aux conditions suivantes:
         * 1) Dans les limites de l'arene x€[0,14] , y€[0,9].
         * 2) Où un ennemi n'est pas.
         * 3) @todo : Où un obstacle n'est pas.
         *
         * Ensuite une fois que les conditions sur le nouveau placement sont satisfaites :
         * Passer le niveau à 1 pour confirmer son insertion dans l'arène.
         * Save toutes les données.
         *  @todo : Il faut créer un event et le sauver en BDD si l'action réussit.
         *
         */

            $datas = $this->read(null, $notreId);

            if($datas['Fighter']['level'] == 0) // (1)
            {


                // @todo : Vérfier que le personnage appartient bien à l'utilisateur connecté
                // @todo : Vérifier que le couple (randomX,randomY) n'est pas déjà occupé.

                do {

                $randomX = (rand() % 15);
                $randomY = (rand() % 10);

                $occupationCase = $this->find('first', array('conditions' => array(
                        'coordinate_x' => $randomX,
                        'coordinate_y' => $randomY))
                    );
                }while($occupationCase != null);

                $this->set('coordinate_x' , $randomX);
                $this->set('coordinate_y' , $randomY);
                $this->set('level', 1);

                $this->save();





            }
    }
}   
