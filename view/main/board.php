<?php
use App\Core\Session;

$board = $data['board'];
$lists = $data['lists'];
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
        <div class="cards-container">
            <?php
                foreach($list->getCards() as $card){
            ?>     
                <div draggable="true" class=" draggable uk-card uk-card-default uk-margin">
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
                                    <form action="?ctrl=cards&action=editCard" method="post">
                                        <div class="uk-margin uk-flex">
                                            <textarea class="uk-input" type="text" name="content" id="content" required><?= $card->getContent() ?></textarea>
                                            <input type="hidden" name="card_id" value="<?= $card->getId() ?>">
                                            <input type="hidden" name="csrf_token" value="<?= $csrf_token ?>">
                                            <input class="uk-button uk-button-secondary uk-margin-right uk-margin-left"  type="submit" name="submit" value="Ok">
                                        </div> 
                                    </form>
                                    <hr>
                                
                                    <ul class="uk-nav uk-dropdown-nav uk-margin-left">
                                        <li><a href="#">Ajouter la discreption</a></li>
                                        <li><a href="#">Modifier un membre</a></li>
                                        <li><a href="#">Couleur de la carte</a></li>                                  
                                    </ul>                       
                                
                                </div>
                                
                                

                            </div>


                        </div>

                        <p><?=  $card->getContent() ?></p>
                    </div>
                    <!-- disctiontion  -->
                    <!-- <div class="uk-card-footer">                       
                    </div> -->
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

<script>
    const draggables = document.querySelectorAll('.draggable')
    const containers = document.querySelectorAll('.cards-container')

    draggables.forEach(draggable => {
        draggable.addEventListener('dragstart', () => {
            draggable.classList.add('dragging')
        })

        draggable.addEventListener('dragend', () => {
            draggable.classList.remove('dragging')
        })
    })

    containers.forEach(container => {
        container.addEventListener('dragover', e => {
            e.preventDefault()
            const afterElement = getDragAfterElement(container, e.clientY)
            const draggable = document.querySelector('.dragging')
            if (afterElement == null) {
                container.appendChild(draggable)
            } else {
                container.insertBefore(draggable, afterElement)
            }
        })
    })

    function getDragAfterElement(container, y) {
        const draggableElements = [...container.querySelectorAll('.draggable:not(.dragging)')]

        return draggableElements.reduce((closest, child) => {
            const box = child.getBoundingClientRect()
            const offset = y - box.top - box.height / 2
            if (offset < 0 && offset > closest.offset) {
                return { offset: offset, element: child }
            } else {
                return closest
            }
        }, { offset: Number.NEGATIVE_INFINITY }).element
    }
</script>