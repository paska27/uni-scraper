<?php
namespace UnisKeywordSearch;

define('APP_ROOT_PATH', __DIR__ . '/');
define('APP_JOB_PATH', APP_ROOT_PATH . '/job/');
define('MASTER_EXPORT_DIR', APP_JOB_PATH . 'master-export/');
define('JOB_EXPORT_DIR', APP_JOB_PATH . '[job_name]/export/');

$app = new UniScraper(APP_ROOT_PATH);
$app->runJobs();