<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
    
	<title>
                <?php  echo $title_for_layout ?>
                
	</title>
    <script src="http://code.jquery.com/jquery.js"></script>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('webarena');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
    
    <div id="fb-root"></div>
   
	<div id="container"> 
            
		<div id="header">
                    <h1>Projet WebArena</h1>    
		</div>
                <nav>
                        <?php 
                        $valeur;
                        if($this->Session->read('Connected') == null)
                        {
                            $valeur='Connexion';   
                        }
                        else 
                            {$valeur='Deconnexion';}
                        ?>
                    
                        <div class="button"><?php echo $this->Html->link('Acceuil', array('controller' => 'Arenas', 'action' => '/')); ?></div>
                        <div class="button"><?php echo $this->Html->link($valeur, array('controller' => 'Arenas', 'action' => 'login')); ?></div>
                        <div class="button"><?php echo $this->Html->link('Combat', array('controller' => 'Arenas', 'action' => 'sight')); ?></div>
                        
                        
                        <div class="button"><?php echo $this->Html->link('Personnage', array('controller' => 'Arenas', 'action' => 'character')); ?></div>
                        <div class="button"><?php echo $this->Html->link('Journal', array('controller' => 'Arenas', 'action' => 'diary')); ?></div>
                        
                </nav>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content') ;?>
		</div>
		<div id="footer">
                    
                    <p>WebArenaGoupSI2-08-CF</p>
                    
                    <p>Brunel Vivien Connesson Rémi Grondin Lionel</p>
                    <p> Nos options : <br>
                    
                        A - Gestion avancé des combatants et de leurs équipements<br>
                        C - Gestion de la limite temporel ( 10s)<br>
                        G - Utlisation d'une connexion externe Facebook<br>
                    </p>
                      
                        
                    
                    <p><a href = "https://docs.google.com/document/d/1lA-iU6TGZCiYtuwtMvjqqAeuIUpU5vdfRisRhGf6TrU/edit?usp=sharing">Notre fichier Git</a></p>
                    
                    <p>
				<?php echo $cakeVersion; ?>
		    </p>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); ?>
</body>
<?php echo $this->Html->script('facebook'); ?>


</html>
