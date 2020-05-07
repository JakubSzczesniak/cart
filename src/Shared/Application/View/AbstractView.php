<?php

namespace App\Shared\Application\View;

use JsonSerializable;

/**
 * Class AbstractView
 */
abstract class AbstractView implements JsonSerializable
{
    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
