<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TargetApiController extends Controller
{
public function show($id)
{
    $target = collect($this->getData())->firstWhere('id', (int) $id);
    if (!$target) return $this->notFound('Target tidak ditemukan.');
    return $this->success($target);
}
}
