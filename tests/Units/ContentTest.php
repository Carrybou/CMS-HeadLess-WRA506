<?php

namespace App\Tests\Units;

use App\Entity\Content;
use App\Entity\Tags;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class ContentTest extends TestCase
{
    public function testContentProperties()
    {
        $content = new Content();
        $content->title = 'Sample Title';
        $content->img = 'sample.jpg';
        $content->meta_title = 'Sample Meta Title';
        $content->meta_description = 'Sample Meta Description';
        $content->content = 'This is a sample content.';
        $content->slug = 'sample-title';

        $this->assertEquals('Sample Title', $content->title);
        $this->assertEquals('sample.jpg', $content->img);
        $this->assertEquals('Sample Meta Title', $content->meta_title);
        $this->assertEquals('Sample Meta Description', $content->meta_description);
        $this->assertEquals('This is a sample content.', $content->content);
        $this->assertEquals('sample-title', $content->slug);
    }

    public function testAddAndRemoveTags()
    {
        $content = new Content();
        $tag = new Tags();
        $tag->name = 'Sample Tag';

        $content->addTag($tag);
        $this->assertTrue($content->tags->contains($tag));

        $content->removeTag($tag);
        $this->assertFalse($content->tags->contains($tag));
    }

    public function testAuthor()
    {
        $content = new Content();
        $user = new User();
        $user->setEmail('sampleuser@gmail.com');

        $content->author = $user;
        $this->assertEquals('sampleuser@gmail.com', $content->author->getEmail());
    }
}
