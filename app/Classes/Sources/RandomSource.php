<?php namespace App\Classes\Sources;

use App\Classes\Sources\SourceBase;

class RandomSource extends SourceBase{

  protected $count = 1000;

  public function __construct(array $config = [])
  {
    parent::__construct($config);
  }

  //Генерация записи
  protected function generatePost($i, $extended = false): array
  {
    $result = [
        'id' => $i,
        'title' => 'Задача '.$i,
        'date' => now()->addHours($i)->format('Y-m-d H:i')];

    if($extended)
      $result = array_merge($result, [
        'author' => 'Автор '.$i,
        'status' => 'Статус '.$i,
        'description' => 'Описание '.$i
      ]);

    return $result;
  }

  //Список
  public function getList(): array
  {
    $posts = [];
    for($i = 1; $i <= $this->count; $i++)
    {
      $posts[] = $this->generatePost($i);
    }

    return $posts;
  }

  //Элемент
  public function getRec($id): array
  {
    if($id > $this->count)
      return [];

    return $this->generatePost($id, true);
  }
}