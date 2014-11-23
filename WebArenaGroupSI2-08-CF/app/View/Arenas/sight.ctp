<?php $this->assign('title', 'sight');?>

<?php pr($raw); ?>

<?php
echo $this->Form->create('Fightermove');
echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->end('Move');

echo $this->Form->create('Figherattack');
echo $this->Form->input('direction',array('options' => array('north'=>'north','east'=>'east','south'=>'south','west'=>'west'), 'default' => 'east'));
echo $this->Form->end('Attack');

?>