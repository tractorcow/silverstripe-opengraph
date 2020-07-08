<?php

namespace TractorCow\OpenGraph\ObjectBuilders\Other;

use TractorCow\OpenGraph\Interfaces\ObjectTypes\Other\IOGArticle;
use TractorCow\OpenGraph\ObjectBuilders\OpenGraphBuilder;

class OGArticle extends OpenGraphBuilder
{
    /**
     * @param string     $tags
     * @param IOGArticle $article
     */
    protected function appendArticleTags(&$tags, $article)
    {
        $this->appendDateTag($tags, 'article:published_time', $article->getOGArticlePublishedTime());
        $this->appendDateTag($tags, 'article:modified_time', $article->getOGArticleModifiedTime());
        $this->appendDateTag($tags, 'article:expiration_time', $article->getOGArticleExpirationTime());
        $this->appendRelatedProfileTags($tags, 'og:author', $article->getOGAuthors());
        $this->AppendTag($tags, 'article:section', $article->getOGArticleSection());
        $this->appendRelatedTags($tags, 'article:tag', $article->getOGTags());
    }

    public function BuildTags(&$tags, $object, $config)
    {
        parent::BuildTags($tags, $object, $config);

        $this->appendArticleTags($tags, $object);
    }
}
