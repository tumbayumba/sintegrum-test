<?php
namespace app\common\components\parsers;

use yii\web\RequestParserInterface;
use yii\base\InvalidParamException;

class XmlParser implements RequestParserInterface
{
    public $asArray = true;
    public $throwException = true;

    /**
     * Parses a HTTP request body.
     * @param string $rawBody the raw HTTP request body.
     * @param string $contentType the content type specified for the request body.
     * @return array parameters parsed from the request body
     * @throws BadRequestHttpException if the body contains invalid xml and     [[throwException]] is `true`.
     */

    public function parse($rawBody, $contentType)
    {
        try {
            $parameters = simplexml_load_string($rawBody);

            if($this->asArray) {
                $parameters = (array) $parameters;
            }
            return $parameters === null ? [] : $parameters;

        } catch (InvalidParamException $e) {

            if ($this->throwException) {
                throw new BadRequestHttpException('Invalid XML data in request body: ' .    $e->getMessage());
            }
            return [];
        }
    }
}