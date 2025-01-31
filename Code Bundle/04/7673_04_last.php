<?php

use Phalcon\Mvc\Model\Criteria,
    Phalcon\Paginator\Adapter\Model as Paginator;

class PostsController extends ControllerBase {

    /**
     * Index action
     */
    public function indexAction() {
        $numberPage = $this->request->getQuery("page", "int", 1);

        $posts = Posts::query()
            ->order("published")
            ->execute();

        $paginator = new Paginator(array(
            "data" => $posts,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Searches for posts
     */
    public function searchAction() {

        $numberPage = 1;
        if ($this->request->isPost()) {
            //$query = Criteria::fromInput($this->di, "Posts", $_POST);
            //$this->persistent->parameters = $query->getParams();
            $this->persistent->parameters = $this->request->getPost();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = array();
        }
        //$parameters["order"] = "id";
        $query = $parameters['body'];

        //$posts = Posts::find($parameters);
        $phql = "SELECT * FROM Posts WHERE body LIKE '%$query%' OR excerpt LIKE '%$query%' OR title LIKE '%$query%' ORDER BY id";
        $posts = $this->modelsManager->executeQuery($phql);
        if (count($posts) == 0) {
            $this->flash->notice("The search did not find any posts");
            return $this->dispatcher->forward(
                array(
                    "controller" => "posts",
                    "action" => "index"
                )
            );
        }

        $paginator = new Paginator(array(
            "data" => $posts,
            "limit" => 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displayes the creation form
     */
    public function newAction() {

    }

    /**
     * Edits a post
     *
     * @param string $id
     */
    public function editAction($id) {

        if (!$this->request->isPost()) {

            $post = Posts::findFirstByid($id);
            if (!$post) {
                $this->flash->error("post was not found");
                return $this->dispatcher->forward(
                    array(
                        "controller" => "posts",
                        "action" => "index"
                    )
                );
            }

            $this->view->id = $post->id;

            $this->tag->setDefault("id", $post->id);
            $this->tag->setDefault("title", $post->title);
            $this->tag->setDefault("body", $post->body);
            $this->tag->setDefault("excerpt", $post->excerpt);
            $this->tag->setDefault("published", $post->published);
            $this->tag->setDefault("updated", $post->updated);
            $this->tag->setDefault("pinged", $post->pinged);
            $this->tag->setDefault("to_ping", $post->to_ping);

        }
    }

    /**
     * Creates a new post
     */
    public function createAction() {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                array(
                    "controller" => "posts",
                    "action" => "index"
                )
            );
        }

        if (!$this->session->has("user_id")) {
            $this->flash->error("Please login to create a post");
            return $this->dispatcher->forward(
                array(
                    "controller" => "users",
                    "action" => "index"
                )
            );
        }

        $post = new Posts();

        $post->id = $this->request->getPost("id");
        $post->users_id = $this->session->get("user_id");
        $post->title = $this->request->getPost("title");
        $post->body = $this->request->getPost("body");
        $post->excerpt = $this->request->getPost("excerpt");
        $post->pinged = $this->request->getPost("pinged");
        $post->to_ping = $this->request->getPost("to_ping");


        if (!$post->save()) {
            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }
            return $this->dispatcher->forward(
                array(
                    "controller" => "posts",
                    "action" => "new"
                )
            );
        }

        $this->flash->success("post was created successfully");
        return $this->dispatcher->forward(
            array(
                "controller" => "posts",
                "action" => "index"
            )
        );

    }

    /**
     * Saves a post edited
     *
     */
    public function saveAction() {

        if (!$this->request->isPost()) {
            return $this->dispatcher->forward(
                array(
                    "controller" => "posts",
                    "action" => "index"
                )
            );
        }

        $id = $this->request->getPost("id");

        $post = Posts::findFirstByid($id);
        if (!$post) {
            $this->flash->error("post does not exist " . $id);
            return $this->dispatcher->forward(
                array(
                    "controller" => "posts",
                    "action" => "index"
                )
            );
        }

        $post->id = $this->request->getPost("id");
        $post->title = $this->request->getPost("title");
        $post->body = $this->request->getPost("body");
        $post->excerpt = $this->request->getPost("excerpt");
        $post->pinged = $this->request->getPost("pinged");
        $post->to_ping = $this->request->getPost("to_ping");


        if (!$post->save()) {

            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                array(
                    "controller" => "posts",
                    "action" => "edit",
                    "params" => array($post->id)
                )
            );
        }

        $this->flash->success("post was updated successfully");
        return $this->dispatcher->forward(
            array(
                "controller" => "posts",
                "action" => "index"
            )
        );

    }

    /**
     * Deletes a post
     *
     * @param string $id
     */
    public function deleteAction($id) {

        $post = Posts::findFirstByid($id);
        if (!$post) {
            $this->flash->error("post was not found");
            return $this->dispatcher->forward(
                array(
                    "controller" => "posts",
                    "action" => "index"
                )
            );
        }

        if (!$post->delete()) {

            foreach ($post->getMessages() as $message) {
                $this->flash->error($message);
            }

            return $this->dispatcher->forward(
                array(
                    "controller" => "posts",
                    "action" => "search"
                )
            );
        }

        $this->flash->success("post was deleted successfully");
        return $this->dispatcher->forward(
            array(
                "controller" => "posts",
                "action" => "index"
            )
        );
    }

    /**
     * Shows a post
     *
     * @param string $id
     */
    public function showAction($id) {

        if (!$this->request->isPost()) {

            $post = Posts::findFirstByid($id);
            if (!$post) {
                $this->flashSession->error("post was not found");
                $response = new \Phalcon\Http\Response();
                $response->setStatusCode(404, "Not Found");
                return $response->redirect("posts/index");
            }

        }

        $this->view->post = $post;
    }

}
