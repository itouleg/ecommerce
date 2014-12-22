<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Message
{
    public function render()
    {
        echo '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="halflings-icon white envelope"></i>
            </a>
            <ul class="dropdown-menu messages">
                <li class="dropdown-menu-title">
                    <span>You have 9 messages</span>
                    <a href="#refresh"><i class="icon-repeat"></i></a>
                </li>	
                <li>
                    <a href="#">
                        <span class="avatar"><img src="'.base_url('themes/metro/img/avatar.jpg').'" alt="Avatar"></span>
                        <span class="header">
                            <span class="from">
                                Dennis Ji
                            </span>
                            <span class="time">
                                6 min
                            </span>
                        </span>
                        <span class="message">
                            Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                        </span>  
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="avatar"><img src="'.base_url('themes/metro/img/avatar.jpg').'" alt="Avatar"></span>
                        <span class="header">
                            <span class="from">
                                Dennis Ji
                            </span>
                            <span class="time">
                                56 min
                            </span>
                        </span>
                        <span class="message">
                            Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                        </span>  
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="avatar"><img src="'.base_url('themes/metro/img/avatar.jpg').'" alt="Avatar"></span>
                        <span class="header">
                            <span class="from">
                                Dennis Ji
                            </span>
                            <span class="time">
                                3 hours
                            </span>
                        </span>
                        <span class="message">
                            Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                        </span>  
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="avatar"><img src="'.base_url('themes/metro/img/avatar.jpg').'" alt="Avatar"></span>
                        <span class="header">
                            <span class="from">
                                Dennis Ji
                            </span>
                            <span class="time">
                                yesterday
                            </span>
                        </span>
                        <span class="message">
                            Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                        </span>  
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="avatar"><img src="'.base_url('themes/metro/img/avatar.jpg').'" alt="Avatar"></span>
                        <span class="header">
                            <span class="from">
                                Dennis Ji
                            </span>
                            <span class="time">
                                Jul 25, 2012
                            </span>
                        </span>
                        <span class="message">
                            Lorem ipsum dolor sit amet consectetur adipiscing elit, et al commore
                        </span>  
                    </a>
                </li>
                <li>
                    <a class="dropdown-menu-sub-footer">View all messages</a>
                </li>	
            </ul>';
    }
}
?>
