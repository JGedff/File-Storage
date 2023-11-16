<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use SimpleXMLElement;
use Illuminate\Support\Facades\Validator;

class formController extends Controller
{
    public function form() {
        return view('form');
    }

    public function redoForm(Request $req) {
        $name = $req->input('inputName');
        $surname = $req->input('inputSurname');
        $nif = $req->input('inputNif');
        $sex = $req->input('inputSex');
        $civilState = $req->input('inputCivilState');

        $nameError = !isset($name);
        $surnameError = !isset($surname);
        $nifError = !isset($nif) || !$this->isValidNif($nif);
        $sexError = !isset($sex);
        $civilError = !isset($civilState);

        return view('form', ['name' => $name, 'surname' => $surname, 'nif' => $nif, 'sex' => $sex,
            'civilState' => $civilState, 'nameError' => $nameError, 'surnameError' => $surnameError,
            'nifError' => $nifError, 'sexError' => $sexError, 'civilError' => $civilError,]);
    }

    public function isValidNif($nif) {
        $letters = 'TRWAGMYFPDXBNJZSQVHLCKE';
        $minLetters = 'trwagmyfpdxbnjzsqvhlcke';

        if (preg_match ('/^[0-9]{8}[A-Z]{1}$/', $nif) || preg_match ('/^[0-9]{8}[a-z]{1}$/', $nif) ) {
            $numbers = substr($nif, 0, 8);
            $nifLetter = $nif[8];

            return (strtoupper($nifLetter) == $letters[$numbers % 23]);
        }

        return false;
    }

    public function saveInfo(Request $req) {
        $validate = Validator::make($req->all(), [
            'inputName' => 'required',
            'inputSurname' => 'required',
            'inputNif' => 'required',
            'inputSex' => 'required',
            'inputCivilState' => 'required'
        ]);

        $name = $req->input('inputName');
        $surname = $req->input('inputSurname');
        $nif = $req->input('inputNif');
        $sex = $req->input('inputSex');
        $civilState = $req->input('inputCivilState');

        $nifError = !$this->isValidNif($nif);

        if ($validate->fails()) {
            return view('infoNotSaved', ['name' => $name, 'nifError' => $nifError, 'surname' => $surname, 'nif' => $nif, 'sex' => $sex, 'civilState' => $civilState]);
        } else {
            if (!$nifError) {
                $content = array("name" => "", "surname" => "", "nif" => "", "sex" => "", "civilState" => "");

                $content['name'] = $name;
                $content['surname'] = $surname;
                $content['nif'] = $nif;
                $content['sex'] = $sex;
                $content['civilState'] = $civilState;

                $this->saveFileLocal($content);

                //Create a xml element and save it
                $this->saveFilePublic($content);

                return view('infoSaved', ['name' => $name, 'surname' => $surname, 'nif' => $nif, 'sex' => $sex, 'civilState' => $civilState]);
            } else {
                return view('infoNotSaved', ['name' => $name, 'nifError' => $nifError, 'surname' => $surname, 'nif' => $nif, 'sex' => $sex, 'civilState' => $civilState]);
            }
        }
    }

    function saveFileLocal($jsonContent) {
        if (Storage::disk('local')->missing('allSubmits.json')) {
            $newJson = [];
            
            array_push($newJson, $jsonContent);
            $newFile = json_encode($newJson);

            Storage::disk('local')->put('allSubmits.json', $newFile);
        } else {
            $oldJson = Storage::disk('local')->json('allSubmits.json');

            array_push($oldJson, $jsonContent);
            $newJson = json_encode($oldJson);

            Storage::disk('local')->delete('allSubmits.json');
            Storage::disk('local')->put('allSubmits.json', $newJson);
        }
    }

    function arrayToXML($array, $toCheck = true) {
        $newXml = new SimpleXMLElement('<root/>');

        if (Storage::disk('public')->missing('allSubmits.xml')) {
            $newChild = $newXml->addChild('section');
            
            foreach ($array as $key => $value) {
                if(is_int($key))
                {
                    $key = 'Element'.$key;  //To avoid numeric tags like <0></0>
                }
                
                $newChild->addChild($key, $value);
            }
        } else {
            $newChild = $newXml->addChild('section');

            for ($i=0; $i < count($array); $i++) {
                if ($i == 0) {
                    foreach ($array[$i] as $element => $elementValue) {
                        if(is_int($element))
                        {
                            $element = 'Element'.$element;  //To avoid numeric tags like <0></0>
                        }

                        $newChild->addChild($element, $elementValue);
                    }
                } else {
                    $oldChilds = $newXml->addChild('section');

                    foreach ($array[$i] as $element => $elementValue) {
                        if(is_int($element))
                        {
                            $element = 'Element'.$element;  //To avoid numeric tags like <0></0>
                        }
                        
                        if (is_array($elementValue)) {
                            $this->recursiveAddElements($elementValue, $newXml);
                        } else {
                            $oldChilds->addChild($element, $elementValue);
                        }
                    }
                }
            }
        }

        if ($toCheck && !Storage::disk('public')->missing('allSubmits.xml')) {
            $xmlToCheck = $newXml->asXML();
            $xml = simplexml_load_string($xmlToCheck, "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);
            $newArray = [];

            for ($i=0; $i < count($array['section']); $i++) {
                if (!sizeof($array['section'][$i]) == 0) {
                    array_push($newArray, $array['section'][$i]);
                }
            }

            return $this->arrayToXML($newArray, false);
        } else {
            return $newXml->asXML();
        }
    }

    function recursiveAddElements($array, $newXml) {
        $oldChilds = $newXml->addChild('section');

        foreach ($array as $key => $value) {
            if(is_int($key))
            {
                $key = 'Element'.$key;  //To avoid numeric tags like <0></0> and be <Element0></Element0>
            }
            
            if (is_array($value)) {
                $this->recursiveAddElements($value, $newXml);
            } else {
                $oldChilds->addChild($key, $value);
            }
        }
    }

    function saveFilePublic($content) {
        if (Storage::disk('public')->missing('allSubmits.xml')) {
            $xmlContent = $this->arrayToXML($content);

            Storage::disk('public')->put('allSubmits.xml', $xmlContent);
        } else {
            $newContent = [];

            $storedXml = $this->getXMLInfo();
            $xml = simplexml_load_string($storedXml, "SimpleXMLElement", LIBXML_NOCDATA);
            $json = json_encode($xml);
            $array = json_decode($json,TRUE);

            array_push($newContent, $content);
            array_push($newContent, $array);

            $newXmlContent = $this->arrayToXML($newContent);

            Storage::disk('public')->delete('allSubmits.xml');
            Storage::disk('public')->put('allSubmits.xml', $newXmlContent);
        }
    }
    
    function showXMLInfo() {
        $xmlFile = $this->getXMLInfo();
        $xml = simplexml_load_string($xmlFile, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $info = json_decode($json);

        return view('xmlInfo', ['xml' => $info]);
    }

    function showXMLInfoUser($user) {
        $xmlFile = $this->getXMLInfo();
        $xml = simplexml_load_string($xmlFile, "SimpleXMLElement", LIBXML_NOCDATA);
        $json = json_encode($xml);
        $info = json_decode($json);
        $infoUser = [];

        foreach ($info->section as $key => $value) {
            if ($value->name == $user) {
                array_push($infoUser, $value);
            }
        }

        return view('xmlInfoUser', ['user' => $user, 'xml' => $infoUser]);
    }

    function getXMLInfo() {
        $value = Storage::disk('public')->get('allSubmits.xml');

        return $value;
    }

    function getJSONInfo() {
        $jsonFile = Storage::disk('local')->get('allSubmits.json');

        return json_decode($jsonFile);
    }

    function showJSONInfo() {
        $jsonInfo = $this->getJSONInfo();

        return view('jsonInfo', ['json' => $jsonInfo]);
    }

    function showJSONInfoUser($user) {
        $jsonInfo = $this->getJSONInfo();
        $infoUser = [];

        foreach ($jsonInfo as $key => $value) {
            if ($value->name == $user) {
                array_push($infoUser, $value);
            }
        }

        return view('xmlInfoUser', ['user' => $user, 'xml' => $infoUser]);
    }
}
