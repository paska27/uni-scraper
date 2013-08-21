<?php

define('UNIS_SAMPLE_ROOT_PATH', __DIR__);

$unis = new UniScraper(UNIS_SAMPLE_ROOT_PATH);
$unis->run();