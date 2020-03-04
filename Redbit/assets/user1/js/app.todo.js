$(function() {
   /*
   -------------------------------------------------
      To-Do App 
   -------------------------------------------------
   */
   var dt = new Date();
   var time = dt.getHours() + ":" + dt.getMinutes();
   var date = ((dt.getMonth() + 1) + '/' + dt.getDate() + '/' + dt.getFullYear());
   var currentDate = (date + ' - ' + time);

   var todo =      $('.todo-app');
   var todoList =  $('.todo-app .row');
   var todoItem =  $('.todo-item');
   var todoTitle = $('#todo-title');
   var todoText =  $('#todo-text');

   // To-Do New item 
   function addTodoItem() {
       if (todoTitle.filter(function() {
               return $(this).val();
           }).length > 0) {
           todoList.find('.todo-new').after(' \
                <div class="col-md-3"> \
                    <div class="todo-item">\
                        <div class="todo-title">'+ todoTitle.val() + '</div> \
                        <div class="todo-date"><i class="far fa-clock mr-5 fs-10"></i><span>' + currentDate + '</span></div>\
                        <div class="todo-text">' + todoText.val() + '</div>\
                        <div class="todo-user">\
                        <div class="todo-img-list"> \
                        <div class="avatar avatar-xs"><img src="./assets/images/avatar1.jpg" alt="..." class="img-responsive"></div></div>\
                        </div>\
                        <div class="todo-actions">\
                            <a href="#" class="todo-item-complete" data-toggle="tooltip" title="Complete"><i class="far fa-check-circle"></i></a>\
                            <a href="#" class="todo-item-delete" data-toggle="tooltip" title="Delete"><i class="far fa-trash-alt"></i></a>\
                            <a href="#" class="todo-item-favorite" data-toggle="tooltip" title="Favorite"><i class="far fa-star"></i></a>\
                        </div>\
                    </div>\
                </div> \
            ');
           todoTitle.val("");
           todoText.val("");
           $('#todo-new').modal('hide');

           setTimeout(function() {
               $('.todo-list-item').removeClass('todo-item-new');
           }, 3000);
       } else {
           alert('Please enter a title.');

       }
   }

   // To-Do Item Delete
   function deleteTodoItem(e, item) {
       e.preventDefault();
       $(item).parent().parent().parent().fadeOut('slow', function() {
           $(item).parent().hide();
       })
   }

   // To-Do Item Complete 
   function completeTodoItem(e) {
       e.preventDefault();
       $(this).parent().parent().toggleClass('todo-item-completed')
   }

   // To-Do Item Favorite 
   function favoriteTodoItem(e) {
        e.preventDefault();
       $(this).parent().parent().toggleClass('todo-item-favorited')
   }

   $(function() {
       $("#add-todo-item").on('click', function(e) {
           e.preventDefault();
           addTodoItem()
       });

       todoList.on('click', '.todo-item-delete', function(e) {
           var item = this;
           deleteTodoItem(e, item)
       });

       $(document).on('click', ".todo-item-complete", completeTodoItem);
       $(document).on('click', ".todo-item-favorite", favoriteTodoItem);
   });
});