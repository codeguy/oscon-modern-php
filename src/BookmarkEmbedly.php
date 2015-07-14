<?php
namespace App;

class BookmarkEmbedly implements BookmarkInterface
{
    /**
     * Embedly API
     *
     * @var \Embedly\Embedly
     */
    protected $embedly;

    /**
     * The URL to  parse
     *
     * @var string
     */
    protected $url;

    /**
     * Embedly result
     *
     * @var array|null
     */
    protected $result;

    /**
     * Constructor
     *
     * @param string           $url
     * @param \Embedly\Embedly $embedly
     */
    public function __construct($url, \Embedly\Embedly $embedly)
    {
        $this->url = $url;
        $this->embedly = $embedly;
    }

    /**
     * Get bookmark title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->getProperty('title');
    }

    /**
     * Get bookmark caption
     *
     * @return string
     */
    public function getCaption()
    {
        return $this->getProperty('description');
    }

    /**
     * Get bookmark image URL
     *
     * @return string
     */
    public function getImage()
    {
        $hits = $this->getProperty('images');

        return $hits ? $hits[0]->url : null;
    }

    /**
     * Get bookmark URL
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Get bookmark property
     *
     * @param  string      $property
     *
     * @return string|null Property value if exists, else NULL
     */
    protected function getProperty($property)
    {
        if (!$this->result) {
            $this->result = $this->embedly->extract($this->url);
        }

        return property_exists($this->result, $property) ? $this->result->$property : null;
    }
}
