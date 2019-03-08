<?php

$endTime = (int) $this->params['deadlineTimestamp'];

$this->addJs(__DIR__.'/script.js');
$this->addJs('https://code.jquery.com/jquery-3.3.1.min.js');

?>
<div class="timer jsTimer" data-end='<?= $endTime ?>'>
	<?= date('d.m.Y H:i:s') ?>
</div>
