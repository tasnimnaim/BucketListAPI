<?php

namespace App\Http\Controllers;

use App\Models\BucketList;
use Illuminate\Http\Request;


class BucketListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function allList()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://onboardme-beta.celcom.com.my/api/bucket-lists/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        $responseAll = json_decode($response);
        curl_close($curl);
        
     return view('allList')->with('responseAll', $responseAll);
    }

    public function getMyList()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://onboardme-beta.celcom.com.my/api/bucket-lists/tasnimmohdnaim@gmail.com',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        $responseMine = json_decode($response);
        curl_close($curl);
        $myEmail = 'tasnimmohdnaim@gmail.com';
     return view('myList')->with('responseMine', $responseMine)->with('myEmail', $myEmail);
    }

    public function addMyList(Request $request)
    {
            
        $request->validate([
            'inputBucket'=>'required'
        ]);
        $inputBucketRaw = $request->input('inputBucket');
        $inputBucket = [];
        foreach($inputBucketRaw as $inputRaw)
        {
            $inputBucket[] = [
                'items' => $inputRaw
            ];
        }
        $encodeInputBucket = json_encode($inputBucket);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://onboardme-beta.celcom.com.my/api/bucket-lists/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'    {          
                  "email": "tasnimmohdnaim@gmail.com",
                  "bucketItems": '. $encodeInputBucket .'
              }
          ',
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json'
            ),
          ));
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
        return redirect('MyList')->with('status', 'Your Bucket List Items Has Been Added!');
    }
    
    public function updateMyList(Request $request)
    {
        
        $request->validate([
            'inputBucket'=>'required'
        ]);
        $inputBucketRaw = $request->input('inputBucket');
        $inputBucket = [];
        foreach($inputBucketRaw as $inputRaw)
        {
            $inputBucket[] = [
                'items' => $inputRaw
            ];
        }
       
        $encodeInputBucket = json_encode($inputBucket);
        $curl = curl_init();
       
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://onboardme-beta.celcom.com.my/api/bucket-lists/tasnimmohdnaim@gmail.com',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'PUT',
          CURLOPT_POSTFIELDS =>'    {
                "bucketItems": '. $encodeInputBucket .'
            }
        ',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        
        curl_close($curl);
        echo $response;
        return redirect('MyList')->with('status', 'Your Bucket List Items Has Been Updated!');
    }
    public function deleteMyList(){ 
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://onboardme-beta.celcom.com.my/api/bucket-lists/tasnimmohdnaim@gmail.com',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        return redirect('MyList')->with('status', 'Your Bucket List Items Has Been Deleted!');
    }

    public function editMyItem(Request $request, $id)
    {
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://onboardme-beta.celcom.com.my/api/bucket-lists/tasnimmohdnaim@gmail.com',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        $responseMine = json_decode($response);
        curl_close($curl);

        $inputBucketRaw = $request->input('inputBucket');
        $inputBucket = [];
        foreach($responseMine as $res){
            foreach($res->bucketItems as $res2){
                if ($res2->id==$id){
                    $inputBucket[] = [
                        'items' => $inputBucketRaw
                    ];
                }
                else{
                    $inputBucket[] = [
                        'items' => $res2->items
                    ];
                }
            }
        }
   
        $encodeInputBucket = json_encode($inputBucket);
        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => 'http://onboardme-beta.celcom.com.my/api/bucket-lists/tasnimmohdnaim@gmail.com',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'PUT',
          CURLOPT_POSTFIELDS =>'    {         
                "bucketItems": '. $encodeInputBucket .'
            }
        ',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        
        $response = curl_exec($curl);
        curl_close($curl);
        echo $response;
        return redirect('MyList')->with('status', 'Your Bucket List Item Has Been Updated!');
    }
    public function deleteMyItem($id)
    {
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://onboardme-beta.celcom.com.my/api/bucket-lists/tasnimmohdnaim@gmail.com',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        $responseMine = json_decode($response);
        curl_close($curl);

        $inputBucket = [];
        foreach($responseMine as $res){
            if(count($res->bucketItems)==1){
                $curl = curl_init();

                curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://onboardme-beta.celcom.com.my/api/bucket-lists/tasnimmohdnaim@gmail.com',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                ));
        
                $response = curl_exec($curl);
               
                curl_close($curl);
                echo $response;

            }
            else{
                foreach($res->bucketItems as $res2){
                    if ($res2->id==$id){
                    }
                    else{
                        $inputBucket[] = [
                            'items' => $res2->items
                        ];
                    }
                }
            }
            
        }
        if(!empty($inputBucket)){
           
            $encodeInputBucket = json_encode($inputBucket);
            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://onboardme-beta.celcom.com.my/api/bucket-lists/tasnimmohdnaim@gmail.com',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_POSTFIELDS =>'    {         
                    "bucketItems": '. $encodeInputBucket .'
                }
            ',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
            ));
            
            $response = curl_exec($curl);
            curl_close($curl);
            echo $response;
        }
        return redirect('MyList')->with('status', 'Your Bucket List Item Has Been Deleted!');
        
    }


}
