<?php

namespace App;

class Application
{
    /**
     * @var array
     */
    public $instances = [];

    /**
     * Application constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        foreach ($config as $alias => $instance) {
            $this->instances[$alias] = $instance['class']::init($instance);
        }
    }

    public function run()
    {
        if (isset($_POST['action'])) {
            switch ($_POST['action']) {
                case 'addTask':
                    (new Task($this->instances['db']))->addTask($_POST);
                    break;
                case 'startTask':
                    $taskModel = (new Task($this->instances['db']))->findById($_POST['taskId']);
                    if (isset($_POST['newWorker'])) {
                        $taskModel[0]['worker'] = $_POST['newWorker'];
                    }
                    $logData = (new SpiderWorker($taskModel))->run();
                    (new Task($this->instances['db']))->updateStatus($taskModel);
                    break;
            }
        }

        $taskModel = (new Task($this->instances['db']))->findAll();

        require "template/template.php";
    }
}
