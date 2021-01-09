<?php


namespace CountDownChat\Domain\Deadline;


use Carbon\Carbon;
use CountDownChat\Domain\Liner\LinerId;

class Deadline
{
    private DeadlineId $deadlineId;
    private DeadlineName $deadlineName;
    private DeadlineDescription $deadlineDescription;
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
    public function getDeadlineName(): DeadlineName
    {
        return $this->deadlineName;
    }

    /**
     * @param  DeadlineName  $deadlineName
     * @return Deadline
     */
    public function setDeadlineName(DeadlineName $deadlineName): Deadline
    {
        $this->deadlineName = $deadlineName;
        return $this;
    }

    /**
     * @return DeadlineDescription
     */
    public function getDeadlineDescription(): DeadlineDescription
    {
        return $this->deadlineDescription;
    }

    /**
     * @param  DeadlineDescription  $deadlineDescription
     * @return Deadline
     */
    public function setDeadlineDescription(DeadlineDescription $deadlineDescription): Deadline
    {
        $this->deadlineDescription = $deadlineDescription;
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
}
