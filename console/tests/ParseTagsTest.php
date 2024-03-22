<?php

namespace ConsoleApp\tests;

use ConsoleApp\TagsParser;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ParseTagsTest extends TestCase
{
    public function testBaseUsageOK1()
    {
        $model = new TagsParser("[TEST_TAG:testDescription]testData[/TEST_TAG]");
        $this->validateData($model, 'TEST_TAG', 'testData', 'testDescription');
    }

    public function testBaseUsageOK2()
    {
        $model = new TagsParser("[TEST_TAG:1]1[/TEST_TAG]");
        $this->validateData($model, 'TEST_TAG', '1', '1');
    }

    // rule not specified, but it's an edge case
    public function testSpacesInTagThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new TagsParser("[TEST TAG:1]1[/TEST TAG]");
    }

    public function testEmptyDataThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new TagsParser("[TEST_TAG_2:testDescription][/TEST_TAG_2]");
    }

    public function testEmptyDescriptionThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new TagsParser("[TEST_TAG_2:]test[/TEST_TAG_2]");
    }

    public function testEmptyTagThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new TagsParser("[:testDescription]test[]");
    }

    public function testNotMatchingTagsThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new TagsParser("[TEST_TAG:testDescription]test[TEST_TAG_2]");
    }

    public function testWrongInputFormatThrowsException1()
    {
        $this->expectException(InvalidArgumentException::class);
        new TagsParser("[TEST_TAG_2:testDescription]test/TEST_TAG_2]");
    }

    public function testWrongInputFormatThrowsException2()
    {
        $this->expectException(InvalidArgumentException::class);
        new TagsParser("[TEST_TAG_2:testDescription]t[es]t[/TEST_TAG_2]");
    }

    public function testWrongInputFormatThrowsException3()
    {
        $this->expectException(InvalidArgumentException::class);
        new TagsParser("[TEST_TAG_2][:testDescription]t[es]t[/TEST_TAG_2]");
    }

    public function testWrongInputFormatThrowsException4()
    {
        $this->expectException(InvalidArgumentException::class);
        new TagsParser("[TEST_TAG_2:testDescription:TEST]test[/TEST_TAG_2]");
    }

//    public function testCustomTestPlaceholder()
//    {
//        $model = new TagsParser("[TAG:description]data[/TAG]");
//        $this->validateData($model, 'TAG', 'data', 'description');
//    }

    /**
     * @param TagsParser $parser
     * @param string $tag
     * @param string $data
     * @param string $description
     */
    private function validateData(TagsParser $parser, string $tag, string $data, string $description)
    {
        self::assertTrue($parser->getDescription() === $description);
        self::assertTrue($parser->getData() === $data);
        self::assertTrue($parser->getTag() === $tag);
        $this->validateResponse($parser, $tag, $data, $description);
    }

    /**
     * @param TagsParser $parser
     * @param string $tag
     * @param string $data
     * @param string $description
     */
    private function validateResponse(TagsParser $parser, string $tag, string $data, string $description)
    {
        $parsedArray = $parser->getFormattedResponse();
        self::assertArrayHasKey($tag, $parsedArray);
        self::assertArrayHasKey('description', $parsedArray[$tag]);
        self::assertArrayHasKey('data', $parsedArray[$tag]);
        self::assertTrue(isset($parsedArray[$tag]) &&
            isset($parsedArray[$tag]['description']) && $parsedArray[$tag]['description'] == $description &&
            isset($parsedArray[$tag]['data']) && $parsedArray[$tag]['data'] == $data);
    }

}