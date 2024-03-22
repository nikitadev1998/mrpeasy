<?php


namespace ConsoleApp;


use InvalidArgumentException;

/**
 * Class TagsParser
 * @package ConsoleApp
 */
class TagsParser
{
    private string $tag;
    private string $description;
    private string $data;

    /**
     * TagsParser constructor.
     * @param string $text
     */
    public function __construct(string $text)
    {
        $this->parseText($text);
    }

    /**
     * @param string $text
     */
    public function parseText(string $text)
    {
        $re = '/\[([^]]+)\]/m'; // regex to find text in brackets
        preg_match($re, $text, $tags); // parse tags and description
        preg_match($re, $text, $endTags, 0, 1); // parse end tag

        if (empty($tags) || count($tags) != 2) {
            throw new InvalidArgumentException("Input invalid format for $text");
        } elseif (empty($endTags) || count($endTags) != 2) {
            throw new InvalidArgumentException("Input invalid format for $text");
        }

        $tagWithDescription = explode(':', $tags[1]);
        if (empty($tagWithDescription) || count($tagWithDescription) != 2) {
            throw new InvalidArgumentException("Input invalid format for $text");
        }

        $tag = $tagWithDescription[0];
        $endTag = $endTags[1];
        $description = $tagWithDescription[1];
        $data = (preg_replace($re, '', $text));

        // validate
        if (empty($description)) {
            throw new InvalidArgumentException("Description should not be empty for $text");
        } elseif (empty($tag)) {
            throw new InvalidArgumentException("Tag should not be empty for $text");
        } elseif (str_replace('/', '', $endTag) != $tag) {
            throw new InvalidArgumentException("Input invalid TAG format for $text");
        } elseif (is_array($data) || empty($data)) {
            throw new InvalidArgumentException("Data should be specified for $text");
        } elseif (strpos($tag, ' ') != false) {
            throw new InvalidArgumentException("No spaces allowed in tags for $text");
        }


        $this->setDescription($description);
        $this->setTag($tag);
        $this->setData($data);
    }

    /**
     * @return string[][]
     */
    public function getFormattedResponse(): array
    {
        return [
            $this->getTag() => [
                'description' => $this->getDescription(),
                'data' => $this->getData()
            ]
        ];
    }

    /**
     * @param string $tag
     * @return TagsParser
     */
    private function setTag(string $tag): TagsParser
    {
        $this->tag = $tag;
        return $this;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $description
     * @return TagsParser
     */
    private function setDescription(string $description): TagsParser
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $data
     * @return TagsParser
     */
    private function setData(string $data): TagsParser
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return string
     */
    public function getData(): string
    {
        return $this->data;
    }
}