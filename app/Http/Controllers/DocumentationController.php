<?php

namespace App\Http\Controllers;

use App\Models\Documentation;

class DocumentationController extends Controller
{
    public function show()
    {
        $manual = Documentation::manual();
        return view('documentation.manual', compact('manual'));
    }
}