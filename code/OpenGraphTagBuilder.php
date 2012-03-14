<?php

/**
 * @author Damian Mooyman
 */
class OpenGraphTagBuilder implements IMetaTagBuilder
{

    protected $mimeTypes = null;

    protected function loadMimeTypes()
    {
        if ($this->mimeTypes)
            return;

        $mimePath = realpath(dirname(__FILE__) . '/../etc/mime.types');
        if (!$mimePath || !@file_exists($mimePath))
            return;

        $mimeTypes = file($mimePath);
        $mimeData = array();
        foreach ($mimeTypes as $typeSpec)
        {
            if (!($typeSpec = trim($typeSpec)) || substr($typeSpec, 0, 1) == "#")
                continue;

            $parts = preg_split("/[ \t\r\n]+/", $typeSpec);
            if (sizeof($parts) <= 1)
                continue;

            $mimeType = array_shift($parts);
            foreach ($parts as $ext)
            {
                $ext = strtolower($ext);
                $mimeData[$ext] = $mimeType;
            }
        }

        $this->mimeTypes = $mimeData;
    }

    /**
     * Provides better fallbackfor {@link HTTP::getMimeType}
     * @param string $file File name or path
     * @return string|null Mime type of the passed in file, if known
     */
    protected function getMimeType($file)
    {
        // Check if this file has an extension
        if (strstr($file, '.') === false)
            return null;

        // Use silverstripe mime mechanism
        if ($type = HTTP::getMimeType($file))
            return $type;

        // Load our personal mime cache
        $this->loadMimeTypes();

        $extension = strtolower(substr($file, strrpos($file, '.') + 1));
        if (isset($this->mimeTypes[$extension]))
            return $this->mimeTypes[$extension];
    }

    public function AppendTag(&$tags, $name, $content)
    {
        if (empty($content))
            return;
        $tags .= sprintf("<meta name=\"%s\" content=\"%s\" />\n", Convert::raw2att($name), Convert::raw2att($content));
    }

    public function AppendLink(&$tags, $rel, $link, $type = null)
    {
        if (empty($rel) || empty($link))
            return;
        $tags .= sprintf("<link rel=\"%s\" href=\"%s\" type=\"%s\" />\n", Convert::raw2att($rel),
                Convert::raw2att($link),
                $type
                        ? $type
                        : $this->getMimeType($link)
        );
    }

    /**
     * Build a list of linked file tags for the specified value and append them to a string
     * @param string $tags The current tag string to append these to
     * @param string $namespace The namespace to use for this element
     * @param File[]|File|string[]|string $value Either an File object, string to the (non https) image url, or a list of the former
     * @param string $https The HTTPS url if available
     */
    protected function appendMediaMetaTags(&$tags, $namespace, $value, $https = null)
    {
        if (empty($value))
            return;

        // Handle situation where multiple items are presented
        if (is_array($value) || $value instanceof DataObjectSet)
        {
            foreach ($value as $file)
                $this->appendMediaMetaTags($tags, $namespace, $file);
            return;
        }

        // Handle explicit image object
        if ($value instanceof File)
        {
            if (!$value->exists())
                return;

            $this->appendMediaMetaTags($tags, $namespace, $value->getAbsoluteURL());
            /**
             * If you have the mediadata extension installed, this should correctly populate video width/height elements
             * @link https://github.com/tractorcow/silverstripe-mediadata
             */
            $this->appendTag($tags, "$namespace:width", $value->Width);
            $this->appendTag($tags, "$namespace:height", $value->Height);
            return;
        }

        // Handle image URL being given
        if (is_string($value))
        {
            // Populate HTTPS url if $value is set to the HTTPS url
            if (preg_match('/^https:/i', $value) && empty($https))
                $https = $value;

            // Ensure the main image tag only contains the unsecure url
            $value = preg_replace('/^https:/i', 'http:', $value);

            $mimeType = $this->getMimeType($value);

            // Append image_src meta tag if not present yet
            if (preg_match('/^image.*/', $mimeType) && !strstr($tags, 'rel="image_src"'))
                $this->appendLink($tags, 'image_src', $value);

            // Build tags
            $this->appendTag($tags, $namespace, $value);
            if ($https)
                $this->appendTag($tags, "$namespace:secure_url", $https);
            $this->appendTag($tags, "$namespace:type", $mimeType);
            return;
        }

        // Fail if could not determine presented value type
        trigger_error('Invalid file type: ' . gettype($value), E_USER_ERROR);
    }

    protected function appendLocales(&$tags, $locales)
    {
        if (empty($locales))
            return;

        // handle case with multiple locales
        if (is_array($locales))
        {
            // Loop through all locales
            $mainLocale = array_shift($locales);
            $this->appendLocales($tags, $mainLocale);
            foreach ($locales as $locale)
                $this->appendTag($tags, 'og:locale:alternate', $locale);
        }
        else
            $this->appendTag($tags, 'og:locale', $locales);
    }

    protected function appendDefaultMetaTags(&$tags, $object)
    {
        /* @var $object IOGObjectExplicit */
        $this->appendTag($tags, 'og:title', $object->getOGTitle());
        $this->appendTag($tags, 'og:type', $object->getOGType());
        $this->appendTag($tags, 'og:url', $object->AbsoluteLink());
        $this->appendMediaMetaTags($tags, 'og:image', $object->OGImage());

        // Media fields
        $this->appendMediaMetaTags($tags, 'og:audio', $object->OGAudio());
        $this->appendMediaMetaTags($tags, 'og:video', $object->OGVideo());

        // Other optional fields
        $this->appendTag($tags, 'og:description', $object->getOGDescription());
        $this->appendTag($tags, 'og:determiner ', $object->getOGDeterminer());
        $this->appendTag($tags, 'og:site_name', $object->getOGSiteName());
        $this->appendLocales($tags, $object->getOGLocales());
    }

    public function BuildTags(&$tags, DataObject $object)
    {
        return $this->appendDefaultMetaTags(&$tags, $object);
    }

}