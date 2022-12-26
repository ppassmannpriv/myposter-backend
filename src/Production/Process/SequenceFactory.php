<?php declare(strict_types=1);

namespace Myposter\Production\Process;

use Myposter\Production\Article;
use Myposter\Production\Process\Sequence\PosterFramedSequence;
use Myposter\Production\Process\Sequence\PrintedGlassSequence;
use Myposter\Production\State\StateInterface;

final class SequenceFactory
{
    public static array $sequenceMap = [
        Article::TYPE_POSTER_FRAMED => PosterFramedSequence::class,
        Article::TYPE_PRINTED_GLASS => PrintedGlassSequence::class,
    ];

    public static function create(string $articleType, bool $hasGiftWrapping = false, ?StateInterface $initState = null): Sequence
    {
        return new static::$sequenceMap[$articleType]($hasGiftWrapping, $initState);
    }
}