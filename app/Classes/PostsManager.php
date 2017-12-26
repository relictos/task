<?php namespace App\Classes;

use App\Classes\DataSourceFactory;

class PostsManager{

  protected $factory;
  protected $config;
  protected $source;

  protected $cache = [];
  protected $cache_list_tag = 'posts_list';
  protected $cache_post_prefix = 'post_';

  public function __construct(DataSourceFactory $factory)
  {
    $this->factory = $factory; //Фабрика по производству источников данных для постов
    $this->getDataSource(); //Получаем оттуда источник данных по конфигу
  }

  /** Получает информацию о выбранном источнике данных из конфига
   * @return array
   */
  protected function getSourceConfig()
  {
    $default = config('posts.default');
    $this->config = config('posts.sources.'.$default);

    return $this->config;
  }

  /** Получает источник данных
   */
  protected function getDataSource()
  {
    $config = $this->getSourceConfig();
    $this->source = $this->factory->make($config);
  }

  //Получает элемент из кэша
  protected function loadFromCache($key)
  {
    if(isset($this->cache[$key]))
      return $this->cache[$key];

    $this->cache[$key] = cache($key);
    return $this->cache[$key];
  }

  //Сохраняет элемент в кэш
  protected function saveToCache($key, $data, $minutes = 60)
  {
    cache([$key => $data], $minutes);

    $this->cache[$key] = $data; //Чтобы лишний раз не обращаться к кэшу при вызове
  }

  //Получает список постов
  public function getList()
  {
    $posts = $this->loadFromCache($this->cache_list_tag);
    if($posts) return $posts;

    $posts = $this->source->getList();
    $this->saveToCache($this->cache_list_tag, $posts);

    return $posts;
  }

  //Получает пост
  public function getRec($id)
  {
    $rec = $this->loadFromCache($this->cache_post_prefix.$id);
    if($rec) return $rec;

    $rec = $this->source->getRec($id);

    if($rec)
      $this->saveToCache($this->cache_post_prefix.$id, $rec);

    return $rec;
  }
}