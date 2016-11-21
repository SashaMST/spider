<?php
/**
 * @var array $logData
 */
?>
<h3>Отчет:</h3>
<div>
    <?php foreach ($logData as $logMessage) { ?>
        <div>
            <?= $logMessage ?>
        </div>
    <?php } ?>
</div>