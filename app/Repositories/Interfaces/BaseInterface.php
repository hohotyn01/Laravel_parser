<?php
    namespace App\Repositories\Interfaces;

    use Illuminate\Database\Eloquent\Model;

    interface BaseInterface
    {
        public function find(int $id);

        public function create(array $data);

//        public function setModel(Model $model);
    }
