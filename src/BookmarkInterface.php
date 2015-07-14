<?php
namespace App;

interface BookmarkInterface
{
    public function getTitle();

    public function getCaption();

    public function getImage();

    public function getUrl();
}