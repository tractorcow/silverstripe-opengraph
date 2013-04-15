<?php

class OGBook extends OpenGraphBuilder
{

	protected function appendBookTags(&$tags, IOGBook $book)
	{
		$this->appendRelatedProfileTags($tags, 'book:author', $book->getOGAuthors());
		$this->AppendTag($tags, 'book:isbn', $book->getOGBookISBN());
		$this->appendDateTag($tags, 'book:release_date', $book->getOGBookReleaseDate());
		$this->appendRelatedTags($tags, 'book:tag', $book->getOGTags());
	}

	public function BuildTags(&$tags, $object, $config)
	{
		parent::BuildTags($tags, $object, $config);

		$this->appendBookTags($tags, $object);
	}

}