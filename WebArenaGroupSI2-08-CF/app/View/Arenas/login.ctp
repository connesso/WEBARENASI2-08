<?php $this->assign('title', 'login');?>

<div class ='contenu'>
<section class='left'>
   
    
        
<?php 
if ($this->Session->read('Connected')!= null)
{ 
   echo '<h1>Deconnexion</h1>';
   echo $this->Form->create('Deconnexion');
   echo 'Etes vous sur de vouloir vous déconnecter?';
   echo $this->Form->input('Email', array('type' => 'email'));
   echo $this->Form->end("Se deconnecter");
   

   

}
else
{
    echo '<h1>Connexion</h1>';
    echo $this->Form->create('Connexion');
echo $this->Form->input('Email', array('type' => 'email'));
echo $this->Form->input('Mot de passe', array('type' => 'password'));
echo $this->Form->end("Se connecter");

echo ("Vous avez perdu votre mot de passe ?");
echo $this->Form->create('Lostpassword');
echo $this->Form->input('Email', array('type' => 'email'));
echo $this->Form->end("Récupérer mon mot de passe");
echo'</section>';




 ?>

        
</section>

<section class='right'>
    <h1>Inscription</h1>
<?php

echo $this->Form->create('Inscription');
echo $this->Form->input('Email', array('type' => 'email'));
echo $this->Form->input('Mot de passe', array('type' => 'password'));
echo $this->Form->end("Creer un nouveau compte");

}?>
    <h1>Se connecter avec Facebook</h1>
    <a href="<?php echo $this->Html->url(array('action' => 'facebook')); ?>" class="facebookConnect"> Se connecter avec Facebook </a>
</section>    

</div>



<?php
//pr($raw);
//pr($test);
?>


