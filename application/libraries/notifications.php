<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Notifications
{
    public function render()
    {
        echo '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="halflings-icon white warning-sign"></i>
            </a>
            <ul class="dropdown-menu notifications">
                <li class="dropdown-menu-title">
                    <span>You have 11 notifications</span>
                    <a href="#refresh"><i class="icon-repeat"></i></a>
                </li>	
                <li>
                    <a href="#">
                        <span class="icon blue"><i class="icon-user"></i></span>
                        <span class="message">New user registration</span>
                        <span class="time">1 min</span> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon green"><i class="icon-comment-alt"></i></span>
                        <span class="message">New comment</span>
                        <span class="time">7 min</span> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon green"><i class="icon-comment-alt"></i></span>
                        <span class="message">New comment</span>
                        <span class="time">8 min</span> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon green"><i class="icon-comment-alt"></i></span>
                        <span class="message">New comment</span>
                        <span class="time">16 min</span> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon blue"><i class="icon-user"></i></span>
                        <span class="message">New user registration</span>
                        <span class="time">36 min</span> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon yellow"><i class="icon-shopping-cart"></i></span>
                        <span class="message">2 items sold</span>
                        <span class="time">1 hour</span> 
                    </a>
                </li>
                <li class="warning">
                    <a href="#">
                        <span class="icon red"><i class="icon-user"></i></span>
                        <span class="message">User deleted account</span>
                        <span class="time">2 hour</span> 
                    </a>
                </li>
                <li class="warning">
                    <a href="#">
                        <span class="icon red"><i class="icon-shopping-cart"></i></span>
                        <span class="message">New comment</span>
                        <span class="time">6 hour</span> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon green"><i class="icon-comment-alt"></i></span>
                        <span class="message">New comment</span>
                        <span class="time">yesterday</span> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="icon blue"><i class="icon-user"></i></span>
                        <span class="message">New user registration</span>
                        <span class="time">yesterday</span> 
                    </a>
                </li>
                <li class="dropdown-menu-sub-footer">
                    <a>View all notifications</a>
                </li>	
            </ul>';
    }
}
?>
