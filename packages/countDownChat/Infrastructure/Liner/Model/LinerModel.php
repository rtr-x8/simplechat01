<?php

namespace CountDownChat\Infrastructure\Liner\Model;

use CountDownChat\Domain\Liner\Liner;
use CountDownChat\Domain\Liner\LinerId;
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

    public function toDomain(): Liner
    {
        $liner = new Liner(LinerId::of($this->getKey()));
        return $liner
            ->setIsActive($this->is_active)
            ->setLinerSourceType($this->source_type)
            ->setProviderLinerId($this->provided_liner_id);
    }

    public function fillDomein(Liner $liner): LinerModel
    {
        $this->liner_id = $liner->getLinerId();
        $this->source_type = $liner->getLinerSourceType()->value;
        $this->provided_liner_id = $liner->getProviderLinerId();
        $this->is_active = $liner->isActive();

        return $this;
    }

    public static function fromDomain(Liner $liner): LinerModel
    {
        $linerModel = new LinerModel();
        $linerModel->fillDomein($liner);
        return $linerModel;
    }
}
