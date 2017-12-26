<?php namespace App\Classes;

use App\Classes\Sources\RandomSource;
use League\Flysystem\Exception;

class DataSourceFactory{

  public function __construct()
  {
    //
  }

  /**
   * Создает объект источника данных и возвращает его клиенту
   *
   * @param  array    $config
   * @return \App\Classes\Sources\SourceBase
   *
   * @throws \Exception
   */
  public function make(array $config)
  {
    if(!isset($config['type']))
      throw new \Exception('Cannot find type of data source in configuration data');

    $type = $config['type'];

    return $this->createDataSource($type,$config);
  }

  /**
   * Создает объект источника данных по входным параметрам
   *
   * @param  string   $type
   * @param  array    $config
   * @return \App\Classes\Sources\SourceBase
   *
   * @throws \Exception
   */
  protected function createDataSource($type, array $config = [])
  {
      switch ($type) {
        case 'random':
          return new RandomSource($config);
        break;
      }

      throw new Exception('Invalid data source type');
  }
}