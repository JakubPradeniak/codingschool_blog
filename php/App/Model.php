<?php

declare(strict_types=1);

namespace App;

use PDO;

class Model
{
    public function __construct(protected PDO $connection)
    {
    }
}
