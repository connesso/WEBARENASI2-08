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
        ?>
    </div>
    <table id="Arenne">
        <?php echo $this->Html->tableCells($plateau);?>
    </table>

    <div id="info_perso">
        <div id="menu">
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

