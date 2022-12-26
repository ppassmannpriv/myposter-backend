<?php declare(strict_types=1);

namespace Myposter\Production\Process\Sequence;

use Myposter\Production\Process\Sequence;
use Myposter\Production\State\Framed;
use Myposter\Production\State\GiftWrapped;
use Myposter\Production\State\Ordered;
use Myposter\Production\State\Printed;
use Myposter\Production\State\Shipped;
use Myposter\Production\State\Sliced;

final class PosterFramedSequence extends Sequence
{
    public static array $processSequence = [
        Ordered::class,
        Printed::class,
        Sliced::class,
        Framed::class,
        GiftWrapped::class,
        Shipped::class
    ];
}