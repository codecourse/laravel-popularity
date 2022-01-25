<?php

namespace Codecourse\LaravelPopularity\Tests\Models;

use Codecourse\LaravelPopularity\Traits\Visitable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    use Visitable;
}
