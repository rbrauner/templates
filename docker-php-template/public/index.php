<?php

declare(strict_types=1);

/**
 * Copyright (C) Rafał Brauner
 */

require_once dirname(__DIR__).'/vendor/autoload.php';

use App\App;

$app = new App();
$app->run();
