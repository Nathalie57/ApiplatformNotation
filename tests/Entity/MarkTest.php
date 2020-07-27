<?php

namespace App\Tests\Entity;

use App\Entity\Mark;
use PHPUnit\Framework\TestCase;

class MarkTest extends TestCase
{
    public function testValue()
    {
        $mark = new Mark();
        $value = 12;
        
        $mark->setValue($value);
        $this->assertEquals(12, $mark->getValue());
    }

    public function testSubject()
    {
        $mark = new Mark();
        $subject = "Français";
        
        $mark->setSubject($subject);
        $this->assertEquals("Français", $mark->getSubject());
    }
}