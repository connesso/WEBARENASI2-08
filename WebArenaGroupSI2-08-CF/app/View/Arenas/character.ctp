<?php $this->assign('title', 'character');?>
<div class='contenu'>
<section class='left'>
    <h1>Création de personnage</h1>
<?php
echo $this->Form->create('Newfighter',array('type'=>'file'));
echo $this->Form->input('avatar_file',array('type'=>'file','label'=>'choisir votre avatar :'));
echo $this->Form->input('Nom', array('type' => 'text'));
echo $this->Form->end("Creer un nouveau joueur");
?>
</section>

<section class='right'>
    <h1>Choix du personnage</h1>
<?php
echo $this->Form->create('SelectFighter');
echo $this->Form->input('id',array('options' => $available_Fighter, 'default' => 'Vous devez creer des personnages'));
echo $this->Form->end('Choisir');

pr($available_Fighter);

?>
</section>
</div>