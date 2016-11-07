<?php

namespace AppBundle\Manager;

use FOS\RestBundle\Controller\Annotations\RequestParam;
use Doctrine\ORM\EntityManager;
use AppBundle\Manager\BaseManager;
use AppBundle\Entity\Article;
    
    
class ArticleManager extends BaseManager
{
    protected $em;

	public function __construct(EntityManager $em) 
	{
		$this->em = $em;
	}
    
    /**
     * save article entity
     *
     * @param Article $article
     */
    public function saveArticle(Article $article) {
        $this->persistAndFlush($article);
    }
    
    /**
     * Find article by id
     *
     * @param Article $article
     * @ParamConverter("article", options={"mapping": {"article": "id"}})
     *
     * @return $article
     */
    public function loadArticle(Article $article) {

        return $article;
    }

    /**
     * Find Article by slug
     *
     * @param Article $article
     * @ParamConverter("art", options={"mapping": {"slug": "slug"}})
     */
    public function loadBySlugArticle(Article $article) {

        return $article;
    }

    /**
     * Remove article by id
     *
     * @param Article $article
     * @ParamConverter("article", options={"mapping": {"article": "id"}})
     *
     */
    public function removeArticle (Article $article) {

        $this->removeAndFlush($article);
        
    }

    /**
     * Get all articles
     *
     */
    public function getArticles() {
        return $this->getRepository()
            ->findAll();
    }
    
    public function getRepository () {
        return $this->em->getRepository("AppBundle:Article");
    }
}