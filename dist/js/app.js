$(function () {
    // Global vars
    var currentSortDirection = 'DESC';
    var sortField = 'id';
    // Get tasks list
    function getTaskList(take, offset, sort, sortDirection) {
        $.ajax({
            url: '/Main/getTasks',
            type: 'POST',
            data: {
                take: take,
                offset: offset,
                sort: sort,
                sortDirection: sortDirection
            }
        }).done(function (tasks) {
            $('div#taskListContainer').html('');
            $.each(tasks, function (i,e) {
                var imageBox = (e.image !== '') ? '<div class="col-2"><img width="100%" src="' + e.image + '" /></div>' : '';
                var status = (e.status === 'new') ? 'Новая!' : 'Выполнено';
                var statusClass = (e.status === 'new') ? 'info' : 'success';
                var editButton = (localStorage.getItem("adminIsLogin") === "true") ? '<p><a href="" id="editTaskButton" task-id="' + e.id + '" task-status="' + e.status + '">Редактировать</a></p>' : '';
                var card = '<div class="row task-card">\n' + imageBox +
                    '                <div class="col">\n' +
                    '                    <h6>#' + e.id + ' <a href="">' + e.user + '</a> ( <a href="">' + e.email + '</a> )</h6>\n' +
                    '                    <p id="taskText">' + e.text + '</p>\n' +
                    editButton +
                    '                </div>\n' +
                    '                <div class="col-2 task-card-status">\n' +
                    '                    <span class="badge badge-' + statusClass + '">' + status + '</span>\n' +
                    '                </div>\n' +
                    '            </div>';
                $('div#taskListContainer').append(card);
            });
        }).fail(function () {
            console.log("Send request failed")
        });
    }

    // On page load get task list
    getTaskList(3, 0, 'id', 'DESC');

    // Pagination
    function pagination() {
        $.ajax({
            url: '/Main/totalTasks',
            type: 'POST',
            data: { status: true }
        }).done(function (response) {
            paginationHandler(response);
        }).fail(function () {
            console.log("Send request failed");
        });
    };

    function paginationHandler(response) {
        var totalRows = response;
        var perPage = 3;
        var offset = 0;
        var pages = (totalRows % perPage === 0) ? Math.floor(totalRows / perPage) : Math.floor(totalRows / perPage) + 1;
        for(var i = 1; i<=pages; i++) {
            var link = '<li class="page-item"><a class="page-link" href="#" page-offset="' + offset + '">' + i + '</a></li>';
            offset += perPage;
            $('ul#paginationContainer').append(link);
        }
    }

    $('ul#paginationContainer').on('click', 'a', function (e) {
        e.preventDefault();
        var offset = $(this).attr('page-offset');
        getTaskList(3, offset, sortField, currentSortDirection);
    });

    pagination();

    // Sorting buttons handlers
    function string2boolean(param) {
        if(param === 'true') {
            return true;
        }
        else {
            return false;
        }
    }
    function invertSortDirection(invert) {
        if(invert) {
            currentSortDirection = 'DESC';
        } else {
            currentSortDirection = 'ASC';
        }
    }

    $('a.taskSortByButton').on('click', function (e) {
        e.preventDefault();
        sortField = $(this).attr('sortField');
        var buttonDirectionValue = string2boolean($(this).attr('invertDirection'));
        invertSortDirection(buttonDirectionValue);
        $(this).attr('invertDirection', !buttonDirectionValue);
        getTaskList(3, 0, sortField, currentSortDirection);
    });

    // Add new task button handler
    $('a#addNewTaskButton').on('click', function (e) {
        e.preventDefault();
        $('#addTaskModal').modal('show');
    });

    // Image Upload
    $('form').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: '/Main/imageUpload',
            type: 'POST',
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false
        }).done(function (data) {
            var image = '<div class="col-2" id="task-preview-image"><img width="100%" src="' + data + '"></div>';
            $('div#addTaskModal div.modal-body div.task-card div#task-preview-image').remove();
            $('div#addTaskModal div.modal-body div.task-card').prepend(image);
        }).fail(function () {
            console.log('Image Upload. Request send fail')
        });
    });

    // Preview
    $('div#addTaskModal button#task-add-preview').on('click', function (e) {
        e.preventDefault();
        var user = $('div#addTaskModal input#InputUserName').val();
        var email = $('div#addTaskModal input#InputUserEmail').val();
        var text = $('div#addTaskModal textarea#InputTaskText').val();

        $('div#addTaskModal div.modal-body div.task-card a#task-preview-user').text(user);
        $('div#addTaskModal div.modal-body div.task-card a#task-preview-email').text(email);
        $('div#addTaskModal div.modal-body div.task-card p#task-preview-text').text(text);

        if($('div#addTaskModal div.modal-body div.task-card').hasClass('collapse'))
        {
            $('div#addTaskModal div.modal-body div.task-card').removeClass('collapse');
        }
        else
        {
            $('div#addTaskModal div.modal-body div.task-card').addClass('collapse');
        }
    });

    // Add new task
    $('div#addTaskModal button#task-add-button').on('click', function (e) {
        e.preventDefault();
        var user = $('div#addTaskModal input#InputUserName').val();
        var email = $('div#addTaskModal input#InputUserEmail').val();
        var text = $('div#addTaskModal textarea#InputTaskText').val();
        var image = $('div#addTaskModal div.modal-body div.task-card div#task-preview-image img').attr('src');

        if(user.length > 0 && email.length > 0 && text.length >0) {
            if(!$('div#task-add-message-box').hasClass('collapse')) { $('div#task-add-message-box').addClass('collapse'); }
            $.ajax({
                url: 'Main/addNewTask',
                type: 'POST',
                data: {
                    user: user,
                    email: email,
                    text: text,
                    image: image
                }
            }).done(function () {
                $('div#addTaskModal').modal('hide');
                getTaskList(3, 0, 'id', 'DESC');
            }).fail(function () {
                console.log('Add new task request fail');
            });
        } else {
            $('div#task-add-message-box').removeClass('collapse');
        }
    });

    // Clean add form after new task added
    $('div#addTaskModal').on('hidden.bs.modal', function () {
        $('div#addTaskModal input#InputUserName').val('');
        $('div#addTaskModal input#InputUserEmail').val('');
        $('div#addTaskModal textarea#InputTaskText').val('');
        $('div#addTaskModal div.modal-body div.task-card div#task-preview-image').remove();
        $('div#addTaskModal div.modal-body form')[0].reset();
        $('div#addTaskModal div.modal-body div.task-card').addClass('collapse');
        $('div#addTaskModal div.modal-body div.task-card a#task-preview-user').text('');
        $('div#addTaskModal div.modal-body div.task-card a#task-preview-email').text('');
        $('div#addTaskModal div.modal-body div.task-card p#task-preview-text').text('');
    });

    // Show log in modal
    $('a#adminLogInModalBtn').on('click', function (e) {
        e.preventDefault();
        $('#AdminLogInModal').modal('show');
    });

    // LogIn handler
    $('#AdminLogInModal button#adminLogInButton').on('click', function (e) {
        e.preventDefault();
        var login = $('#AdminLogInModal input#InputAdminLogin').val();
        var pass = $('#AdminLogInModal input#InputAdminPassword').val();
        if(login.length > 0 && pass.length > 0) {
            if(login === "admin" && pass === "123") {
                localStorage.setItem("adminIsLogin", "true");
                getTaskList(3, 0, sortField, currentSortDirection);
                $('#AdminLogInModal').modal('hide');
            } else {
                $('#AdminLogInModal div#login-message-box div.alert').text('Неправильный логин или пароль');
                $('#AdminLogInModal div#login-message-box').removeClass('collapse');
            }
        } else {
            $('#AdminLogInModal div#login-message-box div.alert').text('Вы не заполнили все поля');
            $('#AdminLogInModal div#login-message-box').removeClass('collapse');
        }
    });

    // Open edit modal
    $('div#taskListContainer').on('click', '#editTaskButton', function (e) {
        e.preventDefault();
        var taskText = $(this).parent().parent().find("#taskText").text();
        var taskId = $(this).attr("task-id");
        var taskStatus = $(this).attr("task-status");
        $('#EditTaskModal textarea#InputTaskTextEdit').val(taskText);
        if(taskStatus === "new") { $('#EditTaskModal div#completeCheckBox').removeClass('collapse'); };
        $('#EditTaskModal button#saveTaskButton').attr('task-id', taskId);
        $('#EditTaskModal').modal('show');
    });

    // Save changes
    $('#EditTaskModal button#saveTaskButton').on('click', function (e) {
        e.preventDefault();
        var taskText = $('#EditTaskModal textarea#InputTaskTextEdit').val();
        var taskId = $(this).attr('task-id');
        var taskStatus = $("#EditTaskModal #CompleteCheck").prop("checked");

        if(taskText.length > 0) {
            if(!$('#EditTaskModal div#login-message-box').hasClass('collapse')) { $('#EditTaskModal div#login-message-box').addClass('collapse'); }
            $.ajax({
                url: 'Main/editTask',
                type: 'POST',
                data: {
                    taskText: taskText,
                    taskId: taskId,
                    taskStatus: taskStatus
                }
            }).done(function () {
                getTaskList(3, 0, sortField, currentSortDirection);
                $('#EditTaskModal').modal('hide');
            }).fail(function () {

            });
        } else {
            $('#EditTaskModal div#login-message-box div.alert').text("Пустой текст задания");
            $('#EditTaskModal div#login-message-box').removeClass('collapse');
        }
    });

    // Clean add form after new task added
    $('div#EditTaskModal').on('hidden.bs.modal', function () {
        $('#EditTaskModal textarea#InputTaskTextEdit').text('');
        if(!$('#EditTaskModal div#completeCheckBox').hasClass('collapse')) {
            $('#EditTaskModal div#completeCheckBox').addClass('collapse');
        }
        $('#EditTaskModal button#saveTaskButton').attr('task-id', '');
        $("#EditTaskModal #CompleteCheck").prop("checked", false);
    });

});