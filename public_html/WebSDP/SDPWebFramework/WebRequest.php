<?php

define('NDS_PROXY_ERROR', 0);
define('HTTP_OK', 200);
define('HTTP_FOUND_REDIRECT', 302);
define('HTTP_BAD_REQUEST', 400);
define('HTTP_FILE_NOT_FOUND', 404);
define('HTTP_PROXY_AUTHORIZATION_FAILURE', 407);
define('COOKIE_FILE', '/tmp/cookie/curl_cookies.txt');

// Network Proxy
define ('NW_PROXY_ENABLED'  , false );
define ('NW_PROXY_USERNAME' , ''   );
define ('NW_PROXY_PASSWORD' , ''   );
define ('NW_PROXY_SERVER'   , ''   );
define ('NW_PROXY_PORT'     , ''   );

// Exception thrown when the expected HTTP return code is not received
class WebRequestException extends Exception {

    private $httpReturnCode = null;

    public function __construct($httpReturnCode, $message, $code = 0, $previous = null) {
        parent::__construct($message, $code, $previous);
        $this->httpReturnCode = $httpReturnCode;
    }

    public function getHttpReturnCode() {
        return $this->httpReturnCode;
    }

}

// for HTTP, see ftp://ftp.isi.edu/in-notes/rfc2616.txt
// makes an HTTP request of the specified type
class WebRequest {

    private static $userAgent = 'Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.0.6) Gecko/2009020911 Ubuntu/8.10 (intrepid) Firefox/3.0.6';
    protected $connection = false;
    private $headersRequested = false;
    public $headers;


    /* -----------------------------------------------------------------
      configure HTTP request
      ----------------------------------------------------------------- */

    public function __construct() {
        $this->connection = curl_init();

        curl_setopt($this->connection, CURLOPT_RETURNTRANSFER, true); // return the HTTP reply as a String, not to stdout
        curl_setopt($this->connection, CURLOPT_HTTPGET, true); // set the HTTP request method to GET
        curl_setopt($this->connection, CURLOPT_TIMEOUT, 20); // maximum execution time (seconds) for CURL functions
        curl_setopt($this->connection, CURLOPT_USERAGENT, self::$userAgent);
        curl_setopt($this->connection, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->connection, CURLOPT_COOKIEJAR, COOKIE_FILE);
        curl_setopt($this->connection, CURLOPT_COOKIEFILE, COOKIE_FILE);

        // Hack to avoid checking SSL certificate
        // TODO fix this
        curl_setopt($this->connection, CURLOPT_SSL_VERIFYPEER, false);

        if (NW_PROXY_ENABLED) {
            curl_setopt($this->connection, CURLOPT_PROXY, NW_PROXY_SERVER . ':' . NW_PROXY_PORT);
            if (strlen(NW_PROXY_USERNAME) > 0) {
                curl_setopt($this->connection, CURLOPT_PROXYUSERPWD, NW_PROXY_USERNAME . ':' . NW_PROXY_PASSWORD);
            }
        }

        // Transfer cookies
        $cookies = array();
        foreach ($_COOKIE as $key => $value) {
            $cookies[] = $key . '=' . $value;
        }
        $cookies = implode('; ', $cookies);
        curl_setopt($this->connection, CURLOPT_COOKIE, $cookies);
    }

    public function __destruct() {
        curl_close($this->connection);
    }

    public function setTimeout($timeout) {
        curl_setopt($this->connection, CURLOPT_TIMEOUT, $timeout);
    }

    public function followRedirects($redirects) {
        curl_setopt($this->connection, CURLOPT_FOLLOWLOCATION, $redirects);
    }

    public function setRequestHeader($array) {
        curl_setopt($this->connection, CURLOPT_HTTPHEADER, $array);
    }

    // mark this as a new cookie "session". It will force libcurl to ignore all cookies it is about to load
    public function ignoreSessionCookies($ignore) {
        curl_setopt($this->connection, CURLOPT_COOKIESESSION, $ignore);
    }

    public static function enableProxy($isEnabled) {
        self::$useProxy = $isEnabled;
    }

    // The contents of the "Cookie: " header to be used in the HTTP request.
    // Note that multiple cookies are separated with a semicolon followed by a space (e.g., "fruit=apple; colour=red")
    public function setCookie($cookies) {
        curl_setopt($this->connection, CURLOPT_COOKIE, $cookies);
    }

    public function setCredentials($credentials) {
        curl_setopt($this->connection, CURLOPT_USERPWD, $credentials);
    }

    /* -----------------------------------------------------------------
      configure HTTP response
      ----------------------------------------------------------------- */

    public function getRequestHeader($requestHeader) {
        $this->headersRequested = $requestHeader;
        curl_setopt($this->connection, CURLOPT_HEADER, $requestHeader);
    }

    /* -----------------------------------------------------------------
      make HTTP request
      ----------------------------------------------------------------- */

    public function httpGetDuration($url, &$duration) {
        curl_setopt($this->connection, CURLOPT_URL, $url);
        $started = microtime(true);
        $page = curl_exec($this->connection);
        $duration = microtime(true) - $started;
        return $page;
    }

    private function parse_headers($header) {
        $this->headers = array();
        $lines = preg_split('/[\r\n]+/', $header);
        foreach ($lines as $line) {
            // Propagate headers to response.
            header($line);

            // Store for client use
            $line_array = explode(': ', $line);
            if (count($line_array) == 2) {
                $key = $line_array[0];
                $value = $line_array[1];
                if ($key && $value) {
                    $this->headers[$key] = $value;
                }
            }
        }
    }

    //  returns page content if successful. If desiredHttpReturn is not retrieved, returns null
    public function httpGet($url, $desiredHttpReturn = '200') {
        curl_setopt($this->connection, CURLOPT_HTTPGET, true);
        curl_setopt($this->connection, CURLOPT_URL, $url);
        curl_setopt($this->connection, CURLOPT_CUSTOMREQUEST, 'GET');

        $ret = curl_exec($this->connection);

        if ($ret === false) {
            error_log("WARNING: WebRequest : httpGet : problem with url($url)");
            throw new Exception("problem with url($url): " . curl_error($this->connection), curl_errno($this->connection));
        }

        // Only do this if headers are requested
        if ($this->headersRequested) {
            list( $header, $ret ) = preg_split('/([\r\n][\r\n])\\1/', $ret, 2);
            if ($header)
                $this->parse_headers($header);
        }

        if ($desiredHttpReturn && !$this->checkHttpReturnCode($desiredHttpReturn)) {
            $msg = "WebRequest:httpGet : problem with url($url) return code: " . $this->getHttpReturnCode() . " return($ret)";
            error_log("WARNING: " . $msg);
            throw new WebRequestException($this->getHttpReturnCode(), $msg);
        }

        return $ret;
    }

    //  returns page content if successful. If desiredHttpReturn is not retrieved, returns null
    public function httpPost($url, $args = null, $desiredHttpReturn = '201', $verb='POST') {
        $ret = null;

        curl_setopt($this->connection, CURLOPT_URL, $url);
        if (!$verb) {
            curl_setopt($this->connection, CURLOPT_POST, true);
            if ($args)
                curl_setopt($this->connection, CURLOPT_POSTFIELDS, $args);
        }
        else {// eg. PUT or DELETE
            curl_setopt($this->connection, CURLOPT_CUSTOMREQUEST, $verb);
            if ($args)
                curl_setopt($this->connection, CURLOPT_POSTFIELDS, $args);
        }

        $ret = curl_exec($this->connection);
        if ($ret === false) {
            error_log("WARNING: WebRequest : httpGet : problem with url($url)");
            throw new Exception(curl_error($this->connection), curl_errno($this->connection));
        }

        if ($desiredHttpReturn && !$this->checkHttpReturnCode($desiredHttpReturn)) {
            error_log("WARNING: WebRequest : httpPost : problem with url($url) args($args)");
        }

        return $ret;
    }

    public function httpTrace($url) {
        curl_setopt($this->connection, CURLOPT_CUSTOMREQUEST, 'TRACE');
        curl_setopt($this->connection, CURLOPT_PORT, 80);
        curl_setopt($this->connection, CURLOPT_URL, $url);

        $page = curl_exec($this->connection);

        return $page;
    }

    public function httpPut($url, $args, $desiredHttpReturn = '200') {
        return $this->httpPost($url, $args, $desiredHttpReturn, $verb = 'PUT');
    }

    public function httpDelete($url, $args, $desiredHttpReturn = '200') {
        curl_setopt($this->connection, CURLOPT_NOBODY, TRUE);
        return $this->httpPost($url, $args, $desiredHttpReturn, $verb = 'DELETE');
    }

    public function httpConnect($url, $args, $desiredHttpReturn = '200') {
        return $this->httpPost($url, $args, $desiredHttpReturn, $verb = 'CONNECT');
    }

    /* -----------------------------------------------------------------
      after request...
      ----------------------------------------------------------------- */

    // returns true of code OK, false otherwise
    public function checkHttpReturnCode($desiredCode) {
        $ret = true;

        if (($code = $this->getHttpReturnCode()) != $desiredCode) {
            error_log("WARNING: WebRequest : checkHttpReturnCode : HTTP return desired($desiredCode) got($code)");
            $ret = false;
        }

        return $ret;
    }

    public function getHttpReturnCode() {
        return curl_getinfo($this->connection, CURLINFO_HTTP_CODE);
    }

    public function getEffectiveURL() {
        return curl_getinfo($this->connection, CURLINFO_EFFECTIVE_URL);
    }

}

?>
