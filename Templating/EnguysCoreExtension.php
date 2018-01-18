<?php

namespace Enguys\CoreBundle\Templating;

use Enguys\CoreBundle\Manager\PageManager;

class EnguysCoreExtension extends \Twig_Extension
{
    private $pageManager;

    public function __construct(PageManager $pageManager)
    {
        $this->pageManager = $pageManager;
    }

    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction(
                'enguys_core_page_title',
                [$this, 'pageTitleFunction']
            ),
            new \Twig_SimpleFunction(
                'enguys_core_meta_title',
                [$this, 'metaTitleFunction']
            ),
            new \Twig_SimpleFunction(
                'enguys_core_body_class',
                [$this, 'bodyClassFunction']
            ),
            new \Twig_SimpleFunction(
                'enguys_core_meta_tags',
                [$this, 'metaTagsFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
            new \Twig_SimpleFunction(
                'enguys_core_open_graph',
                [$this, 'openGraphFunction'],
                ['is_safe' => ['html'], 'needs_environment' => true]
            ),
        ];
    }

    /**
     * @return null|string
     */
    public function pageTitleFunction()
    {
        return $this->pageManager->getTitle();
    }

    /**
     * @return null|string
     */
    public function metaTitleFunction()
    {
        return $this->pageManager->getMetaTitle();
    }

    /**
     * @return mixed
     */
    public function bodyClassFunction()
    {
        return $this->pageManager->getBodyClass();
    }

    /**
     * @param \Twig_Environment $environment
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function metaTagsFunction(\Twig_Environment $environment)
    {
        return $environment->render('@EnguysCore/Page/metaTags.html.twig', [
            'author' => $this->pageManager->getMetaAuthor(),
            'description' => $this->pageManager->getMetaDescription(),
            'keywords' => $this->pageManager->getMetaKeywords(),
        ]);
    }

    /**
     * @param \Twig_Environment $environment
     *
     * @return string
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function openGraphFunction(\Twig_Environment $environment)
    {
        return $environment->render('@EnguysCore/Page/openGraph.html.twig', [
            'ogProperties' => $this->pageManager->getOgProperties(),
        ]);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'enguys_core_extension';
    }
}