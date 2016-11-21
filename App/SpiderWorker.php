<?php

namespace App;

class SpiderWorker
{
    private $workerCount;
    private $path;
    private $pattern;
    private $fileCount;
    private $markedFileArray = [];

    /**
     * SpiderWorker constructor.
     * @param array $taskModel
     */
    public function __construct(array $taskModel)
    {
        $this->workerCount = $taskModel[0]['worker'];
        $this->path = $taskModel[0]['path'];
        $this->pattern = $taskModel[0]['pattern'];
    }

    /**
     * @return array
     */
    public function run()
    {
        try {
            $findObject = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($this->path));
        } catch (\UnexpectedValueException $e) {
            echo $e->getMessage();
            die();
        }
        foreach ($findObject as $objectItem) {
            if ($objectItem->isFile() && preg_match(DIRECTORY_SEPARATOR.$this->pattern.DIRECTORY_SEPARATOR,
                    $objectItem->getFilename())
            ) {
                ++$this->fileCount;
                $this->markedFileArray[] = $objectItem;
            }
        }

        return $this->processHandle();
    }

    /**
     * @return array
     */
    private function processHandle()
    {
        for ($threadCount = 0; $threadCount < $this->workerCount; $threadCount++) {

            $pid = pcntl_fork();
            if ($pid < 0) {
                echo "Не удалось создать воркера";
                die();
            }
            if ($pid === 0) {
                posix_kill(getmypid(), 9);
            }
        }
        $logData = [];

        /* @var \SplFileInfo $itemDelete */
        foreach ($this->markedFileArray as $itemDelete) {
            if (file_exists($itemDelete->getRealPath())) {
                $logData[] = 'Удалили файл '.$itemDelete->getRealPath();
                unlink($itemDelete->getRealPath());

            }
        }

        return $logData;
    }
}
