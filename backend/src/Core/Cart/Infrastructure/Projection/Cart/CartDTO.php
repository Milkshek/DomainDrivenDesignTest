<?php

declare(strict_types=1);


namespace App\Core\Cart\Infrastructure\Projection\Cart;

use App\Core\Cart\Domain\Model\Cart;

final readonly class CartDTO
{

    public function __construct(
        public Cart $cart,
        public int $version,
    )
    {
    }
}
