<?php $this->assign('title', 'character');?>

<?php
echo $this->Form->create('Newfighter');
echo $this->Form->input('Nom', array('type' => 'text'));
echo $this->Form->end("Creer un nouveau joueur");
?>