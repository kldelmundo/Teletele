<?

if ( ! function_exists('redirect'))
{
    function redirect($uri = '', $method = 'location', $http_response_code = 302)
    {
        // forcing session to be saved
        $CI =& get_instance();
        $CI->session->sess_write( TRUE );
        
        // codeigniter code
        if ( ! preg_match('#^https?://#i', $uri))
        {
            $uri = site_url($uri);
        }

        switch($method)
        {
            case 'refresh'    : header("Refresh:0;url=".$uri);
                break;
            default            : header("Location: ".$uri, TRUE, $http_response_code);
                break;
        }
        exit;
    }
}  