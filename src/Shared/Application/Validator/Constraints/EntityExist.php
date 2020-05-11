<?php

/*
 * This file is part of the Symfony 4 CQRS Cart Project.
 *
 * (c) Jakub Szcześniak
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Shared\Application\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
final class EntityExist extends Constraint
{
    public $message = 'The entity "{{ string }}" does not exist.';

    /**
     * Full entity className
     *
     * @var string
     */
    public $value;

    /**
     * EntityExist constructor.
     *
     * @param array|null $options
     */
    public function __construct($options = null)
    {
        parent::__construct($options);
    }
}
