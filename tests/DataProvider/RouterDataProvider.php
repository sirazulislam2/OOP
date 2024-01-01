<?php
namespace Tests\DataProvider;
class RouterDataProvider{
  public function RouteNotFoundCases(): array{
    return [
      ['/users','put'],
      ['/invoice','post'],
      ['/users','get'],
      ['/users','post']
    ];
  }
} 