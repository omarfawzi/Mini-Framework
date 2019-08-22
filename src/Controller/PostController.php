<?php

namespace App\Controller;

use App\View;
use Exception;
use Symfony\Component\HttpFoundation\Request;

class PostController extends AbstractController
{
    /**
     * @param Request $request
     * @return string
     * @throws Exception
     */
    public static function index(Request $request)
    {
        return View::render("posts.php", ['name' => $request->get('name')]);
    }

    public function show(Request $request, int $id)
    {
        // TODO: Implement show() method.
    }

    public function save(Request $request)
    {
        // TODO: Implement save() method.
    }

    public function update(Request $request, int $id)
    {
        // TODO: Implement update() method.
    }

    public function destroy(int $id)
    {
        // TODO: Implement destroy() method.
    }
}