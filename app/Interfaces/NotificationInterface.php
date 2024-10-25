<?php

namespace App\Interfaces\Interfaces;
use \Illuminate\Http\Request;


interface NotificationInterface
{
    public function index(Request $request);
    public function show(string $uuid);
    public function search(Request $request);
    public function store(Request $request);
    public function update(Request $request, string $uuid);
}
