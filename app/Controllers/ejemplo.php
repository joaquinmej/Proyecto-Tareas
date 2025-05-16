<?php

namespace App\Controllers;

class Ejemplo extends BaseController
{
    public function index(): string
    {
        return view('ejemplo');
    }
}
