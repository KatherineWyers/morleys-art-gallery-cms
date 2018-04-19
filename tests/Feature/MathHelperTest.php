<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\MathHelper;

class MathHelperTest extends TestCase
{
    /**
     *
     * @return void
     */
    public function testCalculatePercentage_Should_ReturnRoundedPercentage()
    {

        //Zero numerator
        $this->assertTrue(0 == MathHelper::calculatePercentage(0, 1));
        $this->assertTrue(0 == MathHelper::calculatePercentage(0, 2));

    	//Zero denominator (divide by zero)
        $this->assertTrue(0 == MathHelper::calculatePercentage(0, 0));
        $this->assertTrue(0 == MathHelper::calculatePercentage(1, 0));

        //Negative numerator (outside range)
        $this->assertTrue(0 == MathHelper::calculatePercentage(-2, 1));
        $this->assertTrue(0 == MathHelper::calculatePercentage(-1, 2));

    	//Negative denominator (outside range)
        $this->assertTrue(0 == MathHelper::calculatePercentage(1, -2));
        $this->assertTrue(0 == MathHelper::calculatePercentage(2, -1));

        //Numerator higher than denominator returns 100  (outside range)
        $this->assertTrue(100 == MathHelper::calculatePercentage(50, 49));

        //Whole-number percentages
        $this->assertTrue(25 == MathHelper::calculatePercentage(1, 4));
        $this->assertTrue(25 == MathHelper::calculatePercentage(2, 8));
        $this->assertTrue(50 == MathHelper::calculatePercentage(1, 2));
        $this->assertTrue(50 == MathHelper::calculatePercentage(2, 4));
        $this->assertTrue(75 == MathHelper::calculatePercentage(3, 4));
        $this->assertTrue(75 == MathHelper::calculatePercentage(6, 8));
        $this->assertTrue(100 == MathHelper::calculatePercentage(1, 1));
        $this->assertTrue(100 == MathHelper::calculatePercentage(2, 2));

        //Rounded-number percentages
        $this->assertTrue(33 == MathHelper::calculatePercentage(1, 3));
        $this->assertTrue(33 == MathHelper::calculatePercentage(2, 6));
        $this->assertTrue(33 == MathHelper::calculatePercentage(3, 9));
        $this->assertTrue(33 == MathHelper::calculatePercentage(4, 12));
        $this->assertTrue(66 == MathHelper::calculatePercentage(2, 3));
        $this->assertTrue(66 == MathHelper::calculatePercentage(4, 6));
        $this->assertTrue(66 == MathHelper::calculatePercentage(6, 9));
        $this->assertTrue(66 == MathHelper::calculatePercentage(8, 12));

        //Decimal inputs
        $this->assertTrue(27 == MathHelper::calculatePercentage(1.1, 4));
        $this->assertTrue(24 == MathHelper::calculatePercentage(1, 4.1));
        $this->assertTrue(26 == MathHelper::calculatePercentage(1.1, 4.1));

    }
}
