<?php
/**
 * Created by PhpStorm.
 * User: yanling
 * Date: 1/18/21
 * Time: 3:28 PM
 */

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function getCreatedAtAttribute($created_at)
    {
        return Carbon::parse($created_at)->toDateTimeString();
    }
}