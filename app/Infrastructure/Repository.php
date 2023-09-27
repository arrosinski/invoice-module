<?php

namespace App\Infrastructure;

use Illuminate\Support\Facades\DB;

class Repository
{
    protected string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
    }

    public function get(string $id): object
    {
        return DB::table($this->table)->where('id', $id)->first();
    }

    public function getAll(): array
    {
        return DB::table($this->table)->get()->toArray();
    }

    public function create(object $object): int
    {
        return DB::table($this->table)->insertGetId($object);
    }

    public function update(object $object): int
    {
        return DB::table($this->table)->where('id', $object->id)->update($object);
    }
}
