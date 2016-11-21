<form method="post" class="form">
    <div class="form-group">
        <label for="addTask">Введите шаблон задачи:
            <input name="taskPattern" class="form-control">
        </label>
    </div>
    <div class="form-group">
        <label for="path">Путь поиска
            <input name="path" class="form-control">
        </label>
    </div>
    <div class="form-group">
        <label for="workerCount">Кол-во воркеров:
            <input name="workerCount" class="form-control">
        </label>
    </div>
    <input type="hidden" name="action" value="addTask">
    <input class="button" type="submit" value="Добавить задачу">
</form>