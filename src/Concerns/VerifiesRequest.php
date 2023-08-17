<?php

namespace CenoteSolutions\LaravelQualtricsWebhooks\Concerns;

use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

trait VerifiesRequest
{
    /**
     * Verify the incoming encrypted request is a valid notification from Qualtrics.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string $sharedKey
     * @return string
     */
    protected function verifyEncrypted(Request $request, $sharedKey)
    {
        // Message is Base64 encoded for encrypted webhook event subscriptions.
        $this->verifyHashed($request, $sharedKey, 
            $message = base64_decode($this->getMessageRaw($request))    
        );

        // The method encryption algorithm to use depends on the lenght of the shared key
        $method = strlen($sharedKey) === 16 ? 'AES128' : 'AES256';

        if (! openssl_decrypt($message, $method, $sharedKey)) {
            $this->unverified();
        }

        return $message;
    }

    /**
     * Verify non-encrypted notification.
     * 
     * @param \Illuminate\Http\Request $request
     * @param string|null $sharedKey
     * @param string $message (optional)
     * @return string
     */
    protected function verifyHashed(Request $request, $sharedKey, $message = null)
    {
        if (! $request->filled('HMAC')) {
            $this->unverified();
        }
        
        $message = $message ?? $this->getMessageRaw($request);
        $validHash = hash_hmac('sha512', $message, $sharedKey, false);
        
        if (! hash_equals($validHash, $request->input('HMAC'))) {
            $this->unverified();
        }

        return $message;
    }
    
    /**
     * Throw an exception for an unverified notification request.
     * 
     * @throws \Symfony\Component\HttpKernel\Exception\BadRequestHttpException
     */
    protected function unverified()
    {
        throw new BadRequestHttpException;
    }
}