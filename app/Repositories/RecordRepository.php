<?php

namespace App\Repositories;
use App\Interfaces\ResourceInterface;
use \Illuminate\Http\Request;


class RecordRepository implements ResourceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function index(Request $request)
    {

    }
    public function show(string $uuid)
    {

    }
    public function search(Request $request)
    {

    }
    public function store(Request $request)
    {

    }
    public function update(Request $request, string $uuid)
    {

    }
    public function destroy(string $uuid)
    {

    }
}
