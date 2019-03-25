<?php

namespace Cypher\Template;

class FileViewFinder extends \Illuminate\View\FileViewFinder
{
    const FALLBACK_PARTS_DELIMITER = '-';

    /**
     * Get an array of possible view files from a single file name.
     *
     * @param  string $name
     * @return array
     */
    public function getPossibleViewFiles($name)
    {
        $parts = explode(self::FALLBACK_PARTS_DELIMITER, $name);
        $templates[] = array_shift($parts);
        foreach ($parts as $i => $part) {
            $templates[] = $templates[$i] . self::FALLBACK_PARTS_DELIMITER . $part;
        }
        rsort($templates);
        $templates = $this->getHierarchicalFilenames($templates);

        return $this->getPossibleViewFilesFromTemplates($templates);
    }

    /**
     * Get an array of possible view files from an array of templates
     *
     * @param array $templates
     * @return array
     */
    public function getPossibleViewFilesFromTemplates($templates)
    {
        return call_user_func_array('array_merge', array_map(function ($template) {
            return array_map(function ($extension) use ($template) {
                return str_replace('.', '/', $template) . '.' . $extension;
            }, $this->extensions);
        }, $templates));
    }

    public function getHierarchicalFilenames($templates)
    {
        $templates_return = [];
        foreach ($templates as $key => $template) {
            if (substr($template, -1) !== '.') {
                $templates_return[] = $template;
                continue;
            }

            $basePath = rtrim($template, '.');

            /** @var \Brain\Hierarchy\Hierarchy $hierarchy */
            $hierarchy = cypher()->get('cypher.hierarchy')->getTemplates();

            foreach ($hierarchy as $item) {
                $templates_return[] = $basePath . '.' . $item;
            }
        }

        return $templates_return;
    }

    /**
     * Get the fully qualified location of the view.
     *
     * @param  string $name
     * @return string
     */
    public function find($name)
    {
        if (isset($this->views[$name])) {
            return $this->views[$name];
        }

        if ($this->hasHintInformation($name = trim($name))) {
            return $this->views[$name] = $this->findNamespacedView($name);
        }

        return $this->views[$name] = $this->findInPaths($name, $this->paths);
    }
}
