<?php

namespace Gets\Klarna\Exceptions;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Utils;

class KlarnaException extends \Exception
{
    public static function fromResponse($responseContent, GuzzleException $previousException)
    {
        if ($previousException->getCode() === 401) {
            return new KlarnaInvalidConfig("Invalid klarna credentials", 0, $previousException);
        }
        $responseParsed = Utils::jsonDecode($responseContent);
        if (is_array($responseParsed) && !empty($responseParsed[0])) {
            $error = $responseParsed[0];
            switch ($error->errorCode) {
                default:
                    if (is_int($error->errorCode)) {
                        return new self($error->errorMessage, $error->errorCode, $previousException);
                    }

                    return new self($responseContent, 0, $previousException);
            }
        }
        if (isset($responseParsed->error_code)) {
            switch ($responseParsed->error_code) {
                case 'REFUND_NOT_ALLOWED':
                    return new KlarnaRefundNotAllowed(implode(',', $responseParsed->error_messages),
                        0, $previousException);
                case 'CAPTURE_NOT_ALLOWED':
                    return new KlarnaCaptureNotAllowed(implode(',', $responseParsed->error_messages),
                        0, $previousException);
                case 'CANCEL_NOT_ALLOWED':
                    return new KlarnaCancelNotAllowed(implode(',', $responseParsed->error_messages),
                        0, $previousException);

            }
        }

        return new self($responseContent, 0, $previousException);
    }

}