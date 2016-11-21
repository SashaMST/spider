<?php

namespace App;

class Task
{
    const TASK_STATUSES = [
        '0' => 'Ожидает',
        '1' => 'Выполняется',
        '2' => 'Выполнена',
    ];

    /**
     * @var int
     */
    private $defaultTaskStatus = 0;

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @param int $taskStatus
     * @return mixed
     */
    public static function getTaskStatus(int $taskStatus)
    {
        return self::TASK_STATUSES[$taskStatus];
    }

    /**
     * Task constructor.
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $query = 'SELECT * FROM tasks';
        $statement = $this->pdo->prepare($query);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param int $id
     * @return array
     */
    public function findById(int $id)
    {
        $query = 'SELECT * FROM tasks WHERE id = :taskId';
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':taskId', $id);
        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * @param array $task
     * @return bool
     */
    public function addTask(array $task)
    {
        $query = 'INSERT INTO tasks (pattern, path, status, worker) VALUES (:pattern, :path, :status, :worker)';
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':pattern', $task['taskPattern']);
        $statement->bindParam(':path', $task['path']);
        $statement->bindParam(':status', $this->defaultTaskStatus);
        $statement->bindParam(':worker', $task['workerCount']);

        return $statement->execute();
    }

    /**
     * @param array $task
     * @return bool
     */
    public function updateStatus(array $task)
    {
        $query = "UPDATE tasks SET status = 2 WHERE id = :taskId";
        $statement = $this->pdo->prepare($query);
        $statement->bindParam(':taskId', $task[0]['id']);

        return $statement->execute();
    }
}
