<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation\ApiDoc; 
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use FOS\RestBundle\Controller\Annotations as Rest;
use AppBundle\Entity\Article;
use AppBundle\Form\Type\ArticleType;

class ArticleController extends Controller
{
    /**
     * @ApiDoc(
     *    description="Récupère la liste des articles de l'applicaation",
     *    input={"class"=ArticleType::class, "name"=""},
     *    statusCodes = {
     *        200 = "Article trouvé avec succés",
     *        404 = "Aucun article trouvé"
     *    },
     *    responseMap={
     *         200 = {"class"=Article::class},
     *         404 = { "class"=ArticleType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     *
     * @Rest\View()
     * @Rest\Get("/articles")
     */
    public function getArticlesAction(Request $request)
    {
        
        if (!$articles = $this->get('app.article_manager')->getArticles()) {
            return new JsonResponse(['message' => 'Article not found'], Response::HTTP_NOT_FOUND);
        }
        
        return $articles;
    }
    

    /**
     * @ApiDoc(
     *    description="Creation d'un article",
     *    input={"class"=ArticleType::class, "name"=""},
     *    statusCodes = {
     *        201 = "Article créé avec succés",
     *        400 = "Formulaire invalide"
     *    },
     *    responseMap={
     *         201 = {"class"=Article::class},
     *         400 = { "class"=ArticleType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("articles")
     */
    public function postArticleAction(Request $request) {
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article);
        $form -> submit($request->request->All());
        
        if ($form->isValid() && $request->isMethod('Post')) {
    
            $this->get('app.article_manager')->saveArticle($article);

            return $article;
        } else {
            return $form;
        }
    }

    /**
     * @ApiDoc(
     *    description="Récuperation d'un article à partir de l'id",
     *    input={"class"=ArticleType::class, "name"=""},
     *    statusCodes = {
     *        200 = "Article trouvé avec succés",
     *        404 = "Article non trouvé"
     *    },
     *    responseMap={
     *         200 = {"class"=Article::class},
     *         404 = { "class"=ArticleType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View()
     * @Rest\Get("articles/{id}")
     */
    public function getOneArticleAction(Article $art) {


        if (!$article = $this->get('app.article_manager')->loadArticle($art)) {
            return new JsonResponse(['message' => 'This Article is not found'], Response::HTTP_NOT_FOUND);
        }
        return $article;
    }

    /**
     * @ApiDoc(
     *    description="Récuperation d'un article à partir du slug",
     *    input={"class"=ArticleType::class, "name"=""},
     *    statusCodes = {
     *        200 = "Article trouvé avec succés",
     *        404 = "Article non trouvé"
     *    },
     *    responseMap={
     *         200 = {"class"=Article::class},
     *         404 = { "class"=ArticleType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View()
     * @Rest\Get("article/{slug}")
     */
    public function getArticleBySlugAction(Article $article) {
        
        if (!$article = $this->get('app.article_manager')->loadBySlugArticle($article)) {
            return new JsonResponse(['message' => 'This Article is not found'], Response::HTTP_NOT_FOUND);
        }
 
        return $article;
    }
    
    
    /**
     * @ApiDoc(
     *    description="Suppression d'un article",
     *    input={"class"=ArticleType::class, "name"=""},
     *    statusCodes = {
     *        200 = "Article supprimé avec succés",
     *        404 = "Article non trouvé"
     *    },
     *    responseMap={
     *         200 = {"class"=Article::class},
     *         404 = { "class"=ArticleType::class, "form_errors"=true, "name" = ""}
     *    }
     * )
     *
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("articles/{id}")
     */
    public function removeArticleAction(Article $article)
    {
        
        if (!$article) {
           return new JsonResponse(['message' => 'This Article is not found'], Response::HTTP_NOT_FOUND);
        }
        
        /* return a message and status_code when success */
        $this->get('app.article_manager')->removeArticle($article);
        return new JsonResponse(['message' => 'Article removed successfully']);
    }
}
