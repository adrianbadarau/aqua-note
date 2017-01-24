<?php
/**
 * Created by PhpStorm.
 * User: adiba
 * Date: 24-Jan-17
 * Time: 23:36
 */

namespace AppBundle\Twig;


use AppBundle\Service\MarkdownTransformer;

class MarkdownExtension extends \Twig_Extension
{
    /**
     * @var MarkdownTransformer
     */
    private $markdownTransformer;

    /**
     * MarkdownExtension constructor.
     * @param MarkdownTransformer $markdownTransformer
     */
    public function __construct(MarkdownTransformer $markdownTransformer)
    {
        $this->markdownTransformer = $markdownTransformer;
    }

    public function getName()
    {
        return 'app_markdown';
    }

    public function getFilters()
    {
        return[
            new \Twig_SimpleFilter('md', [$this, 'parseMarkdown'],['is_safe' => ['html']]),
        ];
    }

    public function parseMarkdown($str)
    {
        return $this->markdownTransformer->parse($str);
    }


}