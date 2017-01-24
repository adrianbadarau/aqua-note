<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 24-Jan-17
 * Time: 22:58
 */

namespace AppBundle\Service;


use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;

class MarkdownTransformer
{
    private $markdownParser;

    /**
     * MarkdownTransformer constructor.
     * @param $markdownParser
     */
    public function __construct(MarkdownParserInterface $markdownParser)
    {
        $this->markdownParser = $markdownParser;
    }

    public function parse( $str)
    {
        return $this->markdownParser->transformMarkdown($str);
    }
}