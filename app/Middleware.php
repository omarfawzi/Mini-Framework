<?php

namespace App;

use Symfony\Component\HttpFoundation\Request;

interface Middleware
{
    public function handle(Request $request);
}