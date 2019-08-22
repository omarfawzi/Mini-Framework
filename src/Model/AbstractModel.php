<?php

namespace App\Model;

use App\DB;
use Exception;
use PDO;

abstract class AbstractModel
{
    /** @var PDO $db */
    protected $db;

    /**
     * AbstractModel constructor.
     *
     * @throws Exception
     */
    public function __construct()
    {
        DB::getInstance()->init();
        $this->db = DB::getInstance()->getConnection();
    }

    public function save(AbstractModel $model)
    {

    }

    public function update(AbstractModel $model)
    {

    }

    public function destroy(AbstractModel $model)
    {

    }
}