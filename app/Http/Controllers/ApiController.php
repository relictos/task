<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\PostsManager;

class ApiController extends Controller
{
  protected $posts;

  public function __construct(PostsManager $posts)
  {
    $this->posts = $posts;
  }

  //Получение списка постов
  public function getList()
  {
    cache()->delete('posts_list');
    $result = $this->posts->getList();

    return response()
        ->json($result)->header('x-total',count($result));
  }

  //Получение поста
  public function getRec($id)
  {
    $result = $this->posts->getRec($id);
    return response()->json($result);
  }
}
