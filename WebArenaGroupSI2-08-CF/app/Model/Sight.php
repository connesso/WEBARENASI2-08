<?php

App::uses('AppModel', 'Model');

class Sight extends AppModel 
{


    public function remplir_tableau($Characters)
    {
        /*$plateau[0]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[1]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[2]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[3]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[4]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[5]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[6]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[7]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[8]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[9]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[10]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);$plateau[11]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);
        $plateau[12]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);
        $plateau[13]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);
        $plateau[14]=array(' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',' ',);*/
        // Affichage de Notre position par x
        //$datas = $this->read(null, 1);
        
        
        $X=0;
        $Y=0;
        for($i=0;$i<15;$i++)
        {
            for($j=0;$j<15;$j++)
            {
                $plateau[$i][$j]=' ';
            }
            
            
        }
        foreach ($Characters as $value){
            foreach($value as $key1=>$value2){
                if($key1=='Fighter'){
                    foreach($value2 as $key2=>$value3)
                        {
                        if ($key2=='coordinate_x' )//AND $key2>=0 AND $key2<=14)
                            {
                            $X=$value3;
                            
                            }
                        if ($key2=='coordinate_y' )//AND $key2>=0 AND $key2<=14)
                            {
                            $Y=$value3;
                           
                            }
                            
                        if ($key2=='id')
                        {
                            $msg = $value3; 
                        }
                    }
                    if ($X>=0 AND $X<15 AND $Y>=0 AND $Y<15)
                    {
                        $plateau[15-1-$Y][$X]=$msg;
                    }
                }
            }  
        }
        
        
        return $plateau;
    }

   
}

?>
