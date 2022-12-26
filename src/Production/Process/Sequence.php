<?php declare(strict_types=1);

namespace Myposter\Production\Process;

use Myposter\Production\State\GiftWrapped;
use Myposter\Production\State\StateInterface;

class Sequence
{
    public static array $processSequence = [
    ];

    private ?StateInterface $currentState = null;
    private bool $hasGiftWrapping;

    public function __construct(bool $hasGiftWrapping = false)
    {
        $this->hasGiftWrapping = $hasGiftWrapping;
    }

    public function updateGiftWrapping(bool $hasGiftWrapping = false): void
    {
        $this->hasGiftWrapping = $hasGiftWrapping;
    }

    public function stateExists(StateInterface $state): bool
    {
        return in_array(get_class($state), static::$processSequence);
    }

    public function isValidNextState(StateInterface $state): bool
    {
        if ($this->getCurrentState() === null) {
            return static::$processSequence[0] === get_class($state);
        }
        $currentProcessStateKey = array_search(get_class($this->getCurrentState()), static::$processSequence);
        $nextProcessStep = new static::$processSequence[$currentProcessStateKey + 1];

        if ($this->hasGiftWrapping === false && get_class($nextProcessStep) === GiftWrapped::class) {
            $nextProcessStep = new static::$processSequence[$currentProcessStateKey + 2];
        }

        return get_class($state) === get_class($nextProcessStep);
    }

    public function isFinished(StateInterface $currentProcessState): bool
    {
        $lastProcessStateType = static::$processSequence[count(static::$processSequence) - 1];

        return get_class($currentProcessState) === $lastProcessStateType;
    }

    public function isStarted(): bool
    {
        return static::$processSequence[0] === get_class($this->getCurrentState());
    }

    public function setCurrentState(StateInterface $state): void
    {
        $this->currentState = $state;
    }

    public function getCurrentState(): ?StateInterface
    {
        return $this->currentState;
    }

    public function isCurrentState(StateInterface $state): bool
    {
        return get_class($this->getCurrentState()) === get_class($state);
    }
}