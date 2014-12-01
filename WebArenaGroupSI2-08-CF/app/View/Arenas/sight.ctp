<?php $this->assign('title', 'sight');?>
<div id="fenetre">
    <div id="commande">
        <?php
            echo $this->Form->create('Fightermove');
            echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
            echo $this->Form->end('Move');

            echo $this->Form->create('Figherattack');
            echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
            echo $this->Form->end('Attack');
            
            echo $this->Form->create('Figherramasse');
            echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
            echo $this->Form->end('Ramasser');
            
        ?>
    </div>
    
    <?php
    
        
        
        if($fighter_id==0)
        {
            echo '<div class ="Arenne">';
            echo 'Vous devez choisir un personnage';
            echo '</div>';
        }
        else
        {
            echo '<table class="Arenne">';
            //echo $this->Html->tableCells($plateau); 
            for ($i=0;$i<15;$i++)
            {
                echo '<tr>';
                for ($j=0;$j<15;$j++)
                {
                    
                    echo '<td>';
                    
                    if($plateau[$i][$j]=='B')
                    {
                            $image = "../img/Arenne/Black.png";
                        echo '<img class = "logo"src="'. $image .'">';
                    }
                    elseif ($plateau[$i][$j]==$fighter_id)//Notre fighter
                    {
                        $image = "../img/Avatar/{$fighter_id}.png";
                        echo '<img class = "logo"src="'. $image .'">';
                    }
                    elseif ($plateau[$i][$j]==' ')//vue vide
                    {
                        $image = "../img/Arenne/White.png";
                        echo '<img class = "logo"src="'. $image .'">';
                    }
                    elseif ($plateau[$i][$j]=='L')//objet Vie
                    {
                        $image = "../img/Arenne/Vie.png";
                        echo '<img class = "logo"src="'. $image .'">';
                    }
                    elseif ($plateau[$i][$j]=='F')//Objet Force
                    {
                        $image = "../img/Arenne/Force.png";
                        echo '<img class = "logo"src="'. $image .'">';
                    }
                    elseif ($plateau[$i][$j]==' ')//Objet Vue
                    {
                        $image = "../img/Arenne/Vue.png";
                        echo '<img class = "logo"src="'. $image .'">';
                    }
                    
                    else
                    {
                        $image = "../img/Avatar/{$plateau[$i][$j]}.png";
                        echo '<img class = "logo"src="'. $image .'">';
                    }
                        

                    if($plateau[$i][$j])
                    {
                        
                    }
                    echo '</td>';
                    
                }
                echo '</tr>';
            }
            echo '</table>';
        }
        
   
    ?>
    <div id="info_perso">
        <div id="menu">
            
            <?php 
            $image = "../img/Avatar/{$fighter_id}.png";
             echo '<img class = "avatar"src="'. $image .'">'; 
            ;?>
            
            <!--<img src="../img/Avatar/89.png">-->
            <p>vie : <?php echo $vie ?></p>
            
            <p>force : <?php echo $force ?></p>
            <p>level : <?php echo $level ?></p>
            <p>vue : <?php echo $vue ?></p>
            <p>xp : <?php echo $xp ?></p>
            <?php
            echo $this->Form->create('Stat');
            echo $this->Form->input('stat',array('options' => array('hearth'=>'vie','strength'=>'force','sight'=>'vue'), 'default' => 'vue'));
            echo $this->Form->end('Augmenter cette stat');
            ?>
            
           
        </div>


    </div>
    
</div>

