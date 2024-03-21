<?php

namespace ConsoleApp;

class ConsoleController
{
    /**
     * @param string $text
     * @return array|null
     */
    public static function actionParseTags(string $text): ?array
    {
        $response = (new TagsParser($text))->getFormattedResponse();
        var_dump($response);
        return $response;
    }
}
