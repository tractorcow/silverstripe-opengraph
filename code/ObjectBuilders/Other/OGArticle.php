<?php

class OGArticle extends OpenGraphBuilder
{

    protected function appendArticleTags(&$tags, IOGArticle $article)
    {
        $this->appendDateTag($tags, 'article:published_time', $article->getOGArticlePublishedTime());
        $this->appendDateTag($tags, 'article:modified_time', $article->getOGArticleModifiedTime());
        $this->appendDateTag($tags, 'article:expiration_time', $article->getOGArticleExpirationTime());
        $this->appendRelatedProfileTags($tags, 'og:author', $article->OGAuthors());
        $this->appendTag($tags, 'article:section', $article->getOGArticleSection());
        $this->appendTag($tags, 'article:tag', $article->getOGTags());
    }

    public function BuildTags(&$tags, $object, $config)
    {
        parent::BuildTags($tags, $object, $config);

        $this->appendArticleTags($tags, $object);
    }

}