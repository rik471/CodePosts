<?php


namespace CodePress\CodePosts\Controller;

use CodePress\CodePosts\Repository\PostRepositoryInterface;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;

class AdminPostsController extends Controller
{
    private $repository;
    private $response;

    public function __construct(ResponseFactory $response, PostRepositoryInterface $repository)
    {
        $this->response = $response;
        $this->repository = $repository;
    }

    public function index()
    {
        $posts = $this->repository->all();
        return $this->response->view('codepost::index', compact('posts'));
    }

    public function create()
    {
        $posts = $this->repository->all();
        return view('codepost::create', compact('posts'));
    }

    public function store(Request $request)
    {
        $this->repository->create($request->all());
        return redirect()->route('admin.posts.index');
    }

    public function edit($id)
    {
        $post = $this->repository->find($id);
        $posts = $this->repository->all();
        return $this->response->view('codepost::edit', compact('post', 'posts'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $category = $this->repository->update($data, $id);
        return redirect()->route('admin.posts.index');
    }
}