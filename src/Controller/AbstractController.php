<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

abstract class AbstractController
{
    abstract public static function index(Request $request) ;

    abstract public function show(Request $request , int $id) ;

    abstract public function save(Request $request);

    abstract public function update(Request $request , int $id);

    abstract public function destroy(int $id);
}