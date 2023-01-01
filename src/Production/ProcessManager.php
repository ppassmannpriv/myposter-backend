<?php declare(strict_types=1);

namespace Myposter\Production;

use Myposter\Logger\Logger;
use Myposter\Production\Exception\InvalidStateTransferException;
use Myposter\Production\State\StateInterface;

final class ProcessManager
{
    /**
     * Confirm whether the given state is valid for the article.
     * If the state is a valid next state, move the article to the new state.
     * @throws InvalidStateTransferException
     * @throws \Throwable
     */
	public function confirmAndMoveToState(StateInterface $state, Article $article): void
	{
        $processSequence = $article->getProcessSequence();
        $processSequence->updateGiftWrapping($article->hasGiftWrapping());
        try {
            if (!$processSequence->stateExists($state)) {
                throw new InvalidStateTransferException(sprintf('State %s is not in %s sequence.', $state->getType(), $article->getType()));
            }
            if (!$processSequence->isValidNextState($state)) {
                throw new InvalidStateTransferException(sprintf('State %s is out of %s sequence.', $state->getType(), $article->getType()));
            }
            $article->getProcessSequence()->setCurrentState($state);
        } catch (\Throwable $throwable) {
            Logger::getLogger()->error($throwable, ['state' => $state, 'article' => $article]);
            throw $throwable;
        }
	}
}
