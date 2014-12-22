<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Messagealert
{
    public function alert($message=null,$type=null)
    {
        if($message!="")
        {
            echo '<div class="alert alert-'.$type.' center">
                <button type="button" class="close" data-dismiss="alert">×</button>
                '.$message.'
            </div>';
        }
    }
}
?>