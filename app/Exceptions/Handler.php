<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use App\InternalServerError;
use App\User;
use Osiset\ShopifyApp\Exceptions\MissingShopDomainException;
use Osiset\ShopifyApp\Exceptions\ApiException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        $this->get_error_message($exception);
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof MissingShopDomainException) {
            return redirect()->route('login');
        }

        // Handle try to login using closed Shopify Store
        if ($exception instanceof ApiException && $exception->getMessage() === "Not Found")
        {
            if (Auth::check()) {
                Auth::logout();
            }

            return redirect()->to('//'.$request->input('shop').'/admin/access_account');
        }
        elseif ($exception instanceof ApiException &&
               ($exception->getMessage() === 'Unavailable Shop' || $exception->getMessage() === 'Payment Required'))
        {
            if (Auth::check())
            {
                Auth::logout();
            }

            return redirect(route('login'))->withError($exception->getMessage());
        }

        // Handle Invalid Shopify Domain
        if ($this->isInvalidShopifyDomain($exception)) {
            return redirect()->back()->with('error', 'Shopify domain is required.');
        }

        if ($exception->getMessage() != null) {
            $error_first_string = '';

            if (config('logging.enable_stack_trace')) {
                $error_first_string = substr($exception->getTraceAsString(), 0, 150);
            }

            session(['error_message' => $exception->getMessage().$error_first_string]);

            return response()->make(view('errors.internal_server_error'), 500);
        } else {
            return parent::render($request, $exception);
        }
    }

    public function get_error_message($exception){
        if (!empty($exception->getMessage())) {
            $shop = Auth::user();

            if (isset($shop->id)) {
                $error_first_string = substr($exception->getTraceAsString(), 0, 300);

                InternalServerError::Create([
                    'user_id' => $shop->id,
                    'error_message' => $exception->getMessage(). $error_first_string,
                ]);
            }
        }
    }

    private function isInvalidShopifyDomain ($exception) {
        return str_contains($exception->getMessage(), 'ShopDomain::__construct() must be of the type string, null given');
    }
}
