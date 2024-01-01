<?php
namespace Tests\Unit;

use App\Exception\RouteNotFoundException;
use App\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase{

  private Router $router;

  public function setUp(): void{
    parent::SetUp();
    $this->router = new Router();
  }

  public function test_it_register_a_route(){

    $this->router->register('get','/users',['Users','index']);

    $expected = [
      'get' => [
        '/users' => ['Users','index']
      ]
      ];
    $this->assertEquals($expected,$this->router->routes());
  }

  public function test_it_register_a_get_route():void{
    $this->router->get('/users',['Users','index']);
    $expected = [
      'get' => [
        '/users' => ['Users','index']
      ],
    ];

    $this->assertEquals($expected,$this->router->routes());
  }

  public function test_it_register_a_post_route():void{
    $this->router->post('/home',['HomeController','store']);
    $expected = [
      'post' => [
        '/home' => ['HomeController','store']
      ],
    ];

    $this->assertEquals($expected,$this->router->routes());
  }

  public function test_there_are_no_route_when_router_is_created():void{
    $this->assertEmpty((new Router)->routes());
  }

  /**
   * @dataProvider \Tests\DataProvider\RouterDataProvider::RouteNotFoundCases
   */

  public function test_it_throw_route_not_found_excepiton(
    string $requestUri,string $requestMethod
  ):void{
    $users = new class(){
      public function delete(){
        return true;
      }
    };

    $this->router->post('/users',[$users::class,'index']);
    $this->router->get('/users',['User','post']);

    $this->expectException(RouteNotFoundException::class);
    $this->router->resolve($requestUri,$requestMethod);
  }

  public function test_it_resolve_a_route_from_a_clouser():void{
    $this->router->get('/users', fn() => [1,2,3]);
    $this->assertEquals(
        [1,2,3],
        $this->router->resolve('/users','get')
      );
    
  }

  public function test_it_resolve_a_route():void{
    $user = new class(){
      public function index():array{
        return [1,2,3];
      }
    };

    $this->router->get('/users',[$user::class,'index']);

    $this->assertEquals([1,2,3],$this->router->resolve('/users','get'));
  }

} 