<?php
use App\Core\Session;

$board = $data['board'];
$lists = $data['lists'];
$colors = $data['colors'];
?>
<style>
    .draggable {
        cursor: move;
    }

    .draggable.dragging {
    opacity: .5;
    }
</style>


<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">
        <h1 class="uk-margin-left"><?=  $board ?></h1>
    </div>

    <!-- PARTICIPANTS -->

    <div class="uk-navbar-right">
        <div class="uk-inline">
        <?php
            foreach($board->getParticipants() as $participant){
        ?> 
            <!-- participant icons -->
            <button class="uk-button uk-button-default uk-border-circle uk-margin-right" type="button">
                <div><?= $participant->getFirstLetter() ?></div>
            </button>
            <!-- participant details -->
            <div uk-drop="mode: click">
                <div class="uk-card uk-card-body uk-card-default">
                    <div><?= $participant->getEmail() ?></div>
                    <div><?= $participant ?></div>
                    <div>
                    <?php
                        //check if the participant is the board admin
                        if($participant->getId() == $board->getUser()->getId()){
                    ?>
                        Gestionnaire
                    <?php
                        //check that the logged in user is participant (and not board admin)
                        } else if($participant->getId() == Session::get("user")->getId()) { 
                    ?>  
                        <div> 
                            <!-- board leave button with an anchor toggling the modal -->            
                            <a class="uk-button uk-button-default" href="#modal-leave-board-<?=  $participant->getId() ?>" uk-toggle>Quitter le boardau</a>           
                        </div>
                        <!-- board leave confirm (modal) -->
                        <div id="modal-leave-board-<?= $participant->getId() ?>" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                <div>Est-ce que vous êtes sûr de vouloir quitter le tableau "<?= $board ?>" ?</div>
                                <div class="uk-margin-top">
                                    <a class="uk-button uk-button-secondary uk-margin-right uk-margin-left" href="?ctrl=main&action=leaveboard&id=<?= $board->getId() ?>">Quitter le boardau</a> 
                                    <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                                </div>  
                            </div>
                        </div>  
                    <?php
                        //check that the logged in user is board admin (and not participant)
                        }else if(Session::get("user")->getId() == $board->getUser()->getId()){
                    ?>
                        <div> 
                            <!-- delete participant button with an anchor toggling the modal -->            
                            <a class="uk-button uk-button-default" href="#modal-delete-participant-<?=  $participant->getId() ?>" uk-toggle>Supprimer le participant</a>           
                        </div>
                        <!-- delete participant confirm (modal) -->
                        <div id="modal-delete-participant-<?= $participant->getId() ?>" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                <div>Est-ce que vous êtes sûr de vouloir virer participant de "<?= $board ?>" ?</div>
                                <div class="uk-margin-top">
                                    <form action="?ctrl=main&action=delParticipant" method="post">
                                        <div class="uk-margin-top">
                                            <input type="hidden" name="board_id" value="<?= $board->getId() ?>">
                                            <input type="hidden" name="user_id" value="<?= $participant->getId() ?>">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Supprimer participant">
                                            <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                                        </div>  
                                    </form>
                                </div>  
                            </div>
                        </div>  
                    <?php
                        }
                    ?>                    
                    </div>
                </div>
            </div>
        <?php
            }
        ?>
        </div>

        <!-- INVITATION CREATION -->

        <?php
            //check if the logged in user is the board admin
            if(Session::get("user")->getId() == $board->getUser()->getId()){
        ?>
            <!-- invitation button with an anchor toggling the modal --> 
            <div>                
                <a class="uk-button uk-button-default uk-margin-right" href="#modal-invite-participant" uk-toggle>Inviter un participant</a>           
            </div>

            <!-- invitation form (modal) -->
            <div id="modal-invite-participant" uk-modal>
                <div class="uk-modal-dialog uk-modal-body">
                    <button class="uk-modal-close-default" type="button" uk-close></button>
                    <h2 class="uk-modal-title uk-text-center">Invitation d'un participant dans le tableau "<?= $board->getTitle() ?>"</h2>
                    <form action="?ctrl=main&action=createInvitation" method="post">
                        <div>
                            <label for="mail">Email : </label><br>
                            <input class="uk-input uk-form-width-large" type="email" name="email" id="mail" placeholder="Entrez l'email d'utilisateur à inviter" required>
                        </div>
                        <div class="uk-margin-top">
                            <input type="hidden" name="board_id" value="<?= $board->getId() ?>">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Appliquer">
                            <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                        </div>  
                    </form>
                </div>
            </div>
        <?php
            }
        ?> 

    </div>

</nav>


<!-- LISTS -->

<div class="uk-flex uk-margin">

<?php
    foreach($lists as $list){
?>   
    <div class="uk-background-muted uk-padding uk-panel uk-margin-right">
        <div>
            <h2 class="uk-h4 uk-text-center"><?=  $list ?></h2>
            <div class="uk-position-top-right">

                <!-- DELETE LIST -->
                
                <!-- list delete button with an anchor toggling the modal -->            
                <a href="#modal-delete-list-<?= $list->getId() ?>" class="uk-icon-link" uk-icon="trash" uk-toggle></a>           
            
                <!-- list delete confirm (modal) -->
                <div id="modal-delete-list-<?= $list->getId() ?>" uk-modal>
                    <div class="uk-modal-dialog uk-modal-body">
                        <button class="uk-modal-close-default" type="button" uk-close></button>
                        <div>Est-ce que vous êtes sûr de vouloir supprimer la liste "<?= $list ?>" ?</div>
                        <div class="uk-margin-top">
                            <a class="uk-button uk-button-secondary uk-margin-right uk-margin-left" href="?ctrl=lists&action=delList&id=<?= $list->getId() ?>">Supprimer</a> 
                            <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                        </div>  
                    </div>
                </div>

                <!-- EDIT LIST -->
        
                <!-- list edit button with an anchor toggling the modal -->            
                <a href="#modal-edit-list-<?= $list->getId() ?>" class="uk-icon-link" uk-icon="file-edit" uk-toggle></a>           
            
                <!-- list edit confirm (modal) -->
                <div id="modal-edit-list-<?= $list->getId() ?>" uk-modal>                    
                    <div class="uk-modal-dialog uk-modal-body">
                        <button class="uk-modal-close-default" type="button" uk-close></button>
                        <h2 class="uk-modal-title">Edition de la liste</h2>
                        <form action="?ctrl=lists&action=editList" method="post">
                            <div class="uk-margin uk-flex">
                                <input class="uk-input" type="text" name="title" id="title" value="<?= $list ?>" required>
                                <input type="hidden" name="list_id" value="<?= $list->getId() ?>">
                                <input type="hidden" name="board_id" value="<?= $list->getBoard()->getId() ?>">
                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Ok">
                            </div>  
                        </form>
                    </div>
                </div>
            </div>
        </div>
            
        <!-- CARDS IN LIST -->

        <!-- cards container in the list, attribute "data-list-id" is list id where container is located -->
        <div data-list_id="<?= $list->getId() ?>" class="cards-container">
            <?php
                foreach($list->getCards() as $card){
            ?>  

                <!-- CARD IN THE LIST -->

                <div draggable="true" data-card_id="<?= $card->getId() ?>" data-card_list_position="<?= $card->getList_position() ?>" class=" draggable uk-card uk-card-default uk-margin" style="background-color:<?= $card->getColor()->getColor_code() ?>">
                    <div class="uk-card-body">
                        <div class="uk-position-top-right">

                            <!-- DELETE CARD -->
                        
                            <!-- card delete button with an anchor toggling the modal -->            
                            <a href="#modal-delete-card-<?= $card->getId() ?>" class="uk-icon-link" uk-icon="trash" uk-toggle></a>           
                    
                            <!-- card delete confirm (modal) -->
                            <div id="modal-delete-card-<?= $card->getId() ?>" uk-modal>
                                <div class="uk-modal-dialog uk-modal-body">
                                    <button class="uk-modal-close-default" type="button" uk-close></button>
                                    <div>Est-ce que vous êtes sûr de vouloir supprimer la carte?</div>
                                    <div class="uk-margin-top">
                                        <a class="uk-button uk-button-secondary uk-margin-right uk-margin-left" href="?ctrl=cards&action=delCard&id=<?= $card->getId() ?>">Supprimer</a> 
                                        <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                                    </div>  
                                </div>
                            </div>

                            <!-- EDIT CARD -->
            
                            <!-- card edit button with an anchor toggling the modal -->            
                            <a href="#modal-edit-card-<?= $card->getId() ?>" class="uk-icon-link" uk-icon="file-edit" uk-toggle></a>           
                        
                            <!-- card edit confirm (modal) -->
                            <div id="modal-edit-card-<?= $card->getId() ?>" uk-modal>                    
                                <div class="uk-modal-dialog uk-modal-body">
                                    <button class="uk-modal-close-default" type="button" uk-close></button>
                                    <h2 class="uk-modal-title">Edition de la carte</h2>
                                    <form action="?ctrl=cards&action=editCardContent" method="post">
                                        <div class="uk-margin uk-flex">
                                            <textarea class="uk-input" type="text" name="content" id="content" required><?= $card->getContent() ?></textarea>
                                            <input type="hidden" name="card_id" value="<?= $card->getId() ?>">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Ok">
                                        </div> 
                                    </form>

                                    <!-- ACCORDION -->

                                    <ul uk-accordion>
                                
                                        <!-- EDIT CARD DESCRIPTION -->

                                        <li>
                                            <a class="uk-accordion-title" href="#">Ajouter la discreption</a>
                                            <div class="uk-accordion-content">
                                                <form action="?ctrl=cards&action=editCardDescription" method="post">
                                                    <div class="uk-margin uk-flex">
                                                        <textarea class="uk-input" type="text" name="description" id="description" required><?= $card->getDescription() ?></textarea>
                                                        <input type="hidden" name="card_id" value="<?= $card->getId() ?>">
                                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                                        <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Ok">
                                                    </div> 
                                                </form>
                                            </div>
                                        </li>

                                        <!-- EDIT MARK -->

                                        <li>
                                            <a class="uk-accordion-title" href="#">Modifier un membre</a>
                                            <div class="uk-accordion-content">
                                                
                                            <table class='uk-table uk-table-hover uk-table-divider'>
                                                <tbody>
                                                <?php
                                                    foreach($board->getParticipants() as $participant){
                                                ?>       
                                                    <tr>
                                                        <!-- participant icons -->
                                                        <td>      
                                                            <div class="uk-button uk-button-default uk-border-circle uk-margin-right"><?= $participant->getFirstLetter() ?></div>
                                                        </td>
                                                        <td><?= $participant->getEmail() ?></td>
                                                        <td>
                                                        <?php
                                                            $isMark = false;
                                                            foreach($card->getMarks() as $mark){
                                                                if($mark->getId() == $participant->getId()){
                                                                    $isMark = true;
                                                                } 
                                                            }
                                                        ?>
                                                        <?php
                                                            //check if participant is mark user
                                                            if($isMark){
                                                        ?>

                                                            <!-- DELETE MARK -->
                                                            <form action="?ctrl=cards&action=delMark" method="post">
                                                                <input type="hidden" name="mark_user_id" value="<?= $participant->getId()  ?>">
                                                                <input type="hidden" name="card_id" value="<?= $card->getId() ?>">
                                                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                                                <input class=""  type="submit" name="submit" value="Supprimer le membre">                              
                                                            </form>

                                                        <?php
                                                            } else { 
                                                        ?>  
                                                            <!-- ADD MARK -->
                                                            <form action="?ctrl=cards&action=addMark" method="post">
                                                                <input type="hidden" name="mark_user_id" value="<?= $participant->getId() ?>">
                                                                <input type="hidden" name="card_id" value="<?= $card->getId() ?>">
                                                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                                                <input class=""  type="submit" name="submit" value="Ajouter le membre">                              
                                                            </form>
                                                        <?php
                                                            }
                                                        ?> 
                                                        </td>
                                                    </tr>
                                                    <?php
                                                        }
                                                    ?>
                                                </tbody>
                                            </table>

                                            </div>
                                        </li>

                                        <!-- EDIT CARD COLOR -->

                                        <li>
                                            <a class="uk-accordion-title" href="#">Couleur de la carte</a>
                                            <div class="uk-accordion-content">

                                                <form action="?ctrl=cards&action=editCardColor" method="post">

                                                <?php
                                                    foreach($colors as $color){
                                                ?> 
                                                    <div class="uk-margin">
                                                        <div class="uk-flex uk-flex-middle uk-margin-small-bottom">
                                                            <div style="background-color:<?= $color->getColor_code() ?>; height:40px " class="uk-width-expand@m uk-margin-right"></div>
                                                            <div class="uk-flex"> 
                                                                <input class="uk-checkbox" type="radio" name="color_id" value="<?= $color->getId() ?>" <?php if($color->getId()==$card->getColor()->getId()) {echo 'checked';} ?>>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php
                                                    }
                                                ?>                                                    
                                                    <input type="hidden" name="card_id" value="<?= $card->getId() ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                                    <input class="uk-button uk-button-default uk-margin-right uk-margin-left"  type="submit" name="submit" value="Appliquer la couleur">                              
                                                </form>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- CARD CONTENT -->

                        <div>
                            <?=  $card->getContent() ?>
                        </div>
                    </div>
                    
                    <!-- CARD DESCRIPTION AND MARK USER -->

                    <div class="uk-flex uk-child-width-expand">
                                                            
                        <?php
                            //for card with description
                            if($card->getDescription()){
                        ?>
                            <!-- description button -->
              
                            <button uk-toggle="target: #toggle-<?= $card->getId() ?>" class="uk-button uk-button-default uk-button-small" type="button">Description</button>   
                                                                           
                        <?php
                            }
                        ?>
                        <!-- mark user -->
                        <div class="uk-flex uk-flex-right">

                        <?php
                            foreach($card->getMarks() as $mark){
                        ?>                          
                            <div class="uk-badge uk-margin-small-right"><?= $mark->getFirstLetter() ?></div>
                        <?php
                            }
                        ?>    
                        </div>

                    </div>
                     <!-- description -->
                    <div id="toggle-<?= $card->getId() ?>" class="uk-padding-small">
                        <?=  $card->getDescription() ?>
                    </div> 
                </div>
            <?php
                }
            ?>
        </div>

        <!-- CARD CREATION -->

        <div> 
            <!-- card create button with an anchor toggling the modal -->            
            <a class="uk-button uk-button-default uk-margin-right" href="#modal-create-card-<?=  $list->getId() ?>" uk-toggle>Ajouter une carte</a>           
        </div>
        <!-- card create form (modal) -->
        <div id="modal-create-card-<?=  $list->getId() ?>" uk-modal>
            <div class="uk-modal-dialog uk-modal-body">
                <button class="uk-modal-close-default" type="button" uk-close></button>
                <h2 class="uk-modal-title">Nouvelle carte</h2>
                <form action="?ctrl=cards&action=addCard" method="post">
                    <div class="uk-margin">
                        <label for="content">Contenue de carte : </label><br>
                        <textarea class="uk-input" type="text" name="content" id="content" required></textarea>
                    </div>
                    <div class="uk-margin-top">
                        <input type="hidden" name="list_id" value="<?= $list->getId() ?>">
                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                        <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Appliquer">
                        <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                    </div>  
                </form>
            </div>
        </div>
        
    </div>
<?php
    }
?>

    <!-- LIST CREATION -->

    <div> 
        <!-- list create button with an anchor toggling the modal -->            
        <a class="uk-button uk-button-secondary uk-margin-right" href="#modal-create-list" uk-toggle>Créer une liste</a>           
    </div>

    <!-- list create form (modal) -->
    <div id="modal-create-list" uk-modal>
        <div class="uk-modal-dialog uk-modal-body">
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <h2 class="uk-modal-title">Nouvelle liste</h2>
            <form action="?ctrl=lists&action=addList" method="post">
                <div class="uk-margin">
                    <label for="title">Titre de liste : </label><br>
                    <input class="uk-input" type="text" name="title" id="title" required>
                </div>
                <div class="uk-margin-top">
                    <input type="hidden" name="board_id" value="<?= $board->getId() ?>">
                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                    <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Appliquer">
                    <a class="uk-button uk-button-secondary uk-modal-close">Annuler</a>
                </div>  
            </form>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= JS_PATH ?>/board.js"></script>