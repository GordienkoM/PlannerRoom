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

<div class="board-page">
    <div class="board-container">
        <nav class="board-container-nav" uk-navbar>
            <div class="uk-navbar-left">
                <h1><?=  $board ?></h1>
            </div>

            <!-- PARTICIPANTS -->

            <div class="uk-navbar-right">
                <div class="uk-inline">
                <?php
                    // array of colors the participant icons
                    $color_code = ['#EB6CAF','#39E380', '#FBE344', '#2D9FF8'];
                    // participant number
                    $n = 0;
                    foreach($board->getParticipants() as $participant){
                        // color number for a participant
                        $i = $n % 4;
                        $n++;                
                ?> 
                    <!-- participant icons -->
                    <button class="participant-button uk-button" type="button" style="background-color:<?= $color_code[$i] ?>">
                        <div class="first-letter-participant"><?= $participant->getFirstLetter() ?></div>
                    </button>
                    <!-- participant details -->
                    <div uk-drop="mode: click">
                        <div class="div-participant-details uk-card uk-card-body uk-card-default">
                            <div class="div-participant-details-email"><?= $participant->getEmail() ?></div>
                            <div class="div-participant-details-nickname"><?= $participant ?></div>
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
                                    <a class="button-to-leave-board" href="#modal-leave-board-<?=  $participant->getId() ?>" uk-toggle>Quitter le tableau</a>           
                                </div>
                                <!-- board leave confirm (modal) -->
                                <div id="modal-leave-board-<?= $participant->getId() ?>" uk-modal>
                                    <div class="leave-board-confirm uk-modal-dialog uk-modal-body">
                                        <button class="uk-modal-close-default" type="button" uk-close></button>
                                        <div class="modal-text-delete-list">Etes-vous sûr de vouloir quitter le tableau "<?= $board ?>" ?</div>
                                        <div class="uk-margin-top">
                                            <a class="button-to-confirm-leave-board" href="?ctrl=main&action=leaveboard&id=<?= $board->getId() ?>">Quitter le tableau</a> 
                                            <a class="uk-modal-close">Annuler</a>
                                        </div>  
                                    </div>
                                </div>  
                            <?php
                                //check that the logged in user is board admin (and not participant)
                                }else if(Session::get("user")->getId() == $board->getUser()->getId()){
                            ?>
                                <div> 
                                    <!-- delete participant button with an anchor toggling the modal -->            
                                    <a class="button-to-delete-participant" href="#modal-delete-participant-<?=  $participant->getId() ?>" uk-toggle>Supprimer le participant</a>           
                                </div>
                                <!-- delete participant confirm (modal) -->
                                <div id="modal-delete-participant-<?= $participant->getId() ?>" uk-modal>
                                    <div class="delete-participant-confirm uk-modal-dialog uk-modal-body">
                                        <button class="uk-modal-close-default" type="button" uk-close></button>
                                        <div class="modal-text-delete-list">Etes-vous sûr de vouloir supprimer le participant de "<?= $board ?>" ?</div>
                                        <div class="uk-margin-top">
                                            <form action="?ctrl=main&action=delParticipant" method="post">
                                                <div class="uk-margin-top">
                                                    <input type="hidden" name="board_id" value="<?= $board->getId() ?>">
                                                    <input type="hidden" name="user_id" value="<?= $participant->getId() ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                                    <input class="input-to-confirm-delete-participant"  type="submit" name="submit" value="Supprimer participant">
                                                    <a class="uk-modal-close">Annuler</a>
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
                        <a class="button-invite-participant" href="#modal-invite-participant" uk-toggle>Inviter un participant</a>           
                    </div>

                    <!-- invitation form (modal) -->
                    <div id="modal-invite-participant" uk-modal>
                        <div class="invite-participant-confirm uk-modal-dialog uk-modal-body">
                            <button class="uk-modal-close-default" type="button" uk-close></button>
                            <h2 class="uk-modal-title uk-text-center">Invitation d'un participant dans le tableau "<?= $board->getTitle() ?>"</h2>
                            <form action="?ctrl=main&action=createInvitation" method="post">
                                <div>
                                    <label for="mail">Email : </label>
                                    <input class="uk-input uk-form-width-large" type="email" name="email" id="mail" placeholder="Entrez l'email d'utilisateur à inviter" required>
                                </div>
                                <div class="uk-margin-top">
                                    <input type="hidden" name="board_id" value="<?= $board->getId() ?>">
                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                    <input type="submit" name="submit" value="Appliquer">
                                    <a class="uk-modal-close">Annuler</a>
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

        <div class="lists-container">

        <?php
            foreach($lists as $list){
        ?>   
            <div class="element-of-list-container list-element-of-list-container uk-panel">
                <div class="div-title-of-list">
                    <h2 class="title-of-list uk-text-center"><?=  $list ?></h2>
                    <div class="div-delete-and-edit-list uk-position-top-right">

                        <!-- DELETE LIST -->
                        
                        <!-- list delete button with an anchor toggling the modal -->            
                        <a href="#modal-delete-list-<?= $list->getId() ?>" class="list-delete-button-and-edit-button uk-icon-link" uk-icon="trash" uk-toggle></a>           
                    
                        <!-- list delete confirm (modal) -->
                        <div id="modal-delete-list-<?= $list->getId() ?>" uk-modal>
                            <div class="uk-modal-dialog uk-modal-body">
                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                <div class="modal-text-delete-list">Etes-vous sûr de vouloir supprimer la liste "<?= $list ?>" ?</div>
                                <div class="uk-margin-top">
                                    <a class="button-confirm-delete-list" href="?ctrl=lists&action=delList&id=<?= $list->getId() ?>">Supprimer</a> 
                                    <a class="uk-modal-close">Annuler</a>
                                </div>  
                            </div>
                        </div>

                        <!-- EDIT LIST -->
                
                        <!-- list edit button with an anchor toggling the modal -->            
                        <a href="#modal-edit-list-<?= $list->getId() ?>" class="list-delete-button-and-edit-button uk-icon-link" uk-icon="file-edit" uk-toggle></a>           
                    
                        <!-- list edit confirm (modal) -->
                        <div id="modal-edit-list-<?= $list->getId() ?>" uk-modal>                    
                            <div class="uk-modal-dialog uk-modal-body">
                                <button class="uk-modal-close-default" type="button" uk-close></button>
                                <h2 class="uk-modal-title">Edition de la liste</h2>
                                <form action="?ctrl=lists&action=editList" method="post">
                                    <div class="uk-margin">
                                        <input class="uk-input" type="text" name="title" id="title" value="<?= $list ?>" required>
                                        <input type="hidden" name="list_id" value="<?= $list->getId() ?>">
                                        <input type="hidden" name="board_id" value="<?= $list->getBoard()->getId() ?>">
                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                        <input class="input-confirm-edit-list"  type="submit" name="submit" value="Ok">
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

                        <div draggable="true" data-card_id="<?= $card->getId() ?>" data-card_list_position="<?= $card->getList_position() ?>" class="div-card draggable uk-card" style="background-color:<?= $card->getColor()->getColor_code() ?>">
                            <div class="title-of-card-div">
                                <div class="div-delete-and-edit-card uk-position-top-right">

                                    <!-- DELETE CARD -->
                                
                                    <!-- card delete button with an anchor toggling the modal -->            
                                    <a href="#modal-delete-card-<?= $card->getId() ?>" class="card-delete-button-and-edit-button uk-icon-link" uk-icon="trash" uk-toggle></a>           
                            
                                    <!-- card delete confirm (modal) -->
                                    <div id="modal-delete-card-<?= $card->getId() ?>" uk-modal>
                                        <div class="uk-modal-dialog uk-modal-body">
                                            <button class="uk-modal-close-default" type="button" uk-close></button>
                                            <div class="modal-text-delete-card">Etes-vous sûr de vouloir supprimer la carte?</div>
                                            <div class="uk-margin-top">
                                                <a class="button-confirm-delete-card" href="?ctrl=cards&action=delCard&id=<?= $card->getId() ?>">Supprimer</a> 
                                                <a class="uk-modal-close">Annuler</a>
                                            </div>  
                                        </div>
                                    </div>

                                    <!-- EDIT CARD -->
                    
                                    <!-- card edit button with an anchor toggling the modal -->            
                                    <a href="#modal-edit-card-<?= $card->getId() ?>" class="card-delete-button-and-edit-button uk-icon-link" uk-icon="file-edit" uk-toggle></a>           
                                
                                    <!-- card edit confirm (modal) -->
                                    <div id="modal-edit-card-<?= $card->getId() ?>" uk-modal>                    
                                        <div class="div-modal-edit-card uk-modal-dialog uk-modal-body">
                                            <button class="uk-modal-close-default" type="button" uk-close></button>
                                            <h2 class="modal-h2-edit-card">Edition de la carte</h2>
                                            <form action="?ctrl=cards&action=editCardContent" method="post">
                                                <div class="modal-div-edit-card uk-margin">
                                                    <textarea class="uk-input" type="text" name="content" id="content" required><?= $card->getContent() ?></textarea>
                                                    <input type="hidden" name="card_id" value="<?= $card->getId() ?>">
                                                    <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                                    <input class="input-confirm-edit-card"  type="submit" name="submit" value="Ok">
                                                </div> 
                                            </form>

                                            <!-- ACCORDION -->

                                            <ul class="ul-accordion" uk-accordion>
                                        
                                                <!-- EDIT CARD DESCRIPTION -->

                                                <li>
                                                    <a class="uk-accordion-title" href="#">Ajouter la description</a>
                                                    <div class="uk-accordion-content">
                                                        <form action="?ctrl=cards&action=editCardDescription" method="post">
                                                            <div class="uk-margin uk-flex">
                                                                <textarea class="uk-input" type="text" name="description" id="description" required><?= $card->getDescription() ?></textarea>
                                                                <input type="hidden" name="card_id" value="<?= $card->getId() ?>">
                                                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                                                <input class="input-confirm-add-description"  type="submit" name="submit" value="Ok">
                                                            </div> 
                                                        </form>
                                                    </div>
                                                </li>

                                                <!-- EDIT MARK -->

                                                <li class="li-edit-mark">
                                                    <a class="uk-accordion-title" href="#">Modifier un membre</a>
                                                    <div class="uk-accordion-content">
                                                        
                                                    <table class='uk-table uk-table-divider'>
                                                        <tbody>
                                                        <?php
                                                            $c = 0;
                                                            foreach($board->getParticipants() as $participant){
                                                                $i = $c % 4;
                                                                $c++; 
                                                        ?>       
                                                            <tr>
                                                                <!-- participant icons -->
                                                                <td class="participant-icon" style="background-color:<?= $color_code[$i] ?>">      
                                                                    <div class="edit-card-participant-first-letter"><?= $participant->getFirstLetter() ?></div>
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
                                                                        <input class="modal-edit-card-delete-member"  type="submit" name="submit" value="Supprimer le membre">                              
                                                                    </form>

                                                                <?php
                                                                    } else { 
                                                                ?>  
                                                                    <!-- ADD MARK -->
                                                                    <form action="?ctrl=cards&action=addMark" method="post">
                                                                        <input type="hidden" name="mark_user_id" value="<?= $participant->getId() ?>">
                                                                        <input type="hidden" name="card_id" value="<?= $card->getId() ?>">
                                                                        <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                                                        <input class="modal-edit-card-add-member"  type="submit" name="submit" value="Ajouter le membre">                              
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

                                                <li class="li-edit-card-color">
                                                    <a class="uk-accordion-title" href="#">Couleur de la carte</a>
                                                    <div class="div-edit-card-color uk-accordion-content">

                                                        <form action="?ctrl=cards&action=editCardColor" method="post">
                                                            <div class="form-div-colors">

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
                                                            </div>
                                                            <div class="form-div-confirm-color">
                                                                <input type="hidden" name="card_id" value="<?= $card->getId() ?>">
                                                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                                                <input type="submit" name="submit" value="Appliquer la couleur">
                                                            </div>                              
                                                        </form>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- CARD CONTENT -->

                                <div class="title-card-content">
                                    <?=  nl2br($card->getContent()) ?>
                                </div>
                            </div>
                            
                            <!-- CARD DESCRIPTION AND MARK USER -->

                            <div class="card-description-and-mark-user">
                                                                    
                                <?php
                                    //for card with description
                                    if($card->getDescription()){
                                ?>
                                    <!-- description button -->
                      
                                    <button uk-toggle="target: #toggle-<?= $card->getId() ?>" class="description-button-card" type="button">Description</button>   
                                                                                   
                                <?php
                                    }
                                ?>
                                <!-- mark user -->
                                <div class="div-card-all-marks-users">

                                <?php
                                    $m = 0;
                                    foreach($card->getMarks() as $mark){
                                        $i = $m % 4;
                                        $m++; 
                                ?>                          
                                    <div class="mark-user-on-card" style="background-color:<?= $color_code[$i] ?>"><span><?= $mark->getFirstLetter() ?></span></div>
                                <?php
                                    }
                                ?>    
                                </div>

                            </div>
                             <!-- description -->
                            <div id="toggle-<?= $card->getId() ?>" class="text-description-of-card">
                                <?=  nl2br($card->getDescription()) ?>
                            </div> 
                        </div>
                    <?php
                        }
                    ?>
                </div>

                <!-- CARD CREATION -->

                <div class="add-card-button-div"> 
                    <!-- card create button with an anchor toggling the modal -->            
                    <a class="add-card-button" href="#modal-create-card-<?=  $list->getId() ?>" uk-toggle><img class="add-card-icon" src="public/images/planner_room_add_card_board_icon_50x50.png" alt="icone d'ajout d'une carte">Ajouter une carte</a>           
                </div>
                <!-- card create form (modal) -->
                <div id="modal-create-card-<?=  $list->getId() ?>" uk-modal>
                    <div class="modal-div-new-card uk-modal-dialog uk-modal-body">
                        <button class="uk-modal-close-default" type="button" uk-close></button>
                        <h2 class="uk-modal-title">Nouvelle carte</h2>
                        <form class="form-new-card" action="?ctrl=cards&action=addCard" method="post">
                            <div class="uk-margin">
                                <label for="content">Contenu de la carte : </label>
                                <textarea class="uk-input" type="text" name="content" id="content" required></textarea>
                            </div>
                            <div class="div-confirm-or-cancel">
                                <input type="hidden" name="list_id" value="<?= $list->getId() ?>">
                                <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                <input type="submit" name="submit" value="Appliquer">
                                <a class="uk-modal-close">Annuler</a>
                            </div>  
                        </form>
                    </div>
                </div>
                
            </div>
        <?php
            }
        ?>

            <!-- LIST CREATION -->

            <div class="div-button-to-create-list element-of-list-container"> 
                <!-- list create button with an anchor toggling the modal -->            
                <a class="button-to-create-list uk-button" href="#modal-create-list" uk-toggle><img class="add-list-icon" src="public/images/planner_room_add_list_board_icon_50x50.png" alt="icone d'ajout d'une liste">Créer une liste</a>           
            </div>

            <!-- list create form (modal) -->
            <div id="modal-create-list" uk-modal>
                <div class="modal-div-new-list uk-modal-dialog uk-modal-body">
                    <button class="uk-modal-close-default" type="button" uk-close></button>
                    <h2 class="uk-modal-title">Nouvelle liste</h2>
                    <form class="form-new-list" action="?ctrl=lists&action=addList" method="post">
                        <div class="uk-margin">
                            <label for="title">Titre de liste : </label>
                            <input class="uk-input" type="text" name="title" id="title" required>
                        </div>
                        <div class="div-confirm-or-cancel">
                            <input type="hidden" name="board_id" value="<?= $board->getId() ?>">
                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                            <input type="submit" name="submit" value="Appliquer">
                            <a class="uk-modal-close">Annuler</a>
                        </div>  
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= JS_PATH ?>/board.js"></script>