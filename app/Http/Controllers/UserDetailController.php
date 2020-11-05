<?php

namespace App\Http\Controllers;
use App\UserDetail;
use Illuminate\Support\Facades\Storage;
use GrahamCampbell\Flysystem\Facades\Flysystem;
use DB;

class UserDetailController extends Controller
{
    public function createFile(){
        $fileData = UserDetail::all();
        //$query= "SELECT DISTINCT name,email from user_details";
        $query= "SELECT DISTINCT name,email from user_details";
        $results = DB::select(DB::raw($query));
      $transformedArray = $this->transformCollection(collect($results));

     // return $results;

        Storage::put('user_data/data.txt',$transformedArray);
        Flysystem::put('ftp_data.txt',Storage::get('user_data/data.txt'));
        return 'success';

    }


    private function transformCollection($collectionOutput){

        $completeOutput = '';
        foreach($collectionOutput as $key => $rowValue){
            $dataValue = '';
            foreach ($rowValue as $key=>$value){
                    $dataValue.= $value.'|';
            }
            $lastCharectorRemoved =  rtrim($dataValue, "|");

            $completeOutput.= $lastCharectorRemoved."\n";
        }
        return $completeOutput;
    }
}
