<?php

namespace App\Traits;

use Symfony\Component\HttpFoundation\Response;


trait ResponseTrait
{

    private static $SUCCESS = Response::HTTP_OK;
//    private static $ERROR = Response::HTTP_BAD_REQUEST;

    /**
     * @param $result
     * @param $message
     * success response method.
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($result, $message = 'Success')
    {
        $response = [
            'status' => 200,
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, self::$SUCCESS);
    }

    /**
     * @param $error
     * @param $errorMessages
     * @param $status
     * return error response.
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $status = Response::HTTP_BAD_REQUEST)
    {
        $response = [
            'status' => $status,
            'success' => false,
            'data' => $error,
            'errors' => $this->reformatErrors($error),
            'message' => 'The given data was invalid ಠ╭╮ಠ.',
        ];
        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response, $status);
    }

    /**
     * reformat errors
     * @param $errors
     * @return array
     */
    public function reformatErrors($errors)
    {
        if (is_numeric($errors)||is_string($errors)||is_array($errors)||is_bool($errors))
            return $errors;

        $result = [];
        foreach ($errors->toArray() as $key => $error) {
            $result[$key] = $error;
            if (is_array($error)) {
                $result[$key] = $error[0];
            }
        }
        return $result;
    }
}
