<?php
    /**
    *  [setPassword 加密]
    *  @author Sow
    *  @DateTime 2017-06-03T14:48:58+0800
    *  @param    [type]                   $password [description]
    */
    if ( !function_exists('setMd5')) {
        function setMd5($password){
            return sha1(md5( $password . '?85efab7c93b7df35b7942ddf0cdce92b3d47edf7?' ));
        }
    }
?>