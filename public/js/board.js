    //cards
    const draggables = document.querySelectorAll('.draggable')
    //cards containers in lists
    const containers = document.querySelectorAll('.cards-container')

    let position_in_list_before;
    let position_in_list_after;
    let list_position;

    containers.forEach(container => {
        if (container.querySelectorAll('.draggable').length == 0){
            container.innerHTML = '<div class="empty" style="height: 50px" data-card_list_position="0"></div>';
        }
    })

    //for each card
    draggables.forEach(draggable => {

        // when we move a card
        draggable.addEventListener('dragstart', () => {
            // we add class 'dragging' in moved card
            draggable.classList.add('dragging')
        })

        // when we place a card
        draggable.addEventListener('dragend', () => {

            var card_id = draggable.dataset.card_id;
            // console.log("card id:"+card_id);
            var targetContainer = draggable.parentNode;
            var list_id = targetContainer.dataset.list_id;
            // console.log("list id:"+list_id);
            // console.log("list_position" + list_position);

            // AJAX

            fetch('?ctrl=cards&action=changeCardPosition', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    // POST request 
                    card_id: card_id,
                    list_id: list_id,
                    list_position: list_position})
                })
                .then(res => res.text())
                .then(text => {
                // when the fetch is successful
                    console.log(text)
                })
                .catch(error => {
                // when there is an error (ex. error toast)
                console.log(error)
 
            })

           //for each cards container in list
            containers.forEach(container => {

                if (container.querySelectorAll('.draggable').length != 0){
                    let empties = document.querySelectorAll('.empty');
                    empties.forEach(empty => {
                        empty.remove();
                    })
                }

            })

            containers.forEach(container => {

                if (container.querySelectorAll('.draggable').length == 0){
                    container.innerHTML = '<div class="empty" style="height: 50px" data-card_list_position="0"></div>';
                }
            })

            // we remove class 'dragging' in placed card
            draggable.classList.remove('dragging')
        })
    })

    //for each cards container in list
    containers.forEach(container => {

        container.addEventListener('dragover', e => {
            e.preventDefault()
            // the card after the moved card (who will be pleced in container)
            const afterElement = getDragAfterElement(container, e.clientY)
            // moved card
            const draggable = document.querySelector('.dragging')

            // we place a card who we move

            if (afterElement == null) {
                //add a card to the end of container
                container.appendChild(draggable)
                
            } else {
                //insert a moved card before card who must be after it
                container.insertBefore(draggable, afterElement)
            }

            const beforeElement = draggable.previousElementSibling;

            if (beforeElement !== null){
                position_in_list_before = Number(beforeElement.dataset.card_list_position);
            } else {
                position_in_list_before = 0;
            }

            if (afterElement !== undefined){
                position_in_list_after = Number(afterElement.dataset.card_list_position);
                list_position = Math.trunc((position_in_list_after-position_in_list_before)/2)+position_in_list_before;

            } else {
                list_position = position_in_list_before+10000;
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