<?php

namespace Matchappen;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessToken extends Model
{
    use SoftDeletes;
}
