<?php
namespace App;

class BookmarkEmbedlyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Embedly API
     *
     * @var \Embedly\Embedly
     */
    protected $embedly;

    /**
     * Setup state before each test
     */
    public function setup()
    {
        $this->embedly = new \Embedly\Embedly([
            'key' => '85a6d1b135ec47da97e651c0ee730b3f'
        ]);
    }

    /**
     * Test get title from BookmarkEmbedly instance
     *
     * @group title
     */
    public function testGetTitle()
    {
        $result = new \App\BookmarkEmbedly('https://php.net', $this->embedly);
        $this->assertEquals('PHP: Hypertext Preprocessor', $result->getTitle());
    }

    /**
     * Test BookmarkEmbedly instance has description
     *
     * @group caption
     */
    public function testGetCaption()
    {
        $result = new \App\BookmarkEmbedly('https://php.net', $this->embedly);
        $this->assertFalse(empty($result->getCaption()));
    }
}