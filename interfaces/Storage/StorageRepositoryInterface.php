<?php

namespace interfaces\Storage;

use models\Storage;

interface StorageRepositoryInterface
{

    public function getOne($book_id): Storage;
    public function getStock($book_id);
    public function getAll($params = null);
    public function create($book_id, $stock);
    public function update($book_id, $stock);
    public function delete($book_id);
}
