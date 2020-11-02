<?php

class Common
{
    public function unauthorizedUserResponse()
    {
        return $this->returnResponse(401, 'Unauthorized User', $this->generateFalseResponse());
    }

    public function getGenericResponse($key, $keyValue, $message)
    {
        $data = $this->createResultObject(true, $key, $keyValue);
        return $this->returnResponse(200, $message, $data);
    }

    public function getGenericErrorResponse($responseCode, $message)
    {
        return $this->returnResponse($responseCode, $message, $this->generateFalseResponse());
    }


    public function generateFalseResponse()
    {
        return (object)array('success' => false);
    }

    public function returnResponse($responseCode, $message, $result)
    {
        return array('status' => $responseCode, 'message' => $message, 'result' => $result);
    }

    public function createResultObject($success, $key, $data)
    {
        return ['success' => $success, $key => $data];
    }

    public function createObject($key, $value)
    {
        return (object)[$key => $value];
    }

}

?>