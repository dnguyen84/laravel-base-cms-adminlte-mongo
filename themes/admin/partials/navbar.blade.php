<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        @env('BACKEND_SHOW_MESSAGES', 1)
        <li class="dropdown messages-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
                <li class="header">You have 4 messages</li>
                <li>
                    <!-- inner menu: contains the messages -->
                    <ul class="menu">
                        <li><!-- start message -->
                            <a href="#">
                                <div class="pull-left">
                                    <!-- User Image -->
                                    <img src="{{ Auth::user()->avatar->thumb }}" class="img-circle" alt="User Image" onerror="this.src=location.origin+'/admin/img/avatar5.png'" />
                                </div>
                                <!-- Message title and timestamp -->
                                <h4>
                                    Support Team
                                    <small><i class="fa fa-clock-o"></i> 5 mins</small>
                                </h4>
                                <!-- The message -->
                                <p>Why not buy a new awesome theme?</p>
                            </a>
                        </li><!-- end message -->
                    </ul><!-- /.menu -->
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
        </li><!-- /.messages-menu -->
        @endif

        @env('BACKEND_SHOW_NOTICES', 1)
        <!-- Notifications Menu -->
        <li class="dropdown notifications-menu">
            <!-- Menu toggle button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
                <li class="header">You have 10 notifications</li>
                <li>
                    <!-- Inner Menu: contains the notifications -->
                    <ul class="menu">
                        <li><!-- start notification -->
                            <a href="#">
                                <i class="fa fa-users text-aqua"></i> 5 new members joined today
                            </a>
                        </li><!-- end notification -->
                    </ul>
                </li>
                <li class="footer"><a href="#">View all</a></li>
            </ul>
        </li>
        @endif

        @env('BACKEND_SHOW_TASKS', 1)
        <!-- Tasks Menu -->
        <li class="dropdown tasks-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-flag-o"></i>
                <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
                <li class="header">You have 9 tasks</li>
                <li>
                    <!-- Inner menu: contains the tasks -->
                    <ul class="menu">
                        <li><!-- Task item -->
                            <a href="#">
                                <!-- Task title and progress text -->
                                <h3>
                                    Design some buttons
                                    <small class="pull-right">20%</small>
                                </h3>
                                <!-- The progress bar -->
                                <div class="progress xs">
                                    <!-- Change the css width attribute to simulate progress -->
                                    <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                        <span class="sr-only">20% Complete</span>
                                    </div>
                                </div>
                            </a>
                        </li><!-- end task item -->
                    </ul>
                </li>
                <li class="footer">
                    <a href="#">View all tasks</a>
                </li>
            </ul>
        </li>
        @endif

        @guest
            <li><a href="{{ url('/login') }}">Login</a></li>
        @else
            <!-- User Account Menu -->
            <li class="dropdown user user-menu">
                <!-- Menu Toggle Button -->
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <!-- The user image in the navbar-->
                    @if(Auth::user()->avatar->thumb)
                    <img src="{{ Auth::user()->avatar->thumb }}" class="user-image" alt="User Image" onerror="this.src=location.origin+'/admin/img/avatar5.png'" />
                    @endif
                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                    <span class="hidden-xs">{{ Auth::user()->name }}</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- The user image in the menu -->
                    <li class="user-header">
                        @if(Auth::user()->avatar->thumb)
                        <img src="{{ Auth::user()->avatar->thumb }}" class="img-circle" alt="User Image" onerror="this.src=location.origin+'/admin/img/avatar5.png'" />
                        @endif
                        <p>
                            {{ Auth::user()->name }}
                            <?php
                            $datec = Auth::user()['created_at'];
                            ?>
                            <small>Member since <?php echo date("M. Y", strtotime(Auth::user()->created)); ?></small>
                        </p>
                    </li>
                    <!-- Menu Body -->
                    @role("admin")
{{--                    <li class="user-body">--}}
{{--                        <div class="col-xs-6 text-center mb10">--}}
{{--                            <a href="{{ url(config('backend.route') . '/la_configs') }}"><i class="fa fa-cogs"></i> <span>Configure</span></a>--}}
{{--                        </div>--}}
{{--                    </li>--}}
                    @end
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="{{ url(config('backend.route') . '/users/') .'/'. Auth::user()->id }}" class="btn btn-default btn-flat">Profile</a>
                        </div>
                        <div class="pull-right">
                            <a href="{{ url('/logout') }}" class="btn btn-default btn-flat">Sign out</a>
                        </div>
                    </li>
                </ul>
            </li>
        @endif

        @env('BACKEND_SHOW_CONTROLS', 1)
        <!-- Control Sidebar Toggle Button -->
        <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-comments-o"></i> <span class="label label-warning">10</span></a>
        </li>
        @endif
    </ul>
</div>