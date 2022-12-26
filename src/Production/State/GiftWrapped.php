<?php declare(strict_types=1);

namespace Myposter\Production\State;

final class GiftWrapped implements StateInterface
{
	public const TYPE = 'gift-wrapped';

	public function getType(): string
	{
		return self::TYPE;
	}
}
