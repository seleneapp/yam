<?php

/**
 * This File is part of the Yam\Utils\Traits package
 *
 * (c) Thomas Appel <mail@thomas-appel.com>
 *
 * For full copyright and license information, please refer to the LICENSE file
 * that was distributed with this package.
 */

namespace Yam\Utils\Traits;

/**
 * @class UUidGeneratorTrait
 * @package Yam\Utils\Traits
 * @version $Id$
 */
trait UUidGeneratorTrait
{
    public function createUuid()
    {
        try {
            if ($uuid = Uuid::uuid4()) {
                return $uuid;
            }
        } catch (UnsatisfiedDependencyException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw new GeneratorException(sprintf('UUID creation failed with message: %s', $e->getMessage()));
        }
    }
}
