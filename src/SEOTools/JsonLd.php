<?php

namespace Artesaos\SEOTools;

use Artesaos\SEOTools\Contracts\JsonLd as JsonLdContract;

class JsonLd implements JsonLdContract
{
    /**
     * @var array
     */
    protected $values = [];

    /**
     * @var string
     */
    protected $type = '';

    /**
     * @var string
     */
    protected $name = '';

    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $url = '';

    /**
     * @var array
     */
    protected $images = [];

    /**
     * @param array $defaults
     */
    public function __construct(array $defaults = [])
    {
        $this->setTitle($defaults['title']);
        unset($defaults['title']);

        $this->setDescription($defaults['description']);
        unset($defaults['description']);

        $this->setType($defaults['type']);
        unset($defaults['type']);

        $this->setUrl($defaults['url']);
        unset($defaults['url']);

        $this->setImages($defaults['images']);
        unset($defaults['images']);

        $this->values = $defaults;
    }

    /**
     * {@inheritdoc}
     */
    public function generate($minify = false)
    {
        $generated = [
            '@context' => 'https://schema.org',
        ];

        if (!empty($this->type)) {
            $generated['@type'] = $this->type;
        }


        if (!empty($this->name)) {
            $generated['name'] = $this->name;
        }


        if (!empty($this->description)) {
            $generated['description'] = $this->description;
        }

        if (!empty($this->url)) {
            $generated['url'] = $this->url;
        }

        if (!empty($this->images)) {
            $generated['image'] = count($this->images) === 1 ? reset($this->images) : json_encode($this->images);
        }

        $generated = array_merge($generated, $this->values);

        return '<script type="application/ld+json">' . json_encode($generated) . '</script>';
    }

    /**
     * {@inheritdoc}
     */
    public function addValue($key, $value)
    {
        $this->values[$key] = $value;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setTitle($title)
    {
        return $this->setName($title);
    }

    /**
     * {@inheritdoc}
     */
    public function setSite($site)
    {
        $this->url = $site;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     *{@inheritdoc}
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setImages($images)
    {
        $this->images = [];

        return $this->addImage($images);
    }

    /**
     * {@inheritdoc}
     */
    public function addImage($image)
    {
        if (is_array($image)) {
            $this->images = array_merge($this->images, $image);
        } elseif (is_string($image)) {
            $this->images[] = $image;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setImage($image)
    {
        $this->images = [$image];

        return $this;
    }
}
