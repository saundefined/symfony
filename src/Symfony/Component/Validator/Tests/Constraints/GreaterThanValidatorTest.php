<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Validator\Tests\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanValidator;

/**
 * @author Daniel Holmes <daniel@danielholmes.org>
 */
class GreaterThanValidatorTest extends AbstractComparisonValidatorTestCase
{
    protected function createValidator()
    {
        return new GreaterThanValidator();
    }

    protected static function createConstraint(array $options = null): Constraint
    {
        return new GreaterThan($options);
    }

    protected function getErrorCode(): ?string
    {
        return GreaterThan::TOO_LOW_ERROR;
    }

    /**
     * {@inheritdoc}
     */
    public static function provideValidComparisons(): array
    {
        return [
            [2, 1],
            [new \DateTime('2005/01/01'), new \DateTime('2001/01/01')],
            [new \DateTime('2005/01/01'), '2001/01/01'],
            [new \DateTime('2005/01/01 UTC'), '2001/01/01 UTC'],
            [new ComparisonTest_Class(5), new ComparisonTest_Class(4)],
            ['333', '22'],
            [null, 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function provideValidComparisonsToPropertyPath(): array
    {
        return [
            [6],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function provideInvalidComparisons(): array
    {
        return [
            [1, '1', 2, '2', 'int'],
            [2, '2', 2, '2', 'int'],
            [new \DateTime('2000/01/01'), 'Jan 1, 2000, 12:00 AM', new \DateTime('2005/01/01'), 'Jan 1, 2005, 12:00 AM', 'DateTime'],
            [new \DateTime('2000/01/01'), 'Jan 1, 2000, 12:00 AM', new \DateTime('2000/01/01'), 'Jan 1, 2000, 12:00 AM', 'DateTime'],
            [new \DateTime('2000/01/01'), 'Jan 1, 2000, 12:00 AM', '2005/01/01', 'Jan 1, 2005, 12:00 AM', 'DateTime'],
            [new \DateTime('2000/01/01'), 'Jan 1, 2000, 12:00 AM', '2000/01/01', 'Jan 1, 2000, 12:00 AM', 'DateTime'],
            [new \DateTime('2000/01/01 UTC'), 'Jan 1, 2000, 12:00 AM', '2005/01/01 UTC', 'Jan 1, 2005, 12:00 AM', 'DateTime'],
            [new \DateTime('2000/01/01 UTC'), 'Jan 1, 2000, 12:00 AM', '2000/01/01 UTC', 'Jan 1, 2000, 12:00 AM', 'DateTime'],
            [new ComparisonTest_Class(4), '4', new ComparisonTest_Class(5), '5', __NAMESPACE__.'\ComparisonTest_Class'],
            [new ComparisonTest_Class(5), '5', new ComparisonTest_Class(5), '5', __NAMESPACE__.'\ComparisonTest_Class'],
            ['22', '"22"', '333', '"333"', 'string'],
            ['22', '"22"', '22', '"22"', 'string'],
        ];
    }

    public static function provideComparisonsToNullValueAtPropertyPath()
    {
        return [
            [5, '5', true],
        ];
    }
}
