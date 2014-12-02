<?php

App::uses('AppModel', 'Model');

class Sight extends AppModel 
{

    public $Taille = 15;
    
    public function get_taille()
    {
        return $this->Taille;
    }
    public function remplir_tableau($Characters,$Tool,$Taille,$NotreFighter,$vue)
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
        foreach ($Tool as $value)
        {
            foreach($value as $key1=>$value2)
            {
                if($key1=='Tool')
                {
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
                            
                        if ($key2=='type')
                        {
                            if($value3=='vue')
                            {
                                $msg='V';
                            }
                            if($value3=='life')
                            {
                                $msg='L';
                            }
                            if($value3=='force')
                            {
                                $msg='F';
                            }
                        }
                        
                    }
                    if ($X>=0 AND $X<$Taille AND $Y>=0 AND $Y<$Taille)
                    {
                        $plateau[$Taille-1-$Y][$X]= $msg;
                    }
                }
            }
            /*if($value['Tool']['coordinate_x']>=0 AND $value['Tool']['coordinate_x']<$Taille AND $value['Tool']['coordinate_y']>=0 AND $value['Tool']['coordinate_y']<$Taille)
            {
                if($value['Tool']['Type']='Life')
                {
                    $plateau[$Taille-1-$value['Tool']['coordinate_y']][$$value['Tool']['coordinate_x']]= 'L';
                }
                elseif($value['Tool']['Type']='Force')
                {
                    $plateau[$Taille-1-$value['Tool']['coordinate_y']][$$value['Tool']['coordinate_x']]= 'F';
                }
                elseif($value['Tool']['Type']='Vue')
                {
                    $plateau[$Taille-1-$value['Tool']['coordinate_y']][$$value['Tool']['coordinate_x']]= 'V';
                }
            }*/
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
                        $plateau[$Taille-1-$Y][$X]= $msg;
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
