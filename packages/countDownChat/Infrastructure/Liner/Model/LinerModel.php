<?php

namespace CountDownChat\Infrastructure\Liner\Model;

use Illuminate\Database\Eloquent\Model;

class LinerModel extends Model
{
    // use HasFactory;

    public $incrementing = false;
    public $keyType = 'string';
    protected $table = "liners";
    protected $primaryKey = 'liners_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'liner_id',
        'source_type',
        'provided_liner_id',
        'is_active',
    ];
}
