<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tinify;
use App\Http\Libraries\Tinypng;
use App\Http\Requests;

class ImageController extends Controller
{
	protected $_photo_path = 'images/';

    public function images(Request $request)
    {
    	

    	if ($request->file('file')) {
            $path = $this->_photo_path;
            foreach ($request->file('file') as $file) {
                $name = uniqid() . "_" .$file->getClientOriginalName();

               // $coverAbsoluteFilePath = $file->getRealPath();
                //$coverExtension = $file->getClientOriginalExtension();

                // optimize (overwrite)
              //  $opt = new ImageOptimizer();
               // $opt->optimizeImage($coverAbsoluteFilePath, $coverExtension);

            $file->move($path, $name);

            //unlink($path);

            }
        }

        $image = $path.$name;

        //dd($image);

    	$tinyfy = new Tinypng();

    	$tinyfy->optimize($image, $path, $name);

    	$optimized = $path."opti-".$name;

    	return response()->json(array('path'=>$path, 'name'=>"opti-".$name));

    }

    public function cropped(Request $request)
    {
    		dd($request->all());
    }

    public function readDir()
    {
    	$dir    = 'images';
		$files1 = scandir($dir);

		return view('pages.page', compact('dir', 'files1'));
    }
}
