<?php

namespace BladeSvg;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use Illuminate\Contracts\Support\Htmlable;
use DOMDocument;

class Icon implements Htmlable
{
    private $icon;
    private $renderMode;
    private $factory;
    private $attrs = [];

    public function __construct($icon, $renderMode, $factory, $attrs = [])
    {
        $this->icon = $icon;
        $this->renderMode = $renderMode;
        $this->factory = $factory;
        $this->attrs = $attrs;
        $this->title = array_pull($this->attrs, 'alt');
    }

    public function toHtml()
    {
        return new HtmlString(call_user_func([
            'inline' => [$this, 'renderInline'],
            'sprite' => [$this, 'renderFromSprite'],
        ][$this->renderMode]));
    }

    public function __call($method, $args)
    {
        if (count($args) === 0) {
            $this->attrs[] = snake_case($method, '-');
        } else {
            $this->attrs[snake_case($method, '-')] = $args[0];
        }
        return $this;
    }

    public function inline()
    {
        $this->renderMode = 'inline';
        return $this;
    }

    public function sprite()
    {
        $this->renderMode = 'sprite';
        return $this;
    }

    public function renderInline()
    {
        // Filters attributes.
        $this->title = array_pull($this->attrs, 'alt');
        $this->class = array_pull($this->attrs, 'class');

        // Prepares SVG string for DOM manipulation.
        $svg_str = $this->factory->getSvg($this->icon);
        $xml_doc = new DOMDocument();
        $xml_doc->loadXML($svg_str);
        $svg = $xml_doc->getElementsByTagName('svg');

        // Inserts <title> as first child of <svg>.
        if(strlen($this->title)) {
            $title = $xml_doc->createElement('title', htmlentities($this->title));
            $svg->item(0)->insertBefore($title, $svg->item(0)->childNodes->item(0));
        }

        $svg_str = $svg->item(0)->C14N();

        // Prevents class attribute duplication when both blade-svg config and <svg> document come with class attribute. (svg class="…" class="…")
        if(strlen($this->class)) {
            preg_match("/\s\bclass=(\"[^\"]+\")/", $svg_str, $classes);
            $old_classes = str_replace('"', '', $classes[1]);
            $new_classes = $old_classes . ' ' . $this->class;
            $svg_str = str_replace($old_classes, $new_classes, $svg_str);
        }

        return str_replace(
            '<svg',
            sprintf('<svg%s', $this->renderAttributes()),
            $svg_str
        );
    }

    public function renderFromSprite()
    {
        return vsprintf('<svg%s>%s<use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#%s"></use></svg>', [
            $this->renderAttributes(),
            $this->renderTitle(),
            $this->factory->spriteId($this->icon)
        ]);
    }

    private function renderTitle()
    {
        return strlen($this->title) ? '<title>' . $this->title . '</title>' : '';
    }

    private function renderAttributes()
    {
        if (count($this->attrs) == 0) {
            return '';
        }

        return ' '.collect($this->attrs)->map(function ($value, $attr) {
            if (is_int($attr)) {
                return $value;
            }
            return sprintf('%s="%s"', $attr, $value);
        })->implode(' ');
    }
}
