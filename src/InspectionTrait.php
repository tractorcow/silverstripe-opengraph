<?php

namespace TractorCow\OpenGraph;

use SilverStripe\Core\Extensible;

trait InspectionTrait
{
    /**
     * Determine if an object implements a specific interface, or
     * has an extension which implements this
     *
     * @param object $object
     * @param string $type Type to inspect
     * @return bool True if $object, or any of its extensions, is of type $type
     */
    protected static function implementsType($object, $type)
    {
        if (!is_object($object)) {
            return false;
        }

        if ($object instanceof $type) {
            return true;
        }

        // Check extensions
        /** @var Extensible $object */
        if (in_array(Extensible::class, class_uses($object))) {
            $extensions = $object->getExtensionInstances();
            foreach ($extensions as $extension) {
                if ($extension instanceof $type) {
                    return true;
                }
            }
        }

        return false;
    }
}
