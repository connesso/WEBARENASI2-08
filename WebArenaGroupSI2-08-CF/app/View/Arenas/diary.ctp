<?php $this->assign('title', 'diary');?>

<?php
    echo '<section class="center">';
    foreach ($raw as $value)
    {
        
        echo '<div class="event">';
        echo($value['Event']['name']);
        echo($value['Event']['date']);
        echo($value['Event']['coordinate_x']);
        echo($value['Event']['coordinate_y']);
        echo '</div>';
        
        
    }
    echo'</section>';
?>

