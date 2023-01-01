<?php declare(strict_types=1);

namespace Myposter\Production;

use Myposter\Logger\Logger;
use Myposter\Production\Process\Sequence;
use Myposter\Production\Process\SequenceFactory;
use Myposter\Production\State\StateInterface;

final class Article
{
	public const TYPE_POSTER_FRAMED = 'poster-framed';
	public const TYPE_PRINTED_GLASS = 'printed-glass';

	private string $articleType;
    private Sequence $processSequence;

	private bool $hasGiftWrapping = false;

	/**
	 * @return string[]
	 */
	public static function getTypes(): array
	{
		return [
			self::TYPE_POSTER_FRAMED,
			self::TYPE_PRINTED_GLASS,
		];
	}

	private static function isTypeValid(string $articleType): bool
	{
		return \in_array($articleType, self::getTypes());
	}

	/**
	 * @throws \InvalidArgumentException Unknown article type
	 */
	private static function validateType(string $articleType): void
	{
		if (!self::isTypeValid($articleType)) {
			throw new \InvalidArgumentException('unknown article type given: ' . $articleType, 1626963396724);
		}
	}

	/**
	 * @throws \InvalidArgumentException Unknown article type
	 */
	public function __construct(string $articleType)
	{
		self::validateType($articleType);

		$this->articleType = $articleType;
        $this->processSequence = SequenceFactory::create($articleType, $this->hasGiftWrapping());
	}

	public function hasGiftWrapping(): bool
	{
		return $this->hasGiftWrapping;
	}

	/**
	 * @return $this
	 */
	public function enableGiftWrapping(): self
	{
		$this->hasGiftWrapping = true;
        Logger::debug('Article now has gift wrapping enabled!');
		return $this;
	}

	public function getState(): ?StateInterface
	{
		return $this->getProcessSequence()->getCurrentState();
	}

	public function getType(): string
	{
		return $this->articleType;
	}

    public function getProcessSequence(): Sequence
    {
        return $this->processSequence;
    }
}
