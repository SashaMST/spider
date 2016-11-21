<?php
/**
 * @var array $taskModel
 */
?>
<table class="table table-hover">
    <thead>
    <tr>
        <td>
            Текущий шаблон
        </td>
        <td>
            Путь поиска
        </td>
        <td>
            Количество воркеров
        </td>
        <td>
            Статус выполнения
        </td>
        <td>
            Действия
        </td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($taskModel as $taskItem) { ?>
        <tr>
            <td>
                <?= $taskItem['pattern'] ?>
            </td>
            <td>
                <?= $taskItem['path'] ?>
            </td>
            <td>
                <?= $taskItem['worker'] ?>
            </td>
            <td>
                <?= \App\Task::getTaskStatus($taskItem['status']) ?>
            </td>
            <td>
                <form method="post" class="start">
                    <label for="newWorker"> Изменить количество воркеров:
                        <input name="newWorker">
                    </label>
                    <input type="hidden" name="action" value="startTask">
                    <input type="hidden" name="taskId" value="<?= $taskItem['id'] ?>">
                    <input type="submit" value="Запустить">
                </form>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>