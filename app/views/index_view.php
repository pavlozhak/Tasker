<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@Tasker</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="dist/css/app.css" type="text/css">

</head>
<body>
<div class="container">
    <div class="row page-header">
        <div class="col">
            <h1 class="display-4">@Tasker</h1>
        </div>
        <div class="col">
            <a class="btn btn-primary float-right" href="#" id="addNewTaskButton" role="button">Добавить новую задачу</a>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="row task-list-header">
                <div class="col">
                    <p>
                        Список задач
                    </p>
                </div>
                <div class="col-2">
                    <p>
                        Статус
                    </p>
                </div>
            </div>

            <hr class="task-list-header-divider">

            <div class="row">
                <div class="col" id="taskListContainer">

                </div>
            </div>

            <div class="row task-list-footer">
                <div class="col">
                    <nav>
                        <ul class="pagination" id="paginationContainer">

                        </ul>
                    </nav>
                </div>
                <div class="col-4">
                    Сортировка по  <a href="" class="taskSortByButton" sortField="user" invertDirection="false">Имени</a> | <a href="" class="taskSortByButton" sortField="email" invertDirection="false">E-mail</a> | <a href="" class="taskSortByButton" sortField="status" invertDirection="false">Статусу</a>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <a href="" id="adminLogInModalBtn">Вход для администратора</a>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- Task add Modal -->
<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Добавить новую задачу</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                    <div class="row collapse" id="task-add-message-box">
                        <div class="col">
                            <div class="alert alert-danger" role="alert">
                                Вы не заполнили все поля
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="InputUserName">Имя пользователя</label>
                        <input type="text" class="form-control" id="InputUserName" placeholder="Имя пользователя">
                    </div>
                    <div class="form-group">
                        <label for="InputUserEmail">Email</label>
                        <input type="email" class="form-control" id="InputUserEmail" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="InputTaskText">Текст задачи</label>
                        <textarea class="form-control" id="InputTaskText"></textarea>
                    </div>
                    <div class="form-group">
                        <form action="" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-8">
                                    <input type="file" class="form-control" name="file" id="file" />
                                </div>
                                <div class="col">
                                    <button type="submit" class="btn btn-primary mb-2 form-control">Загрузить</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="row task-card collapse">
                        <div class="col">
                            <h6>#1 <a href="" id="task-preview-user"></a> ( <a href="" id="task-preview-email"></a> )</h6>
                            <p id="task-preview-text">Donec porttitor est dolor, nec cursus massa scelerisque eget. Aenean convallis metus magna, ac blandit odio pharetra ac. Donec tincidunt varius tellus, eget suscipit lorem placerat in. Donec a lorem mauris. Vestibulum viverra augue nec magna dapibus ullamcorper. Phasellus arcu mi, finibus eu tellus vitae, ullamcorper accumsan urna. Nullam nec rhoncus neque. Cras nec nunc cursus, fermentum diam id, condimentum massa.</p>
                        </div>
                        <div class="col-2 task-card-status">
                            <span class="badge badge-info">Новая!</span>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" id="task-add-preview">Предварительный просмотр</button>
                <button type="button" class="btn btn-primary" id="task-add-button">Добавить задачу</button>
            </div>
        </div>
    </div>
</div>

<!-- Log In Modal -->
<div class="modal fade" id="AdminLogInModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Вход для администратора</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row collapse" id="login-message-box">
                    <div class="col">
                        <div class="alert alert-danger" role="alert">

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputAdminLogin">Имя пользователя</label>
                    <input type="text" class="form-control" id="InputAdminLogin" placeholder="Имя пользователя">
                </div>
                <div class="form-group">
                    <label for="InputAdminPassword">Пароль</label>
                    <input type="password" class="form-control" id="InputAdminPassword" placeholder="Пароль">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="adminLogInButton">Войти</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Task Modal -->
<div class="modal fade" id="EditTaskModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Редактирование</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row collapse" id="login-message-box">
                    <div class="col">
                        <div class="alert alert-danger" role="alert">

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="InputTaskText">Текст задачи</label>
                    <textarea class="form-control" id="InputTaskTextEdit"></textarea>
                </div>
                <div class="form-check collapse" id="completeCheckBox">
                    <input class="form-check-input" type="checkbox" value="Complete" id="CompleteCheck">
                    <label class="form-check-label" for="CompleteCheck">
                        Отметить как выполненное
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="saveTaskButton" task-id="">Сохранить</button>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
<script src="dist/js/app.js"></script>

</body>
</html>