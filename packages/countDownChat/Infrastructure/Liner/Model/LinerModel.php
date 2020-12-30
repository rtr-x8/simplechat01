<?php

namespace CountDownChat\Infrastructure\Liner\Model;

use CountDownChat\Domain\Liner\Liner;
use CountDownChat\Domain\Liner\LinerId;
use CountDownChat\Domain\Liner\LinerSourceType;
use Database\Factories\LinerModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinerModel extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $keyType = 'string';
    protected $table = "liners";
    protected $primaryKey = 'liner_id';

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

    protected static function newFactory()
    {
        return LinerModelFactory::new();
    }

    public function toDomain(): Liner
    {
        $liner = new Liner(LinerId::of($this->liner_id));
        return $liner
            ->setIsActive($this->is_active)
            ->setLinerSourceType(LinerSourceType::fromValue($this->source_type))
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
