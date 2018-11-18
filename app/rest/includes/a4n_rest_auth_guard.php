<?php
    /*
    * Disable REST API
    *
    * Disable rest api except jetpack, Embed and contact form 7 by no auth user
    *
    * License: GPLv2 or later
    * Author: nendeb(https://nendeb.com/541)
    *
    */
    function a4n_rest_auth_guard( $result, $wp_rest_server, $request ){

        $namespaces = $request->get_route();

        // /oembed/1.0
        if( strpos( $namespaces, 'oembed/' ) === 1 ){
            return $result;
        }

        // /jetpack/v4
        if( strpos( $namespaces, 'jetpack/' ) === 1 ){
            return $result;
        }

        //contact form 7 (Ver4.7～)
        if( strpos( $namespaces, 'contact-form-7/' ) === 1 ){
            return $result;
        }

        if ( strpos( $namespaces, 'gpay/' ) === 1 ) {
            // if ( is_user_logged_in() ) {
                return $result;
            // }
        }

        //Gutenberg (Ver4.9?～)
        if ( current_user_can( 'edit_posts' ) ) {
            return $result;
        }

        $response = new WP_REST_Response(
            new WP_Error(
                'rest_disabled',
                __( 'The REST API on this site has been disabled.' ),
                array( 'status' => rest_authorization_required_code() )
            ));
        $response->set_status(401);


        return $response;
    }
    add_filter( 'rest_pre_dispatch', 'a4n_rest_auth_guard', 10, 3 );
