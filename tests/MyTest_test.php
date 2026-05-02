<?php

namespace Tests;

use Php\Mvc\App\Http\Controllers\UserController;
use Php\Mvc\App\Http\Models\User;
use Php\Mvc\App\Http\Services\Request;
use PHPUnit\Framework\TestCase;

class MyTest_test extends TestCase {
  
  public function testStoreMethodSavesDataInDatabase()
  {
      // Create a request object
      $request = new Request();
      $request->name = "John Doe";
      $request->email ="johndoe@example.com";

      $controller = new UserController();
  
      // Call the store method and save the
      $controller->store($request);
  
      // Assert that the data is saved in the database
      $user = User::where('name','=','John Doe')->where('email','=','johndoe@example.com');
      $this->assertNotNull($user);

  }
  
protected function tearDown(): void
{
    // No need to drop the table or close the database connection as we are using a mock database
}
  
}
