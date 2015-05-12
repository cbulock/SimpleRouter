<?php
namespace cbulock\me\Tests;

class routerTest extends \PHPUnit_Framework_TestCase {

	protected $route;

	protected function setUp(){
		$this->route = new \stdClass();
		$this->route->map = new \stdClass();
		$this->route->not_found = '';
	}

	/**** get ****/
	public function test_get() {
		$url_part = '/TestPage';
		$this->route->map->TestPage = 'TestPage';
		$router = new \cbulock\Simple\Router($url_part, $this->route, '\cbulock\me\Tests\\');
		$result = $router->get();
		$this->assertEquals('hello world', $result, 'Invalid result from get');
	}

	/**** get_page ****/
	public function test_get_page() {
		$url_part = '/testurl/testdata';
		$router = new \cbulock\Simple\Router($url_part, $this->route, 'test');
		$result = $router->get_page();
		$this->assertEquals('testurl', $result, 'Invalid result from get_page');
	}
	public function test_get_page_multilevel() {
		$url_part = '/folder/testpage';
		$this->route->map->folder = new \stdClass();
		$this->route->map->folder->folder = new \stdClass();
		$this->route->map->folder->folder->TestPage = 'TestPage';
		$router = new \cbulock\Simple\Router($url_part, $this->route, 'test');
		$result = $router->get_page();
		$this->assertEquals('testpage', $result, 'Invalid result from get_page');
	}

	/**** get_data ****/
	public function test_get_data() {
		$url_part = '/testurl/testdata/otherdata';
		$router = new \cbulock\Simple\Router($url_part, $this->route, 'test');
		$result = $router->get_data(1);
		$this->assertEquals('testdata', $result, 'Invalid result from get_data');
		$result = $router->get_data(2);
		$this->assertEquals('otherdata', $result, 'Invalid result from get_data');
	}
	public function test_get_data_null() {
		$url_part = '/testurl';
		$router = new \cbulock\Simple\Router($url_part, $this->route, 'test');
		$result = $router->get_data(1);
		$this->assertNull($result, 'Expected NULL from get_data, other result returned');
	}

	/**** set_data ****/
	public function test_set_data() {
		$url_part = '/testurl/testdata/otherdata';
		$router = new \cbulock\Simple\Router($url_part, $this->route, 'test');
		$router->set_data(1, 'setdata');
		$result = $router->get_data(1);
		$this->assertEquals('setdata', $result, 'Invalid result after set_data');
	}

}

class TestPage {

	public function load() {
		return "hello world";
	}

}