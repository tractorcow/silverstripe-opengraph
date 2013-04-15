<?php

class OGArticle extends OpenGraphBuilder
{

	protected function appendArticleTags(&$tags, IOGArticle $article)
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