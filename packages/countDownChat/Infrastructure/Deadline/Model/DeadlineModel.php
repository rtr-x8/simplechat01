<?php

namespace CountDownChat\Infrastructure\Deadline\Model;

use CountDownChat\Domain\Deadline\Deadline;
use CountDownChat\Domain\Deadline\DeadlineDescription;
use CountDownChat\Domain\Deadline\DeadlineId;
use CountDownChat\Domain\Deadline\DeadlineName;
use CountDownChat\Domain\Liner\LinerId;
use Database\Factories\DeadlineModelFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeadlineModel extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $keyType = 'string';
    protected $table = "deadlines";
    protected $primaryKey = 'deadline_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'deadline_id',
        'liner_id',
        'name',
        'description',
        'is_active',
        'is_complete',
        'deadline_at',
    ];

    protected $dates = [
        'deadline_at',
    ];

    public static function fromDomain(Deadline $deadline): DeadlineModel
    {
        $deadlineModel = new DeadlineModel();
        $deadlineModel->fillDomain($deadline);
        return $deadlineModel;
    }

    public function fillDomain(Deadline $deadline): DeadlineModel
    {
        $this->deadline_id = $deadline->getDeadlineId()->value();
        $this->liner_id = $deadline->getLinerId()->value();
        $this->name = $deadline->getName()->value();
        $this->description = $deadline->getDescription()->value();
        $this->is_active = $deadline->isActive();
        $this->is_complete = $deadline->isComplete();
        $this->deadline_at = $deadline->getDeadlineAt();

        return $this;
    }

    protected static function newFactory()
    {
        return DeadlineModelFactory::new();
    }

    public function toDomain(): Deadline
    {
        $deadline = new Deadline(DeadlineId::of($this->getKey()));
        return $deadline
            ->setName(DeadlineName::of($this->name))
            ->setDescription(DeadlineDescription::of($this->description))
            ->setLinerId(LinerId::of($this->liner_id))
            ->setIsActive($this->is_active)
            ->setIsComplete($this->is_complete)
            ->setDeadlineAt($this->deadline_at);
    }
}
