<?php

App::uses('AppModel', 'Model');

class Sight extends AppModel 
{

    public $Taille = 15;
    
    public function get_taille()
    {
        return $this->Taille;
    }
    public function remplir_tableau($Characters,$Taille,$NotreFighter,$vue)
    {
        //initialisation du tableau avec du vide
        $X=0;
        $Y=0;
        for($i=0;$i<$Taille;$i++)
        {
            for($j=0;$j<$Taille;$j++)
            {
                $plateau[$i][$j]=' ';
            }
            
            
        }
        
        //Remplissage tableau les joueur présents dans l'arène
        foreach ($Characters as $value){
            foreach($value as $key1=>$value2){
                if($key1=='Fighter'){
                    foreach($value2 as $key2=>$value3)
                        {
                        if ($key2=='coordinate_x' )
                            {
                            $X=$value3;
                            
                            }
                        if ($key2=='coordinate_y' )
                            {
                            $Y=$value3;
                           
                            }
                            
                        if ($key2=='id')
                        {
                            $msg = $value3; 
                        }
                    }
                    if ($X>=0 AND $X<$Taille AND $Y>=0 AND $Y<$Taille)
                    {
                        $plateau[$Taille-1-$Y][$X]=$msg;
                    }
                }
            }  
        }
        
        /*
         * masquage des élément en dehors de la vue
         */
        
        //déterminer la position de notre Fighter
  
        for($i=0;$i<$Taille;$i++)
        {
            for($j=0;$j<$Taille;$j++)
            {
                if($plateau[$i][$j]==$NotreFighter)
                {
                    $position_x=$i;//position x de notre fighter 
                    $position_y=$j;//position y de notre fighter
                }
            }
            
            
        }
        //cacher tout  ce qui est inférieur à notre vue
        for($i=0;$i<$Taille;$i++)
        {
            for($j=0;$j<$Taille;$j++)
            {
                if(abs($i-$position_x)+abs($j-$position_y)>$vue)
                {
                    $plateau[$i][$j]='B';
                }
            }
            
            
        }
        

        
        
        
        return $plateau;
    }

   
}

?>
