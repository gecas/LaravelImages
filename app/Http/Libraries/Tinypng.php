<?php 

namespace App\Http\Libraries;

use Tinify;

class Tinypng {

	protected $key;

	public function __construct()
	{
		
	}

	public function optimize($image, $path, $name)
	{
		try {
			Tinify\setKey("KVz5DQB1vaz67y35Y4xp-aFHvZxxfr91");

    		Tinify\fromFile($image)->toFile($path."opti-".$name);

		} catch(\Tinify\AccountException $e) {
		    print("The error message is: " + $e.getMessage());
		    // Verify your API key and account limit.
		} catch(\Tinify\ClientException $e) {
		    // Check your source image and request options.
		    print("The error message is: " + $e.getMessage());
		} catch(\Tinify\ServerException $e) {
		    // Temporary issue with the Tinify API.
		    print("The error message is: " + $e.getMessage());
		} catch(\Tinify\ConnectionException $e) {
		    // A network connection error occurred.
		    print("The error message is: " + $e.getMessage());
		} catch(Exception $e) {
		    // Something else went wrong, unrelated to the Tinify API.
		    print("The error message is: " + $e.getMessage());
		}
	}
}