<?php $this->assign('title', 'character');?>

<?php
echo $this->Form->create('Newfighter');
echo $this->Form->input('Nom', array('type' => 'text'));
echo $this->Form->end("Creer un nouveau joueur");


echo $this->Form->create('SelectFighter');
echo $this->Form->input('id',array('options' => $available_Fighter, 'default' => 'east'));
echo $this->Form->end('Choisir');

pr($available_Fighter);

?>