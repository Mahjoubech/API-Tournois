<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TestTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_it_returns_the_last_word_of_a_string(){
        $x = "my name is cherkaoui";
        $y = "";
        $i = strlen($x) - 1;
        while($i >= 0 && $x[$i] !== " "){
            $y = $y . $x[$i];
            $i--;
            
        }
        $this->assertEquals('cherkaoui', $y);
    }
}
