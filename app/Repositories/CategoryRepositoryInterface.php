<?php

namespace App\Repositories;

use Illuminate\Http\Request;

interface CategoryRepositoryInterface
{
    public function addCategory();
    public function addToCategory(Request $request);
    public function show($id);
    public function delete($id);
}
