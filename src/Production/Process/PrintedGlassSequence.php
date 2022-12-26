<?php declare(strict_types=1);

namespace Myposter\Production\Process;

use Myposter\Production\State\GiftWrapped;
use Myposter\Production\State\Ordered;
use Myposter\Production\State\Printed;
use Myposter\Production\State\Shipped;

final class PrintedGlassSequence extends Sequence
{
    public static array $processSequence = [
        Ordered::class,
        Printed::class,
        GiftWrapped::class,
        Shipped::class
    ];
}