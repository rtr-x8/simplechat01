<?php


namespace CountDownChat\Domain\Deadline;


use Carbon\Carbon;
use CountDownChat\Domain\Day\DaysComparer;
use CountDownChat\Domain\Liner\LinerId;

class Deadline
{
    private DeadlineId $deadlineId;
    private DeadlineName $name;
    private DeadlineDescription $description;
    private Carbon $deadlineAt;
    private LinerId $linerId;
    private bool $isActive;
    private bool $isComplete;

    /**
     * Deadline constructor.
     * @param  DeadlineId  $deadlineId
     */
    public function __construct(DeadlineId $deadlineId)
    {
        $this->deadlineId = $deadlineId;
    }

    /**
     * @return DeadlineId
     */
    public function getDeadlineId(): DeadlineId
    {
        return $this->deadlineId;
    }

    /**
     * @return DeadlineName
     */
    public function getName(): DeadlineName
    {
        return $this->name;
    }

    /**
     * @param  DeadlineName  $name
     * @return Deadline
     */
    public function setName(DeadlineName $name): Deadline
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return DeadlineDescription
     */
    public function getDescription(): DeadlineDescription
    {
        return $this->description;
    }

    /**
     * @param  DeadlineDescription  $description
     * @return Deadline
     */
    public function setDescription(DeadlineDescription $description): Deadline
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getDeadlineAt(): Carbon
    {
        return $this->deadlineAt;
    }

    /**
     * @param  Carbon  $deadlineAt
     * @return Deadline
     */
    public function setDeadlineAt(Carbon $deadlineAt): Deadline
    {
        $this->deadlineAt = $deadlineAt;
        return $this;
    }

    /**
     * @return LinerId
     */
    public function getLinerId(): LinerId
    {
        return $this->linerId;
    }

    /**
     * @param  LinerId  $linerId
     * @return Deadline
     */
    public function setLinerId(LinerId $linerId): Deadline
    {
        $this->linerId = $linerId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isActive(): bool
    {
        return $this->isActive;
    }

    /**
     * @param  bool  $isActive
     * @return Deadline
     */
    public function setIsActive(bool $isActive): Deadline
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return bool
     */
    public function isComplete(): bool
    {
        return $this->isComplete;
    }

    /**
     * @param  bool  $isComplete
     * @return Deadline
     */
    public function setIsComplete(bool $isComplete): Deadline
    {
        $this->isComplete = $isComplete;
        return $this;
    }

    /**
     * アクティブかつ、未完了かつ、未来日の時通知可能
     *
     * @return bool
     */
    public function isNotifiable(): bool
    {
        return
            $this->isActive()
            && !$this->isComplete()
            && !DaysComparer::new(today(), $this->getDeadlineAt())->isExpired();
    }
}
