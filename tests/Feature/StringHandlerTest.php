<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\StringHandler;

class StringHandlerTest extends TestCase
{
    /**
     * Should Correctly Handle Integers
     *
     * @return void
     */
    public function testaddLeadingZeroFrom0To99_Should_CorrectlyHandleIntegers()
    {
    	//INTEGER INPUTS

    	// lower boundary near 0
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99(-1));
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99(0));
        $this->assertTrue("01" == StringHandler::addLeadingZeroFrom0To99(1));

        // mid-range
        $this->assertTrue("49" == StringHandler::addLeadingZeroFrom0To99(49));
        $this->assertTrue("50" == StringHandler::addLeadingZeroFrom0To99(50));
        $this->assertTrue("51" == StringHandler::addLeadingZeroFrom0To99(51));

        // upper boundary near 100
        $this->assertTrue("98" == StringHandler::addLeadingZeroFrom0To99(98));
        $this->assertTrue("99" == StringHandler::addLeadingZeroFrom0To99(99));
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99(100));

    }

    /**
     * Should Correctly Handle Floating Point Numbers
     *
     * @return void
     */
    public function testaddLeadingZeroFrom0To99_Should_CorrectlyHandleFloatingPointNumbers()
    {
        //FLOATING POINT INPUTS
    	// lower boundary near 0
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99(-1.1));
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99(0.1));
        $this->assertTrue("01" == StringHandler::addLeadingZeroFrom0To99(1.1));

        // mid-range
        $this->assertTrue("49" == StringHandler::addLeadingZeroFrom0To99(49.1));
        $this->assertTrue("50" == StringHandler::addLeadingZeroFrom0To99(50.1));
        $this->assertTrue("51" == StringHandler::addLeadingZeroFrom0To99(51.1));

        // upper boundary near 100
        $this->assertTrue("98" == StringHandler::addLeadingZeroFrom0To99(98.1));
        $this->assertTrue("99" == StringHandler::addLeadingZeroFrom0To99(99.1));
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99(100.1));

    }

    /**
     * Should Correctly Handle String Integers
     *
     * @return void
     */
    public function testaddLeadingZeroFrom0To99_Should_CorrectlyHandleStringIntegers()
    {
    	//STRING NUMERIC INPUTS

    	// lower boundary near 0
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99("-1"));
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99("0"));
        $this->assertTrue("01" == StringHandler::addLeadingZeroFrom0To99("1"));

        // mid-range
        $this->assertTrue("49" == StringHandler::addLeadingZeroFrom0To99("49"));
        $this->assertTrue("50" == StringHandler::addLeadingZeroFrom0To99("50"));
        $this->assertTrue("51" == StringHandler::addLeadingZeroFrom0To99("51"));

        // upper boundary near 100
        $this->assertTrue("98" == StringHandler::addLeadingZeroFrom0To99("98"));
        $this->assertTrue("99" == StringHandler::addLeadingZeroFrom0To99("99"));
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99("100"));

    }


    /**
     * Should Correctly Handle String Floating Point Numbers
     *
     * @return void
     */
    public function testaddLeadingZeroFrom0To99_Should_CorrectlyHandleStringFloatingPointNumbers()
    {
        //FLOATING POINT INPUTS
    	// lower boundary near 0
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99("-1.1"));
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99("0.1"));
        $this->assertTrue("01" == StringHandler::addLeadingZeroFrom0To99("1.1"));

        // mid-range
        $this->assertTrue("49" == StringHandler::addLeadingZeroFrom0To99("49.1"));
        $this->assertTrue("50" == StringHandler::addLeadingZeroFrom0To99("50.1"));
        $this->assertTrue("51" == StringHandler::addLeadingZeroFrom0To99("51.1"));

        // upper boundary near 100
        $this->assertTrue("98" == StringHandler::addLeadingZeroFrom0To99("98.1"));
        $this->assertTrue("99" == StringHandler::addLeadingZeroFrom0To99("99.1"));
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99("100.1"));
    }


    /**
     * Should Correctly Handle Invalid Inputs
     *
     * @return void
     */
    public function testaddLeadingZeroFrom0To99_Should_CorrectlyHandleInvalidInput()
    {
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99(NULL));
        $this->assertTrue("00" == StringHandler::addLeadingZeroFrom0To99("ABC"));
    }

}
