<?php

namespace CountDownChat\Infrastructure\Liner\Model;

use CountDownChat\Domain\Liner\Liner;
use CountDownChat\Domain\Liner\LinerId;
use CountDownChat\Domain\Liner\LinerSourceType;
use Database\Factories\LinerModelFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * CountDownChat\Infrastructure\Liner\Model\LinerModel
 *
 * @property string $liner_id
 * @property integer $source_type 1:ユーザー,2:グループ,3:トークルーム
 * @property string $provided_liner_id
 * @property integer $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static Builder|LinerModel newModelQuery()
 * @method static Builder|LinerModel newQuery()
 * @method static Builder|LinerModel query()
 * @method static Builder|LinerModel whereCreatedAt($value)
 * @method static Builder|LinerModel whereIsActive($value)
 * @method static Builder|LinerModel whereLinerId($value)
 * @method static Builder|LinerModel whereProvidedLinerId($value)
 * @method static Builder|LinerModel whereSourceType($value)
 * @method static Builder|LinerModel whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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

    protected $casts = [
        'source_type' => 'int',
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
