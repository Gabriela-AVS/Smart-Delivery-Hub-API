<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model
{
    protected $fillable = ['service_name', 'endpoint', 'request_payload', 'response_payload', 'status_code'];
}
