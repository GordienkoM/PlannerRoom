<?php
    use App\Core\Session;
?>
<div>
    <section class="uk-padding-remove">
    <?php 
        if($successMsgs = Session::getFlashes("success")){
            ?>
            
            <div class="uk-alert-success" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <?php
                    foreach($successMsgs as $msg){
                        echo "<h4 class='uk-text-italic'>",$msg,"</h4>";
                    }
                ?>
            </div>
        
            <?php
        }

        if($noticeMsgs = Session::getFlashes("notice")){
            ?>
            
            <div class="uk-alert-warning" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <?php
                    foreach($noticeMsgs as $msg){
                        echo "<h4 class='uk-text-italic'>",$msg,"</h4>";
                    }
                ?>
            </div>
        
            <?php
        }

        if($errorMsgs = Session::getFlashes("error")){
            ?>
            
            <div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <?php
                    foreach($errorMsgs as $msg){
                        echo "<h4 class='uk-text-italic'>", $msg ,"</h4>";
                    }
                ?>
            </div>
            
            <?php
        }
    ?>
    </section>
</div>