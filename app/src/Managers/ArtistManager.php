<?php

namespace App\Managers;

use App\Lib\Managers\AbstractManager;

class ArtistManager extends AbstractManager {
    public function findByIdSuperiorTo(int $id) {
        return $this->queryBuilder()
            ->select()
            ->from()
            ->where('id', self::CONDITIONS['gt'])
            ->addParam('id', $id)
            ->executeQuery()
            ->getAllResults();
    }
}