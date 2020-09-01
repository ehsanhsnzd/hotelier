<?php


namespace Hotel\app\Exceptions;


use Doctrine\Instantiator\Exception\UnexpectedValueException;
use Hotel\app\Traits\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Container\EntryNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Translation\Exception\NotFoundResourceException;

trait ExceptionHandler
{
    use ApiResponse;


    public function handleException($request,  $e,$httpCode=null,$status = 'Failed')
    {

        if($e instanceof NotFoundHttpException ) {
            return $this->handle($e,$e->getMessage(),$this->getHttpCode(404,$httpCode),$e->getCode(),$status);

        } elseif($e instanceof NotFoundResourceException ) {
            return $this->handle($e,$e->getMessage() ,$this->getHttpCode(404,$httpCode),$e->getCode(),$status);

        } elseif($e instanceof ModelNotFoundException) {
            return $this->handle($e,$e->getMessage(),$this->getHttpCode(404,$httpCode),$e->getCode(),$status);

        }elseif($e instanceof EntryNotFoundException) {
            return $this->handle($e,$e->getMessage(),$this->getHttpCode(404,$httpCode),$e->getCode(),$status);

        } elseif($e instanceof AccessDeniedException) {
            return $this->handle($e,$e->getMessage(),$this->getHttpCode(403,$httpCode),$e->getCode(),$status);

        }elseif($e instanceof AuthorizationException) {
            return $this->handle($e,$e->getMessage() ,$this->getHttpCode(401,$httpCode),$e->getCode(),$status);

        }elseif($e instanceof UnauthorizedException) {
            return $this->handle($e,$e->getMessage() ,$this->getHttpCode(401,$httpCode),$e->getCode(),$status);

        }elseif($e instanceof QueryException) {
            return $this->handle($e, $e->getMessage(), $this->getHttpCode(409, $httpCode), $e->getCode(), $status);
        } elseif($e instanceof UnexpectedValueException) {
            return $this->handle($e,$e->getMessage() ,$this->getHttpCode(400,$httpCode),$e->getCode(),$status);

        }elseif ($e instanceof ValidationException) {
            $e = $this->convertValidationExceptionToResponse($e, $request);
            return $this->setMetaData([], ["validation" => $e->getOriginalContent()])->badRequestResponse();
        }else {
            return $this->customResponse($e,$status,500,$e->getCode());
            return $this->failedResponse();
        }

    }


    //status default is Failed


    /**
     * @param        $e
     * @param        $message
     * @param        $httpCode
     * @param        $statusCode
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    private function handle(\Exception $e , $message , $httpCode , $statusCode , $status)
    {
        return $this->customResponse($message,$status,$httpCode,$statusCode);
    }

    private function getHttpCode($defaultHttpCode,$currentHttpCode)
    {
        $httpCode = $defaultHttpCode;
        if(isset($currentHttpCode) && $currentHttpCode != null) {
            $httpCode = $currentHttpCode;
        }
        return $httpCode;
    }
}
