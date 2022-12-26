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
            return static::isFirstState($state);
        }

        $currentProcessStateKey = array_search(get_class($this->getCurrentState()), static::$processSequence);
        $nextProcessStep = new static::$processSequence[$currentProcessStateKey + 1];

        if ($this->hasGiftWrapping === false && get_class($nextProcessStep) === GiftWrapped::class) {
            $nextProcessStep = new static::$processSequence[$currentProcessStateKey + 2];
        }

        return get_class($state) === get_class($nextProcessStep);
    }

    public function setCurrentState(StateInterface $state): void
    {
        $this->currentState = $state;
    }

    public function getCurrentState(): ?StateInterface
    {
        return $this->currentState;
    }

    public function isFirstState(StateInterface $currentProcessState): bool
    {
        return get_class($currentProcessState) === static::$processSequence[0];
    }
}