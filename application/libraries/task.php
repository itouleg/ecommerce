<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Task
{
    public function render()
    {
        echo '<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="halflings-icon white tasks"></i>
            </a>
            <ul class="dropdown-menu tasks">
                <li class="dropdown-menu-title">
                    <span>You have 17 tasks in progress</span>
                    <a href="#refresh"><i class="icon-repeat"></i></a>
                </li>
                <li>
                    <a href="#">
                        <span class="header">
                            <span class="title">iOS Development</span>
                            <span class="percent"></span>
                        </span>
                        <div class="taskProgress progressSlim red">80</div> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="header">
                            <span class="title">Android Development</span>
                            <span class="percent"></span>
                        </span>
                        <div class="taskProgress progressSlim green">47</div> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="header">
                            <span class="title">ARM Development</span>
                            <span class="percent"></span>
                        </span>
                        <div class="taskProgress progressSlim yellow">32</div> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="header">
                            <span class="title">ARM Development</span>
                            <span class="percent"></span>
                        </span>
                        <div class="taskProgress progressSlim greenLight">63</div> 
                    </a>
                </li>
                <li>
                    <a href="#">
                        <span class="header">
                            <span class="title">ARM Development</span>
                            <span class="percent"></span>
                        </span>
                        <div class="taskProgress progressSlim orange">80</div> 
                    </a>
                </li>
                <li>
                    <a class="dropdown-menu-sub-footer">View all tasks</a>
                </li>	
            </ul>';
    }
}
?>
