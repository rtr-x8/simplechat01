<?php


namespace CountDownChat\Domain\Liner;


class Liner
{
    private LinerId $linerId;
    private LinerSourceType $linerSourceType;
    private string $providerLinerId;
    private bool $isActive;

    /**
     * Liner constructor.
     * @param  LinerId  $linerId
     */
    public function __construct(LinerId $linerId)
    {
        $this->linerId = $linerId;
    }

    /**
     * @return LinerId
     */
    public function getLinerId(): LinerId
    {
        return $this->linerId;
    }

    /**
     * @return LinerSourceType
     */
    public function getLinerSourceType(): LinerSourceType
    {
        return $this->linerSourceType;
    }

    /**
     * @param  LinerSourceType  $linerSourceType
     */
    public function setLinerSourceType(LinerSourceType $linerSourceType): Liner
    {
        $this->linerSourceType = $linerSourceType;
        return $this;
    }

    /**
     * @return string
     */
    public function getProviderLinerId(): string
    {
        return $this->providerLinerId;
    }

    /**
     * @param  string  $providerLinerId
     */
    public function setProviderLinerId(string $providerLinerId): Liner
    {
        $this->providerLinerId = $providerLinerId;
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
     */
    public function setIsActive(bool $isActive): Liner
    {
        $this->isActive = $isActive;
        return $this;
    }


}
