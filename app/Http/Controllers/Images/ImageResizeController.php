<?php

namespace App\Http\Controllers\Images;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class ImageResizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $path = getcwd()."/images/image.png";
        $ls = $this->ls('*','images/',true);
        foreach($ls as $item){
            $path = getcwd()."/images/".$item;
            $image = new \Gumlet\ImageResize($path);
            $image->resizeToLongSide(1500);
            $image->save($path);
        }
    }

    public static function ls($pattern="*", $folder="", $recursivly=false, $options=array('return_files','return_folders')) {
        if($folder) {
            $current_folder = realpath('.');
            if(in_array('quiet', $options)) { // If quiet is on, we will suppress the 'no such folder' error
                if(!file_exists($folder)) return array();
            }

            if(!chdir($folder)) return array();
        }


        $get_files    = in_array('return_files', $options);
        $get_folders= in_array('return_folders', $options);
        $both = array();
        $folders = array();

        // Get the all files and folders in the given directory.
        if($get_files) $both = glob($pattern, GLOB_BRACE + GLOB_MARK);
        if($recursivly or $get_folders) $folders = glob("*", GLOB_ONLYDIR + GLOB_MARK);

        //If a pattern is specified, make sure even the folders match that pattern.
        $matching_folders = array();
        if($pattern !== '*') $matching_folders = glob($pattern, GLOB_ONLYDIR + GLOB_MARK);

        //Get just the files by removing the folders from the list of all files.
        $all = array_values(array_diff($both,$folders));

        if($recursivly or $get_folders) {
            foreach ($folders as $this_folder) {
                if($get_folders) {
                    //If a pattern is specified, make sure even the folders match that pattern.
                    if($pattern !== '*') {
                        if(in_array($this_folder, $matching_folders)) array_push($all, $this_folder);
                    }
                    else array_push($all, $this_folder);
                }

                if($recursivly) {
                    // Continue calling this function for all the folders
                    $deep_items = ls($pattern, $this_folder, $recursivly, $options); # :RECURSION:
                    foreach ($deep_items as $item) {
                        array_push($all, $this_folder . $item);
                    }
                }
            }
        }

        if($folder) chdir($current_folder);
        return $all;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
