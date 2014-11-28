<?php $this->assign('title', 'login');?>



<?php 
if ($this->Session->read('Connected')!= null)
{
   echo $this->Form->create('Deconnexion');
   echo 'Etes vous sur de vouloir vous déconnecter?';
   echo $this->Form->input('Email', array('type' => 'email'));
   echo $this->Form->end("Se deconnecter");
}
else
{
echo $this->Form->create('Inscription');
echo $this->Form->input('Email', array('type' => 'email'));
echo $this->Form->input('Mot de passe', array('type' => 'password'));
echo $this->Form->end("Creer un nouveau compte");

echo $this->Form->create('Connexion');
echo $this->Form->input('Email', array('type' => 'email'));
echo $this->Form->input('Mot de passe', array('type' => 'password'));
echo $this->Form->end("Se connecter");

echo ("Vous avez perdu votre mot de passe ?");
echo $this->Form->create('Lostpassword');
echo $this->Form->input('Email', array('type' => 'email'));
echo $this->Form->end("Récupérer mon mot de passe");
}

pr($raw);
pr($test);
?>

