<?php

class Common
{

    public function unauthorizedUserResponse()
    {
        $errREsponse = $this->generateFalseResponse();
        return $this->returnResponse(401, 'Unauthorized User', $errREsponse);
    }

    public function getGenericResponse($key, $keyValue, $message)
    {
        $data = $this->createResultObject(true, $key, $keyValue);
        return $this->returnResponse(200, $message, $data);
    }

    public function getDualGenericResponse($key, $keyValue, $key1, $keyValue1, $message)
    {
        $data = array('success' => true, $key => $keyValue, $key1 => $keyValue1);
        return $this->returnResponse(200, $message, $data);
    }

    public function getGenericErrorResponse($responseCode, $message)
    {
        $errREsponse = $this->generateFalseResponse();
//        print_r($errREsponse);
        return $this->returnResponse($responseCode, $message, $errREsponse);
    }


    public function generateFalseResponse()
    {
        return array('success' => 'false');
    }

    public function returnResponse($responseCode, $message, $result)
    {
        return array('status' => $responseCode, 'message' => $message, 'result' => $result);
    }

    public function createResultObject($success, $key, $data)
    {
        return array('success' => $success, $key => $data);
    }

    public function createObject($key, $value)
    {
        return (object)[$key => $value];
    }

}

?>