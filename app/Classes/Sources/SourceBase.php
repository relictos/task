<?php namespace App\Classes\Sources;

abstract class SourceBase{

  protected $config;

  public function __construct(array $config = [])
  {
    $this->config = $config;
  }

  abstract public function getList(): array;  //Список постов
  abstract public function getRec($id): array; //Конкретная запись

}