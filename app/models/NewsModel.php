<?php

namespace App\Models;

use PDO;

class NewsModel extends BaseModel
{
    protected $table = 'news';

    public function __construct()
    {
        parent::__construct();
    }
}
